<?php

namespace Hiptest;

include "lib/config.php";
$main = new \Main();

$order = new \Order($_SESSION['orderID'], $db);
$user = new \User($order->getUserID(), $db);
$order->complete();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php print $main->getSiteName() ?>: Confirmation</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo $main->getStyles() ?>
        <link rel="stylesheet" href="<?php print _SITE_URL_; ?>/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script type="text/javascript" src="<?php print _SITE_URL_; ?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                //add the lightbox
                $("a.lightbox").fancybox();
                                
            });
        </script>
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
                <h2>Thank You!</h2>
                    <table border="0">
                        <?php
                        print $user->getInfo(true);
                        ?>
                    </table>

                    <?php
                    print $order->getImages();
                    ?>
            </div>
            <div id="footer">
                <?php print $main->getFooter(); ?>
            </div>
        </div>
    </body>
</html>
<?php
$confirmation = new \Confirmation($db, $user->getEmail(), "sales@perfectprinting.com", "Your confirmation email");
$confirmation->send();
$_SESSION['orderID'] = "";
?>