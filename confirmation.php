<?php

namespace Music;

include "lib/config.php";
$main = new \Main();

if (!empty($_GET['save'])) {
    \Order::save($_POST);
    header('Location: ../order');
}
$order = new \Order();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php print $main->getSiteName() ?>: Order</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo $main->getStyles() ?>
        <link rel="stylesheet" href="<?php print _SITE_URL_; ?>/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script type="text/javascript" src="<?php print _SITE_URL_; ?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                //add the lightbox
                $("a.lightbox").fancybox();
                                
                $('option[value="<?php print $order->getProv(); ?>"]').attr("selected", "selected");
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
                <h2>Which photos would you like to print?</h2>
                    <table border="0">
                        <?php
                        print $order->getInfo();
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
