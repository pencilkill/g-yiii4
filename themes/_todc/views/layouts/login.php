<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords" content="<?php echo $this->pageTitle; ?>" />
	<meta name="description" content="<?php echo $this->pageTitle; ?>" />
	<!-- core jquery -->
	<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
	<title><?php echo $this->pageTitle; ?></title>
    <link rel="shortcut icon" href="<?php echo $this->skinUrl?>/assets/img/ico/favicon.ico">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->skinUrl?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- TODC Bootstrap core CSS -->
    <link href="<?php echo $this->skinUrl?>/css/todc-bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo $this->skinUrl?>/css/page/signin.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $this->skinUrl?>/js/html5shiv.js"></script>
      <script src="<?php echo $this->skinUrl?>/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="card card-signin">
        <img class="img-circle profile-img" src="<?php echo $this->skinUrl?>/img/avatar.png" alt="">
        <form class="form-signin" role="form">
          <input type="email" class="form-control" placeholder="Email" required autofocus>
          <input type="password" class="form-control" placeholder="Password" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

          <div>
            <label class="checkbox">
              <input type="checkbox" value="remember-me"> Stay signed in
            </label>
          </div>

        </form>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo $this->skinUrl?>/js/bootstrap.min.js"></script>
  </body>
</html>
