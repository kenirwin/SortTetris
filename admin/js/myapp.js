$(document).ready(function() {


  /**
   * Validate the signup form
   */
  $('#signupForm').validate({
    rules: {
      email: {
        remote: {
          url: '/validate_email.php',
          type: 'post'
        }
      },
      password: {
        minlength: 5
      }
    },
    messages: {
      email: {
        remote: 'Already taken, please choose another one.'
      },
      password: {
        required: 'This field is required.',
        minlength: $.validator.format('Please enter at least {0} characters.')
      }
    }
  });


  /**
   * Validate the user admin form
   */
  $('#userForm').validate({
    rules: {
      email: {
        remote: {
          url: '/validate_email.php',
          type: 'post',
          data: {
            user_id: function() {
              return $userID;
            }
          }
        }
      },
      password: {
        required: function(element) {
          return $userID == null;
        },
        minlength: 5
      }
    },
    messages: {
      email: {
        remote: 'Already taken, please choose another one.'
      },
      password: {
        required: 'This field is required.',
        minlength: $.validator.format('Please enter at least {0} characters.')
      }
    }
  });
  
  
  /**
   * Validate the password reset form
   */
  $('#resetPasswordForm').validate({
    rules: {
      password: {
        minlength: 5
      },
      password_confirmation: {
        equalTo : '#password'
      }
    },
    messages: {
      password: {
        required: 'This field is required.',
        minlength: $.validator.format('Please enter at least {0} characters.')
      }
    }
  });
});
