<?php
// meditation + docker-dev config

// phpcs:ignoreFile

function epr(...$args) {
  exit('<pre>'.print_r($args, true));
}

// Docker-dev specific variable setup
$DOCKER_DEV = new stdClass();
$DOCKER_DEV->has_server_dir = false;
$DOCKER_DEV->is_multi_site = __DIR__ !== '/var/www/totara/src';
$DOCKER_DEV->site_name = $DOCKER_DEV->is_multi_site ? basename(__DIR__) : 'totara';
$DOCKER_DEV->fcnyl_root = __DIR__ . '/fcnyl5';

//epr($DOCKER_DEV);

// Required for older versions (T12 and below) and moodle
if (!$DOCKER_DEV->has_server_dir || !isset($CFG)) {
  unset($CFG);
  global $CFG;
  $CFG = new stdClass();
  $DOCKER_DEV->major_version = '5';
}

// path orientation
define( 'LOCAL_ROOT', $DOCKER_DEV->fcnyl_root );
define( 'FCNYL_ROOT', $DOCKER_DEV->fcnyl_root );
define( 'FCNYL_LIB', FCNYL_ROOT.'/lib' );

// database connection
define( 'FCNYL_DBHOST', 'mariadb1011' );
define( 'FCNYL_DBPORT', '3306' );
define( 'FCNYL_DBUSER', 'root' );
define( 'FCNYL_DBPASS', 'root' );
define( 'FCNYL_DBNAME', $DOCKER_DEV->site_name );

// collection hard limit
define( 'FCNYL_OBJLIMIT', 1024 );

// data size limit - 32MB (8388608 * 4) default
define( 'FCNYL_MAX_DATA', 33554432 );

// cookie name -- change this so it is unique to each app within a domain name
define('FCNYL_COOKIE','light_session');

// define location of global root script if used by templateset
// define( 'GLOBAL_ROOT', '/usr/local/tanoquo' );

// default action path ( searched in order, just like an include path )
$actionpath = array( FCNYL_ROOT.'/actions' );

// default template path
$templatepath = array( FCNYL_ROOT.'/templates' );

// filter path
$filterpath = array( FCNYL_ROOT.'/filters' );

// widget path
$widgetpath = array( FCNYL_ROOT.'/widgets' );

// widgets available to lists
$widget_choices = array( 'tunes($items,$object,NULL,NULL,NULL,TRUE)'=>'Tunes',
  'mediatunes($items,$object)'=>'Media Tunes',
  'grid("items",$items)'=>'Grid',
  'softGrid($items)'=>'Soft Grid',
  'messageList($items,$view)'=>'Message List',
  'm_table($labels,$items,$types)'=>'Metrix Table',
);

// limit expert mode to editors and admins only
define( 'FCNYL_NO_USER_EXPERT', TRUE );

// normally root object is off-limits to guests, but sometimes you want to allow it
//define( 'FCNYL_ALLOW_ROOT_ACCESS', TRUE );

// i18n support - languages is an array of ( browser-language => locale ) pairs
// your system must support these locales... use 'locale -a' to list supported locales
// on Debian, use 'dpkg-reconfigure locales' to add new locales
$languages = array( 'en-us'=>'en_US.utf8', 'es'=>'es_ES.utf8' );

// application locales path
define( 'FCNYL_LOCALES', LOCAL_ROOT.'/locales' );

// debugging key (set to FALSE to turn off debugging!)
define( 'FCNYL_DEBUG', true );

// path to server-writeable log file (set to FALSE to turn off logging)
define( 'FCNYL_LOGFILE', FALSE );

// log all http-engine requests (if unset or false, only slow requests are logged)
define( 'FCNYL_LOGALL', FALSE );

// force SSL for logged-in users by setting this to HTTPS port number
define( 'FCNYL_SSLPORT', '443');

// force SSL connections to use a canonical hostname
// define( 'FCNYL_SSLHOST', 'www.example.org');

// set this to plain HTTP port number
define( 'FCNYL_HTTPPORT', '80');

// override for Debian dev's need for single \n mail header seps
define( 'CRLF', "\n");

// antiword (debian package) understands word files
//define( 'FCNYL_ANTIWORD', '/usr/bin/antiword' );

// use active directory for authentication - space-separated list of ip addresses (primary/backup)
// define( 'FCNYL_ADHOST', '10.0.17.x 10.0.17.y' );
// define( 'FCNYL_ADDOM', 'FCNY' );

// use imap for authentication
//define( 'FCNYL_IMAPHOST', '{outlook.office365.com:993/imap/ssl}' );
//define( 'FCNYL_IMAPDOMAIN', 'fcny.org' );

/**
 * Deprecated homebrew SSO
 *
// use Single Sign-On Server for authentication (experimental)
define( 'FCNYL_SSO', TRUE );
define( 'FCNYL_SSO_CKEY', FCNYL_ROOT.'/ssl/client.key' );
define( 'FCNYL_SSO_CKEY_PASS', '' );
define( 'FCNYL_SSO_CCRT', FCNYL_ROOT.'/ssl/client.crt' );
define( 'FCNYL_SSO_SKEY', FCNYL_ROOT.'/ssl/server.key' );
define( 'FCNYL_SSO_SKEY_PASS', '' );
define( 'FCNYL_SSO_SCRT', FCNYL_ROOT.'/ssl/server.crt' );
 */

// virtual host support
$vhosts = array(
  'light2.example.org'=>'/light2',
  'foo.exmple.org'=>array( '/foo-main', '/foo-secondary' ),
);

// override FCNYL_SSLHOST for some virtual hosts
$ssl_vhosts = array( 0=>'light2.example.org' );

