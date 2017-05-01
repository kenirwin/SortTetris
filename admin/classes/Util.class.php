<?php
 
/**
 * Utilities class
 */

class Util
{

  /**
   * Redirect to a different page
   *
   * @param string $url  The relative URL
   * @return void
   */
  public static function redirect($url)
  {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . Config::REDIR_PATH . $url);
    exit;
  }


  /**
   * Deny access by sending an HTTP 403 header and outputting a message
   *
   * @return void
   */
  public static function denyAccess()
  {
    header('HTTP/1.0 403 Forbidden');
    echo '403 Forbidden';
    exit;
  }


  /**
   * Show not found page and send an HTTP 404 header
   *
   * @return void
   */
  public static function showNotFound()
  {
    header('HTTP/1.0 404 Not Found');
    echo '404 Not Found';
    exit;
  }

}
