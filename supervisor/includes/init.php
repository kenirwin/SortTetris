<?php
/**
 * Initialisations
 */

if (! file_exists(dirname(dirname(__FILE__)) . '/classes/Config.class.php')) {
  header('Location: ./unavailable.php?reason=no-config-class');
}
elseif (! file_exists(dirname(dirname(dirname(__FILE__))) . '/global_settings.php')) {
  header('Location: ./unavailable.php?reason=no-global-settings');
}
else {
  include (dirname(dirname(dirname(__FILE__))) . '/global_settings.php');
  if (!isset($allow_admin) || $allow_admin === false) {
    header('Location: ./unavailable.php?reason=disallowed');
  }
  elseif (preg_match('/supervisor\/signup.php/', $_SERVER['SCRIPT_NAME'])) {
    if (!isset($allow_supervisor_registrationxxx) || $allow_supervisor_registration === false) {
      header('Location: ./unavailable.php?reason=registration-disallowed');
    }
  }
}

// Register autoload function
spl_autoload_register('myAutoloader');

/**
 * Autoloader
 *
 * @param string $className  The name of the class
 * @return void
 */
function myAutoloader($className)
{
  require dirname(dirname(__FILE__)) . '/classes/' . $className . '.class.php';
}


// Authorisation
Auth::init();
