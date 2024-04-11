<?php 
    include 'bootstrap.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ru"> <!--<![endif]-->

<head>

  <meta charset="utf-8">

  <title>Галерея</title>
  <meta name="description" content="">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">  
  <link rel="stylesheet" href="/assets/css/main.css">

  <script src="/libs/modernizr/modernizr.js"></script>
</head>

<body>

<header>
  <div class="container">
    <div class="header">
      <div class="logo">
        <a href="/">Галерея</a>
      </div>
      <div class="menu">
        <?php if (!empty(checkUser())): ?>
          <a href="/login">Моя страница</a>
          <button class="btn btn-primary" onclick="logout(); return true;">Выйти</button>
        <?php else: ?>
          <a href="/login" class="btn btn-primary">Войти</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>

<main>
  <div class="container">

    <?php
      $url = explode("/", $page);
      if (!empty($url['2']) && $url['1'] == 'photo.php'):
        $photo_id = $url['2'];
        include $url['0'].'/'.$url['1'];
      else:
        include $page;
      endif;  
    ?>

  </div>
</main>

<footer>
  <div class="container">
    <div class="footer">
      <div class="footer-text">
        Галерея  © <?= date('Y'); ?>     
      </div>
    </div>
  </div>
</footer>

  <!--[if lt IE 9]>
  <script src="libs/html5shiv/es5-shim.min.js"></script>
  <script src="libs/html5shiv/html5shiv.min.js"></script>
  <script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
  <script src="libs/respond/respond.min.js"></script>
  <![endif]-->

  <script src="/libs/jquery/jquery-1.11.2.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input@1.3.4/dist/bs-custom-file-input.min.js"></script>
  <script src="/assets/js/common.js"></script>
<script>
    $(() => {
        bsCustomFileInput.init();
    })
</script>
  </body>
</html>