// set this to the postfix mailhost name to accept mail
//define('FCNYL_MESSAGEHOST','example.org');


/**
 * The following directives add Erasmus/Darwin media processing support
 *
 */
//define('ERASMUS_WWW','http://mac.local/~edarwin/erasmus');
define('ERASMUS_DROP', '/mnt/erasmus/erasmus_drop');
define('ERASMUS_PICKUP', '/mnt/erasmus/erasmus_pickup');
define('ERASMUS_TIMEOUT', 300 );
define('ERASMUS_SECRET', 'My brother Charles was a genius!');


/**
 * The following directives can be used for publishing a location via ftp (experimental)
 *
define('FCNYL_WGET','/usr/bin/wget');
$pubs = array();
$pubs['/www'] = new stdClass();
$pubs['/www']->wwwmap = '/';
$pubs['/www']->ftpmap = 'public_html/';
$pubs['/www']->ftphost = 'localhost';
$pubs['/www']->ftp_ssl = TRUE;
$pubs['/www']->ftpusername = 'username';
$pubs['/www']->ftppass = 'password';
$pubs['/www']->email = 'webmaster@example.org';
 */

/**
 * Content Delivery Network settings (experimental)
 *
define( 'FCNYL_SWSROOT', '/root/sws-tools' );
$cdn_buckets = array(
'fcny-1'=>'https://fcny-1.s3.amazonaws.com/',
'fcny-2'=>'https://fcny-2.s3.amazonaws.com/',
'fcny-3'=>'https://fcny-3.s3.amazonaws.com/',
);
 */

// aws access key
//define( 'AWS_ACCESSKEY', 'KKKKKK' );
//define( 'AWS_SECRET', 'ssssss' );
//define( 'SWS_AWSREGION', 'us-east-1' );

// akismet key, to enable comment spam filtering
//define( 'FCNYL_AKISMET_KEY', 'xxx' );

// form uploads directory
//define( 'FCNYL_FORM_UPLOADS_DIR', '/path/to/form-uploads' );

// alternate paypal referer for processing payments standard get requests
//define( 'FCNYL_PAYPAL_ALT_REFERER', '' );

// reCAPTCHA support
//define("RECAPTCHA_API_PUBLIC_KEY", "xxx");
//define("RECAPTCHA_API_PRIVATE_KEY", "xxx");


//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////                                                              //////
//////         Main Site Database & Dataroot Configuration          //////
//////                                                              //////
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

/** MariaDB */
$CFG->dbhost = FCNYL_DBHOST; // See https://github.com/totara/totara-docker-dev/wiki/Database%20Credentials for other versions
$CFG->dbtype = 'mariadb';
$CFG->dbuser = FCNYL_DBUSER;
$CFG->dbpass = FCNYL_DBPASS;
$CFG->dbname = FCNYL_DBNAME;

$CFG->dblibrary = 'native';
$CFG->dboptions = array('dbpersist' => false, 'dbsocket' => false, 'dbport' => '');
$CFG->dataroot = '/var/www/totara';

//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////                                                              //////
//////                    wwwroot Configuration                     //////
//////                                                              //////
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

/**
 * Here we generate a dynamic wwwroot, so the site can be simultaneously accessed via different PHP versions, and externally via ngrok.
 * You shouldn't need to change this section - but if you find this needs modification to get it working,
 * then please contribute what you did back to the docker-dev repository :)
 */

// Matches URL with ngrok.app or ngrok-free.app
$ngrok_hostname_regex = '/\b(?:ngrok-free\.app|ngrok\.app)\b/';
if (!empty($_SERVER['HTTP_X_FORWARDED_HOST']) && preg_match($ngrok_hostname_regex, $_SERVER['HTTP_X_FORWARDED_HOST'])) {
  // Request came via ngrok
  $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
  $CFG->wwwroot = 'https://' . $_SERVER['HTTP_HOST'];
} else if (!empty($_SERVER['HTTP_X_ORIGINAL_HOST']) && preg_match($ngrok_hostname_regex, $_SERVER['HTTP_X_ORIGINAL_HOST'])) {
  // Request came via ngrok
  $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_ORIGINAL_HOST'];
  $CFG->wwwroot = 'https://' . $_SERVER['HTTP_HOST'];
} else if (!empty($_SERVER['HTTP_HOST']) && !empty($_SERVER['REQUEST_SCHEME'])) {
  // accessing it locally via the web
  $CFG->wwwroot = $_SERVER['REQUEST_SCHEME'] . '://';

  $hostname = $_SERVER['HTTP_HOST'];
  $hostname_parts = explode('.', $hostname);
  if (end($hostname_parts) === 'behat') {
    // redirect if using the behat URL
    $hostname = str_replace('.behat', '', $hostname);
  }
  $CFG->wwwroot .= $hostname;

  if ($DOCKER_DEV->is_multi_site && strpos($hostname, $DOCKER_DEV->site_name) === false) {
    $CFG->wwwroot .= '/' . $DOCKER_DEV->site_name;
    if ($DOCKER_DEV->has_server_dir) {
      $CFG->wwwroot .= '/server';
    }
  }
} else {
  // accessing it via CLI
  $CFG->wwwroot = 'http://totara' . PHP_MAJOR_VERSION . PHP_MINOR_VERSION;
  if ($DOCKER_DEV->is_multi_site) {
    $CFG->wwwroot .= '/' . $DOCKER_DEV->site_name;
  }
  if ($DOCKER_DEV->has_server_dir) {
    $CFG->wwwroot .= '/server';
  }
}

// EOF