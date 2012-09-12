<?php
namespace Hiptest;
include "lib/config.php";

if(empty($_POST['selections'])) {
    header('Location: instagram');
    exit;
}

$order = new \Order($_SESSION['orderID'], $db);
foreach($_POST['selections'] as $current) {
    $image = new \InstagramImage($current);
    $order->addImage($image->getImage());
}
header('Location: ../order');
?>