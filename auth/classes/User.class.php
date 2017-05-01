<?php
 
/**
 * User class
 */

class User
{

  public $errors;


  /**
   * Magic getter - read data from a property that isn't set yet
   *
   * @param string $name  Property name
   * @return mixed
   */
   public function __get($name)
   {
   }

  
  /**
   * Get a page of user records and the previous and next page (if there are any)
   *
   * @param string $page  Page number
   * @return array        Previous page, next page and user data. Page elements are null if there isn't a previous or next page.
   */
  public static function paginate($page)
  {
    $data = [];
    $users_per_page = 5;

    // Calculate the total number of pages
    $total_users = static::_getTotalUsers();
    $total_pages = (int) ceil($total_users / $users_per_page);
      

    // Make sure the current page is valid
    $page = (int) $page;

    if ($page < 1) {
      $page = 1;
    } elseif ($page > $total_pages) {
      $page = $total_pages;
    }


    // Calculate the next and previous pages
    $data['previous'] = $page == 1 ? null : $page - 1;
    $data['next'] = $page == $total_pages ? null : $page + 1;


    // Get the page of users
    try {

      $db = Database::getInstance();

      $offset = ($page - 1) * $users_per_page;

      $data['users'] = $db->query("SELECT * FROM users ORDER BY email LIMIT $users_per_page OFFSET $offset")->fetchAll();

    } catch(PDOException $exception) {

      error_log($exception->getMessage());

      $data['users'] = [];
    }

    return $data;
  }


  /**
   * Authenticate a user by email and password
   *
   * @param string $email     Email address
   * @param string $password  Password
   * @return mixed            User object if authenticated correctly, null otherwise
   */
  public static function authenticate($email, $password)
  {
    $user = static::findByEmail($email);

    if ($user !== null) {

      // Check the user has been activated
      if ($user->is_active) {

        // Check the hashed password stored in the user record matches the supplied password
        if (Hash::check($password, $user->password)) {
          return $user;
        }
      }
    }
  }


  /**
   * Find the user with the specified ID
   *
   * @param string $id  ID
   * @return mixed      User object if found, null otherwise
   */
  public static function findByID($id)
  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
      $stmt->execute([':id' => $id]);
      $user = $stmt->fetchObject('User');

