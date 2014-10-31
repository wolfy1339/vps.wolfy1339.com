<?php error_reporting(E_ERROR);

define('Title','Wolfy1339');
// External resources
   define('FONT_AWESOME', '/Resources/css/font-awesome.min.css');
   define('BOOTSTRAP', '/Resources/css/bootstrap.min.css');
   define('BOOTSTRAP_THEME', '/Resources/css/bootstrap-theme.min.css');
   define('JQUERY', '/Resources/js/jquery.min.js');
   define('BOOTSTRAPJS', '/Resources/js/bootstrap.min.js');

// Browser and Device Icons
          define('FAV_ICON', '//wolfy1339.tk/img/favicon.png'); // 16x16 or 32x32 
       define('IPHONE_ICON', ''); // 57x57
define('IPHONE_ICON_RETINA', ''); // 114x114
         define('IPAD_ICON', ''); // 72x72
  define('IPAD_ICON_RETINA', ''); // 144x144
  define('METRO_TILE_COLOR', ''); //
  define('METRO_TILE_IMAGE', ''); // 144x144

  // OpenGraph Tags - http://ogp.me/
          define('OG_TITLE', '');
    define('OG_DESCRIPTION', '');
      define('OG_SITE_NAME', '');
         define('OG_LOCALE', '');
           define('OG_TYPE', '');
          define('OG_IMAGE', ''); 

//Error Code & message
define('ERROR_CODE', '500');
define('ERROR_MESSAGE', 'Internal Server Error');
define('ERROR_OOPS', 'Oops');
define('ERROR_MESSAGE_ALERT', "an error happened and I couldn't display the page");
define('ICON', 'fa-frown-o fa-lg');
define('ALERT', 'alert-warning');

// Google Analytics ID
define('ANALYTICS_ID', ''); // UA-XXXXX-Y or UA-XXXXX-YY

/*** HTTP Header ***/
header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");

if (isset($_SERVER['HTTPS'])) {
    $this_protocol = "https://";
} else {
    $this_protocol = "http://";
}

$this_domain = $_SERVER['HTTP_HOST'];
$this_script = basename(__FILE__);

$home = "<i class=\"fa fa-home fa-lg fa-fw\"></i> ";
$version = apache_get_version();

/*** HTML LOGIC ***/
//Footer URL
$footer = null;
$footer = $footer."     <address class=\"text-muted\" style=\"font-style:italic;\">".$version." Server at ".$this_domain." Port ".$_SERVER['SERVER_PORT']."</address>" . PHP_EOL;
// Set breadcrumbs
$breadcrumbs = null;
$breadcrumbs = $breadcrumbs."      <li><a href=\"".htmlentities($this_protocol . $this_domain, ENT_QUOTES, 'utf-8')."\">$home</a></li>" . PHP_EOL;

// Set HTML header
$header = "  <meta charset=\"utf-8\">" . PHP_EOL;
$header = $header."  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=yes\">" . PHP_EOL;
$header = $header."  <meta name=\"generator\" content=\"Bootstrap Listr\" />" . PHP_EOL;
$header = $header."  <title>".Title." &middot; Error ".ERROR_CODE."</title>" . PHP_EOL;
$header = $header."  <link rel=\"stylesheet\" href=\"".BOOTSTRAP."\" />" . PHP_EOL;
$header = $header."  <link rel=\"stylesheet\" href=\"".BOOTSTRAP_THEME."\" />" . PHP_EOL;
$header = $header."  <link rel=\"stylesheet\" href=\"".FONT_AWESOME."\" />" . PHP_EOL;
if (FAV_ICON) $header = $header."  <link rel=\"shortcut icon\" href=\"".FAV_ICON."\" />" . PHP_EOL;
if (IPHONE_ICON) $header = $header."  <link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"".IPHONE_ICON."\" />" . PHP_EOL;
if (IPHONE_ICON_RETINA) $header = $header."  <link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"".IPHONE_ICON_RETINA."\" />" . PHP_EOL;
if (IPAD_ICON) $header = $header."  <link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"".IPAD_ICON."\" />" . PHP_EOL;
if (IPAD_ICON_RETINA) $header = $header."  <link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"".IPAD_ICON_RETINA."\" />" . PHP_EOL;
if (METRO_TILE_COLOR) $header = $header."  <meta name=\"msapplication-TileColor\" content=\"#".METRO_TILE_COLOR."\" />" . PHP_EOL;
if (METRO_TILE_IMAGE) $header = $header."  <meta name=\"msapplication-TileImage\" content=\"#".METRO_TILE_IMAGE."\" />" . PHP_EOL;
if (OG_TITLE) $header = $header."  <meta property=\"og:title\" content=\"".OG_TITLE."\" />" . PHP_EOL;
if (OG_DESCRIPTION) $header = $header."  <meta property=\"og:description\" content=\"".OG_DESCRIPTION."\" />" . PHP_EOL;
if (OG_SITE_NAME) $header = $header."  <meta property=\"og:site_name\" content=\"".OG_SITE_NAME."\" />" . PHP_EOL;
if (OG_LOCALE) $header = $header."  <meta property=\"og:locale\" content=\"".OG_LOCALE."\" />" . PHP_EOL;
if (OG_TYPE) $header = $header."  <meta property=\"og:type\" content=\"".OG_TYPE."\" />" . PHP_EOL;
if (OG_IMAGE) $header = $header."  <meta property=\"og:image\" content=\"".OG_IMAGE."\" />" . PHP_EOL;
$intro = null;
$intro = $intro."    <p>You tried to access ".$_SERVER['REQUEST_URI']."</p>" . PHP_EOL;
$error = "<strong>".ERROR_OOPS.",</strong> ".ERROR_MESSAGE_ALERT." <i class=\"fa fa-fw ".ICON ."\"></i>" . PHP_EOL;
$error_container = "    <div class=\"alert ".ALERT."\">".$error."</div>" . PHP_EOL;
$h1 = "    <h1>".ERROR_CODE." - ".ERROR_MESSAGE."</h1>" .PHP_EOL;
?>


<!DOCTYPE HTML>
<html>
<head>
  <?php echo $header?>
</head>
<body>
  <div class="container">
    <ol class="breadcrumb">
      <?php echo $breadcrumbs?>
    </ol>
    <hr>
    <?php echo $h1?>
    <?php echo $intro?>
    <?php echo $error_container?>
    <p>If you keep encountering this error please contact me at <a href="mailto:webmaster@wolfy1339.tk">webmaster@wolfy1339.tk</a></p>
    <hr>
    <div class="footer">
        <?php echo $footer?>
    </div>
  </div>
</body>
</html>
