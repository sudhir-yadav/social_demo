<?php  require_once __DIR__.'/login.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Facebook</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/png" href="logo.png"/>
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/font.css" >
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css">
    <link href="css/cover.css" rel="stylesheet">
</head>
<style>
    body,html{font-family:"Source Sans Pro";}
</style>
<body>

   <body>

    <div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          <div class="masthead clearfix">
            <div class="inner">
                 
            </div>
          </div>

        <div class="inner">
            <div class="header-content-inner">
                <h1 id="homeHeading" style="font-weight:100;">
                <img src="img/fb.png" style="height:60px;margin:auto;display: block;margin-bottom:10px;"><!-- SOCIAL STORY --></h1>
                <hr>
                <p class="lead"> No one can tell your story so tell it yourself.No one can write your story so write it yourself.</p>
                <a onclick="showLoader();" style="width:190px;" href="<?php echo $loginUrl; ?>" class="btn btn-primary btn-lg page-scroll">
                    <span class=" ti-facebook"></span> &nbsp; Facebook Login
                </a>
                <br/><br/>
                <div id="loader"></div>
            </div>
        </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Developed </a>, by Sudhir Yadav.</p>
            </div>
          </div>

        </div>

      </div>

    </div>

 	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
  <script>
   function showLoader(){
      $('#loader').html('<img src="img/init_loader.gif"/>');
    }
  </script>

</body>

</body>
</html>