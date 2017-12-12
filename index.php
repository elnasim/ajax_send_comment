<?php
include_once 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="icon" href="">

  <title>Test</title>

  <!-- include css libraries -->
  <link href="dist/css/libs.min.css" rel="stylesheet">

  <!-- include common css -->
  <link href="dist/css/common.min.css" rel="stylesheet">
</head>
<body>

<header class="header">
  <div class="container">

    <div class="row">
      <div class="col-12">
        <a href="#" class="logo-link">
          <img src="dist/img/logo.png" class="logo header-logo">
        </a>
      </div>
    </div>

    <div class="row justify-content-center justify-content-lg-start">
      <div class="col-lg-3 col-md-4 col-7 offset-lg-4">
        <img src="dist/img/contact-icon.png" alt="" class="contact-icon img-responsive">
      </div>
    </div>

    <form id="send-form" action="add_comment.php" class="send-form validate" method="get">

      <div class="row justify-content-between">

        <div class="col-lg-5 col-md-12">
          <label class="input-wrapper">
            <span class="label-text">Имя <span class="text-red align-top label-star">*</span></span>
            <input type="text" class="input-field" name="name">
          </label>
          <label class="input-wrapper">
            <span class="label-text">E-Mail <span class="text-red align-top label-star">*</span></span>
            <input type="text" class="input-field" name="email">
          </label>
        </div>

        <div class="col-lg-6 col-md-12">
          <label class="textarea-wrapper">
            <span class="label-text">Комментарий <span class="text-red align-top label-star">*</span></span>
            <textarea class="input-field textarea-field" name="message"></textarea>
          </label>
        </div>

      </div>

      <div class="row justify-content-end">
        <div class="col-12 d-flex justify-content-end">
          <button type="submit" class="button">Записать</button>
        </div>
      </div>

    </form>

  </div>
</header>

<section class="comments">
  <div class="container">

    <div class="row">
      <div class="col-12">
        <div class="comments-head">Выводим комментарии</div>
      </div>
    </div>

    <div class="row comments-wrapper">

      <?php
      $comments = mysqli_query($connection, "SELECT * FROM `comments` ");
      ?>

      <?php
      while ($comment = mysqli_fetch_assoc($comments)) {
        ?>

        <div class="col-lg-4 col-md-6 item-comment__wrap">
          <div class="item-comments">
            <div class="item-comments__head"><?php echo $comment['name'] ?></div>
            <div class="item-comments__content">
              <div class="item-comments__email"><?php echo $comment['email'] ?></div>
              <div class="item-comments__message"><?php echo $comment['message'] ?></div>
            </div>
          </div>
        </div>

        <?php
      }
      ?>


    </div>

  </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="row justify-content-between align-items-center">

      <div class="col-sm-6 col-12">
        <a href="#"><img src="dist/img/logo.png" class="logo footer-logo"></a>
      </div>

      <div class="col-sm-6 col-12">
        <div class="socials">
          <a href="#" class="social-link"><i class="fa fa-vk"></i></a>
          <a href="#" class="social-link"><i class="fa fa-facebook"></i></a>
        </div>
      </div>

    </div>
  </div>
</footer>


<!-- include js libraries -->
<script src="dist/js/libs.min.js"></script>

<!-- include main common js -->
<script src="dist/js/common.min.js"></script>
</body>
</html>