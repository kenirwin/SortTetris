<?php
 
/**
 * Mail class - a wrapper around PHPMailer
 */

class Mail
{

  private function __construct() {}  // disallow creating a new object of the class with new Mail()

  private function __clone() {}  // disallow cloning the class

  /**
   * Send an email
   *
   * @param string $name     Name
   * @param string $email    Email address
   * @param string $subject  Subject
   * @param string $body     Body
   * @return boolean         true if the email was sent successfully, false otherwise
   */
  public static function send($name, $email, $subject, $body)
  {
    require dirname(dirname(__FILE__)) . '/vendor/PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = Config::SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = Config::SMTP_USER;
    $mail->Password = Config::SMTP_PASS;
    $mail->SMTPSecure = 'tls';
    $mail->Port = Config::SMTP_PORT;
    $mail->SMTPDebug = 2;

    $mail->From = Config::SMTP_SENDER;

    $mail->isHTML(true);

    $mail->addAddress($email, $name);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if ( ! $mail->send()) {
      error_log($mail->ErrorInfo);
      echo ($mail->ErrorInfo);
      return false;

    } else {
      return true;

    }
  }

}
