<?php

namespace Music;

include "lib/config.php";
$main = new \Main();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php print $main->getSiteName() ?>: Home</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $main->getStyles() ?>
    </head>
    <body>
        <div id="wrap">
            <div id="header">
                <?php
                print $main->getHeader();
                ?>
            </div>
            <div id="navbar">
                <?php
                print $main->getNavbar();
                ?>
            </div>
            <div id="main">
                <h2>Add Photos using:</h2>
                <a href="https://api.instagram.com/oauth/authorize/?client_id=<?php print \Instagram::$client_id; ?>&redirect_uri=<?php print \Instagram::$redirect; ?>&response_type=code"><img src="http://d36xtkk24g8jdx.cloudfront.net/bluebar/0dac110/images/public/logo.png" alt="Add photos using Instagram" /></a>
            </div>
            <div id="footer">
                <?php print $main->getFooter(); ?>
            </div>
        </div>
    </body>
</html>
