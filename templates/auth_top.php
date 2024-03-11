<?php require_once("redirect.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php require_once("../sections/auth_head.php") ?>

</head>

<?php foreach ($views_auth as $data) { ?>

  <body class="" style="background-color: <?= $data['bg'] ?>;">
  <?php }
foreach ($messageTypes as $type) {
  if (isset($_SESSION["project_smak_wartabakti"]["message_$type"])) {
    echo "<div class='message-$type' data-message-$type='{$_SESSION["project_smak_wartabakti"]["message_$type"]}'></div>";
  }
} ?>

  <div class="container">