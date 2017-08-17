<?php
$access = "yes";
require_once __DIR__.'/config.php';
require_once __DIR__.'/vendor/autoload.php';

session_start();
if ($_SESSION['logged_in'] != 'true') {
    header('Location:login');
    exit();
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 $sql_archive = "SELECT * FROM archive_master WHERE uid='".$_SESSION['user']['id']."' ORDER BY udate DESC";
  $result2 = $conn->query($sql_archive);  
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/png" href="logo.png"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" >
	  <link rel="stylesheet" type="text/css" href="css/jumbotron.css"> 
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard_style.css">
    <link rel="stylesheet" type="text/css" href="css/slider.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <style>
         body,html{font-family:"Source Sans Pro";}
    </style>
</head>
<body>

    <!-- Page header -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

         <a class="navbar-brand" style="font-weight:700;color:#1ab4e2;line-height: 21px;" href="#">  
             <span style="margin-top: -5px;display: inline-block;"> SOCIAL <span style="color: #b7b7b7;">STORY 
                <small style="display: block;font-size: 12px;margin-top: -7px;font-weight: 400;letter-spacing: .03em;">
                    Preserve your stories
                </small> 
             </span> 
         </a>

        </div>
        <div id="navbar" class="collapse navbar-collapse pull-right">
          <ul class="nav navbar-nav">
            <li ><a href="dashboard"><span class="ti-folder"></span> &nbsp; ALBUMS &nbsp; </a></li>   
            <li class="active"><a href="archive"><span class="ti-archive"></span> &nbsp; ARCHIVES &nbsp; <span id="arc_count" class="badge success"></span> </a></li>
            <!-- <li><a href="#about"><span class="ti-twitter-alt"></span> Twitter</a></li> -->
            <li class="dropdown">
              <a style="padding:10px;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                   <img src="<?php echo $_SESSION['user']['picture']; ?>" class="pro_pic">&nbsp; 
                   <?php echo strtoupper($_SESSION['user']['name']); ?> &nbsp; <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="logout"><span class="ti-unlock"></span> &nbsp; Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>  
    </nav> <!-- page nav bar -->

    <!-- Begin page content -->
    <div class="container" id="content">

         
<?php if ($result2->num_rows > 0) { ?>
    
        <div>
            <h3 style="font-weight:100;"><span class="ti-archive"></span> ARCHIVE (<?php echo $result2->num_rows; ?>)</h3>
        </div>

        <hr/>
       
       <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Update time</th>
            <th>Download</th>
          </tr>
        </thead>
        <tbody>
        <?php $i=1; while($row = $result2->fetch_assoc()) { ?>
          <tr>
            <th scope="row"><?php echo $i; ?></th>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['udate']; ?></td>
            <td><a href="<?php echo $row['url']; ?>" download="<?php echo $row['title']; ?>" class="btn btn-sm btn-success">DOWNLOAD</a></td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    

 <?php  }else{ ?>
           
       <div style="color: #eaeaea;text-align: center;padding:10%;">
           <span class="ti-archive" style="margin: auto;font-size: 80px;display: block;"></span>
            <h1 style="font-weight:900;">No Archives<h1>
       </div>
  <?php } ?>
    </div> <!-- page container -->

    <!-- Modal start -->
    <div id="modal" class="slide_modal">
      <button onclick="stop()" class="modal_close_button"><span class="ti-close"></span> </button>
      <div class="modal_con_outer">
         <div id="modal_content" class="modal_con_inner">
            <img id="slide_img" class="img-responsive modal_image animated fadeIn"  />        
         </div>
         <div class="modal_toolbar">
               <button onclick="prev();"><span class="ti-control-backward"></span></button>
               <button id="playPause"><span class="ti-control-pause"></span></button>
               <button onclick="next();"><span class="ti-control-forward"></span></button>
         </div>
      </div> 
    </div>  <!-- custom image modal -->

    <!-- Modal start -->
    <div id="modal1" class="slide_modal">
      <div class="modal_con_outer">
         <div id="modal_content" class="modal_con_inner">
            <img id="slide_img" class="img-responsive animated fadeIn" style="height:50px;margin:auto;" src="img/hourglass.gif" />  
            
            <span class="wt_txt" style="margin:auto;color:#fff;display: block;text-align: center;">
             
            Zipping folder's for download</span> 
            <span style="margin:auto;color:#fff;display: block;text-align: center;"> 
            Please Wait</span>      
         </div>
      </div> 
    </div>  <!-- custom image modal -->
 
    <!-- Javascript libraries -->
   	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  	<script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/notify.min.js"></script>
    <!-- Javascript libraries -->

    <script> $(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();}); </script> 

</body>
</html>