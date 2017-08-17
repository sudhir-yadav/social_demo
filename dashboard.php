<?php
$access = "yes";
require_once __DIR__.'/config.php';
require_once __DIR__.'/vendor/autoload.php';

session_start();
if ($_SESSION['logged_in'] != 'true') {
    header('Location:login');
    exit();
}

$fb = new \Facebook\Facebook([
              'app_id' => FB_APP_ID,
              'app_secret' => FB_APP_SECRET,
              'default_graph_version' => FB_APP_VERSION
        ]);

try {
    $response = $fb->get('/me/albums?fields=id,name,picture{url},photo_count,photos.limit(1000){source}', $_SESSION['fb_access_token']);
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$user_album = $response->getGraphEdge();
$user_album = $user_album->asArray();
/*echo $_SESSION['google_root_folder'];
die;*/
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
    <link rel="stylesheet" href="css/font.css" >
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
            <li class="active"><a href="dashboard"><span class="ti-folder"></span> &nbsp; ALBUMS &nbsp;  </a></li>   
            <li><a href="archive"><span class="ti-archive"></span> &nbsp; ARCHIVES &nbsp; <span id="arc_count" class="badge success"></span> </a></li>
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

        <div>
            <h3 style="font-weight:100;"><span class="ti-folder"></span> FACEBOOK ALBUM (<?php echo count($user_album); ?>)</h3>
        </div>

        <hr/>

        <div class="row">
            <?php $fldr_stack; for ($i=0;$i<count($user_album);$i++) {
    ?> 
             <?php 
                             if ($user_album[$i]['photo_count'] > 0) {
                                 if ($user_album[$i]['photo_count'] > 100) {
                                     $len = ($user_album[$i]['photo_count']/$user_album[$i]['photo_count']);
                                     $offset = 0;
                                     for ($j=0;$j<$len;$j++) {
                                         $offset+=100;
                                         $off_response = $fb->get('/'.$user_album[$i]['id'].'/photos?pretty=0&fields=source&offset='.$offset.'&limit=100', $_SESSION['fb_access_token']);
                                         $m = $off_response->getGraphEdge();
                                         $user_album[$i]['photos'] = array_merge($user_album[$i]['photos'], $m->asArray());
                                     }
                                 }
                             } ?> <!-- to get photos of folder having more than 100 images -->
               <div class=" col-lg-2 col-md-3 col-sm-4 col-xs-6 animated bounceIn">
                   <div class="panel cust_panel">

                       <div id="prog_<?php echo $user_album[$i]['id']; ?>" class="prog_continer">
                          <span style="display: none;" id="pgstat_tx_<?php echo $user_album[$i]['id']; ?>">
                             <span class="txt">0%</span><br/>
                             <span class="wt_txt">Zipping Files..</span>
                             <div class="progress" style="height:5px;">
                              <div id="pgstat_<?php echo $user_album[$i]['id']; ?>" class="progress-bar " role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                             </div> 
                          </span>
                           
                           <span style="display: none;padding:10px;" id="pgstat_b_<?php echo $user_album[$i]['id']; ?>">
                             <img style="width:50px;margin:auto;display:block;" src="img/ellipsis.gif" />
                             <span class="wt_txt">Creating backup..</span>
                          </span>        
                       </div> <!-- progress bar -->
                        
                        <div class="panel-heading " style="background: url('<?php echo $user_album[$i]['picture']['url']; ?>')center no-repeat;background-size:100%;">
                                     <div class="info_label">
                                          <div class="col-xs-3"></div>
                                          <div class="col-xs-9 text-right">
                                              <span class="ti-image"></span> &nbsp;<?php echo $user_album[$i]['photo_count']; ?> Photos 
                                          </div>
                                      </div>
                        </div> <!-- panel header -->

                        <div class="panel-footer nopadding">

                            <div class="col-lg-12 col-xs-12 folder_name ">
                                <input class="check-with-label"  id="<?php echo "folder".$i; ?>" type="checkbox" name="folder[]" value='<?php echo $user_album[$i]['id']; ?>' />
                                <label alt="<?php echo $user_album[$i]['name']; ?>" class="folder_nm_label label-for-check " for="<?php echo "folder".$i; ?>"> <?php echo $user_album[$i]['name']; ?> </label>
                            </div> <!-- folder label -->
                            
                            <div class="col-lg-12 col-xs-12 text-center" id="funct_<?php echo $user_album[$i]['id']; ?>" style="padding:10px 0;">
                               
                               <?php if ($user_album[$i]['photo_count']) {
                                 ?>  

                                

                                <button onclick='slideShow(<?php echo '{"name":"'.$user_album[$i]['name'].'","images":'.json_encode($user_album[$i]['photos']).'}'; ?>);' class="folder_usibility">
                                     <span class="ti-layout-slider" data-toggle="tooltip" data-placement="bottom" title="View Slide Show"></span>
                                </button>

                                <a onclick="backup('<?php echo $user_album[$i]['id']; ?>')" class="down_lin folder_usibility">
                                    <img data-toggle="tooltip" data-placement="bottom" title="Upload to google drive" style="height: 16px;margin-top: -4px;" src="img/drive_12.png">
                                </a>

                                <button onclick='download(<?php echo '{"id":"'.$user_album[$i]['id'].'","name":"'.$user_album[$i]['name'].'","images":'.json_encode($user_album[$i]['photos']).'}'; ?>);' class="folder_usibility">
                                      <span class="ti-download" data-toggle="tooltip" data-placement="bottom" title=" Prepare for Download"></span>
                                </button>
                                
                                <?php if (isset($_SESSION[$user_album[$i]["id"]]['downlaod_link'])) {
                                     ?> 

                                <a class="down_lin folder_usibility temp_a" href='<?php echo $_SESSION[$user_album[$i]["id"]]['downlaod_link']; ?>' download="<?php echo $user_album[$i]['name']; ?>.zip">
                                      <span class="ti-zip" data-toggle="tooltip" data-placement="bottom" title="Download Zip"></span>
                                </a>
                                <?php
                                 } ?>
                                <?php
                             } else {
                                 echo '<span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Not Available" style="padding: 3px 10px;background: #969696;color: #fff;margin: 7px;border-radius: 17px;">N/A</span>';
                             } ?>

                            </div> <!-- folder function button -->
                            
                            <div class="clearfix"></div>
                        </div> <!-- panel footer -->
                            
                    </div> <!-- panel -->
                </div> <!-- panel outer div -->
            <?php
}  ?>
        </div> <!-- page row -->
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

    <!-- Modal start -->
    <div id="modal3" class="slide_modal">
      <div class="modal_con_outer">
         <div id="modal_content" class="modal_con_inner">
            <img id="slide_img" class="img-responsive animated fadeIn" style="height:80px;margin:auto;" src="img/ellipsis.gif" />  
            
            <span class="wt_txt" style="margin:auto;color:#fff;display: block;text-align: center;">
             
            Creating Backup ...</span> 
            <span style="margin:auto;color:#fff;display: block;text-align: center;"> 
            Please Wait</span>      
         </div>
      </div> 
    </div>  <!-- custom image modal -->

    <!-- Modal start -->
    <div id="modal2" class="slide_modal">
      <button onclick="closeModal()" class="modal_close_button"><span class="ti-close"></span> </button>
      <div class="modal_con_outer">
         <div id="modal_content" class="col-lg-4 col-sm-6 modal_con_inner" style="margin: auto;text-align: center;float: none;background: #fff;min-height: 150px;padding: 30px;">
            <img src="img/gdrive_logo.png" height="130px;" style="margin: auto;">   
            <hr/>
            Connect your google drive.<br/> <small>Click on the button to connect your google drive.</small><br/><br/>
            <a href="google_drive_auth.php" class="btn btn-sm btn-success">CONNECT DRIVE</a>
         </div>
      </div> 
    </div>  <!-- custom image modal -->
    
    <!-- Footer start -->
    <footer class="footer" style="border-top: 1px solid#dadada;z-index:1000;position: fixed;">
      <div class="container">
          <div class="col-lg-6 col-sm-6 col-xs-6 " style="padding: 10px;">
               <button class="btn btn-sm btn-success" onclick="downloadAll();">DOWNLOAD ALL</button>
               <button class="btn btn-sm btn-info" onclick="downloadSel();">DOWNLOAD SELECTED</button>
          </div>
          <div class="col-lg-6 col-sm-6 col-xs-6 float-right text-right" style="padding: 10px;float-right">
             
               <button class="btn btn-sm btn-success" onclick="backupAll();">BACKUP ALL</button>
               <button class="btn btn-sm btn-info" onclick="backupSel();">BACKUP SELECTED</button>
          </div>
      </div>
    </footer> <!-- page footer -->
 
    <!-- Javascript libraries -->
   	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  	<script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/notify.min.js"></script>
    <!-- Javascript libraries -->



    <!-- Javascript custom libraries -->
    <script type="text/javascript" src="js/slider.js"></script>        <!-- custom slider js -->
    <script type="text/javascript" src="js/download_zip.js"></script>  <!-- download zip js  -->
    <script type="text/javascript" src="js/gdrive_backup.js"></script> <!-- gdrive backup js -->
    <!-- Javascript custom libraries -->

    <script>

      
      $.notify.defaults();

/*$.notify("Hello World",{
  autoHide: true,
  autoHideDelay: 5000,
  arrowShow: true,
  arrowSize: 5,
  position: 'top center',
  style: 'bootstrap',
  className: 'info',
  gap: 5
});*/

     $(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();}); </script> 

</body>
</html>