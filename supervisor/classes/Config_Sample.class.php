<?php
 
/**
 * Configuration class -- COPY THIS FILE to: Config.class.php
 *                        Then fill in constant values
 */

class Config
{
  const 
    DB_HOST = '',
    DB_NAME = '',
    DB_USER = '',
    DB_PASS = '',
    SMTP_HOST = '',
    SMTP_USER = '',
    SMTP_PASS = '',
    SMTP_PORT = 587, // try 25 (unsecured) if that doesn't work
    SMTP_SENDER = 'from@example.com',
    REDIR_PATH = ''; // http path to supervisor directory, no trailing slash



  public function ConfigsSet () {
    $v = ($this::DB_HOST == '') ||
      ($this::DB_NAME =='') ||
      ($this::DB_USER =='') ||
      ($this::DB_PASS =='') ||
      ($this::SMTP_HOST =='') ||
      ($this::SMTP_USER =='') ||
      ($this::SMTP_PASS =='') ||
      ($this::SMTP_PORT =='') ||
      ($this::SMTP_SENDER =='') ||
      ($this::REDIR_PATH=='');
    if ($v)
      return false;
    else 
      return true;
  }


 
}