      if ($user !== false) {
        return $user;
      }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }
  

  /**
   * Get the user by ID or display a 404 Not Found page if not found.
   *
   * @param array $data  $_GET data
   * @return mixed       User object if found, null otherwise
   */
  public static function getByIDor404($data)
  {
    if (isset($data['id'])) {
      $user = static::findByID($data['id']);

      if ($user !== null) {
        return $user;
      }
    }

    Util::showNotFound();
  }


  /**
   * Find the user with the specified email address
   *
   * @param string $email  email address
   * @return mixed         User object if found, null otherwise
   */
  public static function findByEmail($email)
  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
      $stmt->execute([':email' => $email]);
      $user = $stmt->fetchObject('User');

      if ($user !== false) {
        return $user;
      }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }
  

  /**
   * Signup a new user
   *
   * @param array $data  POST data
   * @return User
   */
  public static function signup($data)
  {
    // Create a new user model and set the attributes
    $user = new static();

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->password = $data['password'];

    if ($user->isValid()) {

      // Generate a random token for activation and base64 encode it so it's URL safe
      $token = base64_encode(uniqid(rand(), true));
      $hashed_token = sha1($token);

      try {

        $db = Database::getInstance();

        $stmt = $db->prepare('INSERT INTO users (name, email, password, activation_token) VALUES (:name, :email, :password, :token)');
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':password', Hash::make($user->password));
        $stmt->bindParam(':token', $hashed_token);

        $stmt->execute();

        // Send activation email
        $user->_sendActivationEmail($token);

      } catch(PDOException $exception) {

        // Log the exception message
        error_log($exception->getMessage());
      }
    }

    return $user;
  }


  /**
   * Find the user by remember token
   *
   * @param string $token  token
   * @return mixed         User object if found, null otherwise
   */
  public static function findByRememberToken($token)
  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT u.* FROM users u JOIN remembered_logins r ON u.id = r.user_id WHERE token = :token');
      $stmt->execute([':token' => $token]);
      $user = $stmt->fetchObject('User');

      if ($user !== false) {
        return $user;
      }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }


  /**
   * Deleted expired remember me tokens
   *
   * @return integer  Number of tokens deleted
   */
  public static function deleteExpiredTokens()
  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare("DELETE FROM remembered_logins WHERE expires_at < '" . date('Y-m-d H:i:s') . "'");
      $stmt->execute();

      return $stmt->rowCount();

    } catch(PDOException $exception) {

      // Log the detailed exception
      error_log($exception->getMessage());
    }

    return 0;
  }

  
  /**
   * Find the user for password reset, by the specified token and check the token hasn't expired
   *
   * @param string $token  Reset token
   * @return mixed         User object if found and the token hasn't expired, null otherwise
   */
  public static function findForPasswordReset($token)
  {
    $hashed_token = sha1($token);

    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT * FROM users WHERE password_reset_token = :token LIMIT 1');
      $stmt->execute([':token' => $hashed_token]);
      $user = $stmt->fetchObject('User');

      if ($user !== false) {

        // Check the token hasn't expired
        $expiry = DateTime::createFromFormat('Y-m-d H:i:s', $user->password_reset_expires_at);

        if ($expiry !== false) {
          if ($expiry->getTimestamp() > time()) {
            return $user;
          }
        }
      }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }


  /**
   * Activate the user account, nullifying the activation token and setting the is_active flag
   *
   * @param string $token  Activation token
   * @return void
   */
  public static function activateAccount($token)
  {
    $hashed_token = sha1($token);

    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('UPDATE users SET activation_token = NULL, is_active = TRUE WHERE activation_token = :token');
      $stmt->execute([':token' => $hashed_token]);

    } catch(PDOException $exception) {

      // Log the detailed exception
      error_log($exception->getMessage());
    }
  }


  /**
   * Delete the user.
   *
   * @return void
   */
  public function delete()
  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
      $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
      $stmt->execute();

    } catch(PDOException $exception) {

      // Log the detailed exception
      error_log($exception->getMessage());
    }
  }


  /**
   * Update or insert the user's details based on the data. Data is validated and $this->errors is set if
   * if any values are invalid.
   *
   * @param array $data  Data ($_POST array)
   * @return boolean     True if the values were updated / inserted successfully, false otherwise.
   */
  public function save($data)
  {
    $this->name = $data['name'];
    $this->email = $data['email'];

    // If editing a user, only validate and update the password if a value provided
    if (isset($this->id) && empty($data['password'])) {
      unset($this->password);
    } else {
      $this->password = $data['password'];
    }

    // Convert values of the checkboxes to boolean
    $this->is_active = isset($data['is_active']) && ($data['is_active'] == '1');
    $this->is_admin = isset($data['is_admin']) && ($data['is_admin'] == '1');

    if ($this->isValid()) {

      try {

        $db = Database::getInstance();

        // Prepare the SQL: Update the existing record if editing, or insert new if adding
        if (isset($this->id)) {

          $sql = 'UPDATE users SET name = :name, email = :email, is_active = :is_active, is_admin = :is_admin';

          if (isset($this->password)) {  // only update password if set
            $sql .= ', password = :password';
          }

          $sql .= ' WHERE id = :id';

        } else {

          $sql = 'INSERT INTO users (name, email, password, is_active, is_admin) VALUES (:name, :email, :password, :is_active, :is_admin)';
        }

        // Bind the parameters
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':is_active', $this->is_active);
        $stmt->bindParam(':is_admin', $this->is_admin);

        if (isset($this->id)) {
          if (isset($this->password)) {  // only update password if set
            $stmt->bindParam(':password', Hash::make($this->password));
          }

          $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        } else {
          $stmt->bindParam(':password', Hash::make($this->password));
        }

        $stmt->execute();

        // Set the ID if a new record
        if ( ! isset($this->id)) {
          $this->id = $db->lastInsertId();
        }

        return true;

      } catch(PDOException $exception) {

        // Set generic error message and log the detailed exception
        $this->errors = ['error' => 'A database error occurred.'];
        error_log($exception->getMessage());
      }
    }

    return false;
  }


  /**
   * Remember the login by storing a unique token associated with the user ID
   *
   * @param integer $expiry  Expiry timestamp
   * @return mixed           The token if remembered successfully, false otherwise
   */
  public function rememberLogin($expiry)
  {
    
    // Generate a unique token
    $token = uniqid($this->email, true);

    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('INSERT INTO remembered_logins (token, user_id, expires_at) VALUES (:token, :user_id, :expires_at)');
      $stmt->bindParam(':token', sha1($token));  // store a hash of the token
      $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);
      $stmt->bindParam(':expires_at', date('Y-m-d H:i:s', $expiry));
      $stmt->execute();

      if ($stmt->rowCount() == 1) {
        return $token;
      }

    } catch(PDOException $exception) {

      // Log the detailed exception
      error_log($exception->getMessage());
    }

    return false;
  }


  /**
   * Forget the login based on the token value
   *
   * @param string $token  Remember token
   * @return void
   */
  public function forgetLogin($token)
  {
    if ($token !== null) {

      try {

        $db = Database::getInstance();

        $stmt = $db->prepare('DELETE FROM remembered_logins WHERE token = :token');
        $stmt->bindParam(':token', $token);
        $stmt->execute();

      } catch(PDOException $exception) {

        // Log the detailed exception
        error_log($exception->getMessage());
      }
    }
  }


  /**
   * Start the password reset process by generating a unique token and expiry and saving them in the user model
   *
   * @return boolean  True if the user model was updated successfully, false otherwise
   */
  public function startPasswordReset()
  {
    // Generate a random token and base64 encode it so it's URL safe
    $token = base64_encode(uniqid(rand(), true));
    $hashed_token = sha1($token);

    // Set the token to expire in one hour
    $expires_at = date('Y-m-d H:i:s', time() + 60 * 60);
   
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('UPDATE users SET password_reset_token = :token, password_reset_expires_at = :expires_at WHERE id = :id');
      $stmt->bindParam(':token', $hashed_token);
      $stmt->bindParam(':expires_at', $expires_at);
      $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() == 1) {
        $this->password_reset_token = $token;
        $this->password_reset_expires_at = $expires_at;

        return true;
      }

    } catch(PDOException $exception) {

      // Log the detailed exception
      error_log($exception->getMessage());
    }

    return false;
  }


  /**
   * Reset the password
   *
   * @return boolean  true if the password was changed successfully, false otherwise
   */
  public function resetPassword()
  {
    $password_error = $this->_validatePassword();

    if ($password_error === null) {

      try {

        $db = Database::getInstance();

        $stmt = $db->prepare('UPDATE users SET password = :password, password_reset_token = NULL, password_reset_expires_at = NULL WHERE id = :id');
        $stmt->bindParam(':password', Hash::make($this->password));
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
          return true;
        }

      } catch(PDOException $exception) {

        // Set generic error message and log the detailed exception
        $this->errors = ['error' => 'A database error occurred.'];
        error_log($exception->getMessage());
      }
      
    } else {
      $this->errors['password'] = $password_error;
    }

    return false;
  }


  /**
   * Validate the properties and set $this->errors if any are invalid
   *
   * @return boolean  true if valid, false otherwise
   */
  public function isValid()
  {
    $this->errors = [];

    // 
    // name
    //
    if ($this->name == '') {
      $this->errors['name'] = 'Please enter a valid name';
    }

    // 
    // email address
    //
    if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
      $this->errors['email'] = 'Please enter a valid email address';
    }

    if ($this->_emailTaken($this->email)) {
      $this->errors['email'] = 'That email address is already taken';
    }

    // 
    // password
    //
    $password_error = $this->_validatePassword();
    if ($password_error !== null) {
      $this->errors['password'] = $password_error;
    }

    return empty($this->errors);
  }


  /**
   * Get the total number of users
   *
   * @return integer
   */
  private static function _getTotalUsers()
  {
    try {

      $db = Database::getInstance();
      $count = (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn(); 

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
      $count = 0;
    }

    return $count;
  }


  /**
   * See if the email address is taken (already exists), ignoring the current user if already saved.
   *
   * @param string $email  Email address
   * @return boolean       True if the email is taken, false otherwise
   */
  private function _emailTaken($email)
  {
    $isTaken = false;
    $user = $this->findByEmail($email);

    if ($user !== null) {

      if (isset($this->id)) {  // existing user

        if ($this->id != $user->id) {  // different user
          $isTaken = true;
        }

      } else {  // new user
        $isTaken = true;
      }
    }

    return $isTaken;
  }


  /**
   * Validate the password
   *
   * @return mixed  The first error message if invalid, null otherwise
   */
  private function _validatePassword()
  {
    if (isset($this->password) && (strlen($this->password) < 5)) {
      return 'Please enter a longer password';
    }

    if (isset($this->password_confirmation) && ($this->password != $this->password_confirmation)) {
      return 'Please enter the same password';
    }
  }


  /**
   * Send activation email to the user based on the token
   *
   * @param string $token  Activation token
   * @return mixed         User object if authenticated correctly, null otherwise
   */
  private function _sendActivationEmail($token)
  {
    // Note hardcoded protocol
    $path = Config::REDIR_PATH;
    $url = 'http://'.$_SERVER['HTTP_HOST'].$path .'/activate_account.php?token=' . $token;
    $body = <<<EOT

<p>Please click on the following link to activate your account.</p>

<p><a href="$url">$url</a></p>

EOT;

    Mail::send($this->name, $this->email, 'Activate account', $body);
  }

}
