<?php
namespace Music;

if(empty($_POST['selections'])) {
    header('Location: instagram');
    exit;
}

include "lib/config.php";

foreach($_POST['selections'] as $current) {
    $image = new \InstagramImage($current);
    $_SESSION['images'][] = serialize($image->getImage());
}
header('Location: ../order');
?>