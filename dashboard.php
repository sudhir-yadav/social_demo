<?php
$access = "yes";
require_once __DIR__.'/config.php';
require_once __DIR__.'/vendor/autoload.php';
session_start();
if($_SESSION['logged_in'] != 'true')
{
    header('Location:login');exit();
}

$fb = new \Facebook\Facebook([
              'app_id' => FB_APP_ID,
              'app_secret' => FB_APP_SECRET,
              'default_graph_version' => FB_APP_VERSION
        ]);

 try {
  //$response = $fb->get('/me/albums?fields=id,name,picture{url},photo_count,photos{images,name}', $_SESSION['fb_access_token']);
  $response = $fb->get('/me/albums?fields=id,name,picture{url},photo_count,photos.limit(1000){source}', $_SESSION['fb_access_token']);


} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user_album = $response->getGraphEdge();
$user_album = $user_album->asArray();
/*echo "<pre>";
//print_r($user_album);
echo "</pre>";

echo "<pre>";
for($i=0;$i<count($user_album);$i++)
{
       echo $user_album[$i]['name']."<br/>";
       echo $user_album[$i]['id']."<br/>";
       echo $user_album[$i]['picture']['url']."<br/>";
       echo $user_album[$i]['photo_count']."<br/>";
       if($user_album[$i]['photo_count'] > 0)
       {
         if($user_album[$i]['photo_count'] > 100 )
         {
          $len = floor(($user_album[$i]['photo_count']/count($user_album[$i]['photos'])));
          $offset = 0;
          for($j=0;$j<$len;$j++)
          {
            $offset+=100;
            $off_response = $fb->get('/'.$user_album[$i]['id'].'/photos?pretty=0&fields=source&offset='.$offset.'&limit=100', $_SESSION['fb_access_token']);
            $m = $off_response->getGraphEdge();
             $user_album[$i]['photos'] = array_merge($user_album[$i]['photos'], $m->asArray());
          }
         }
       }
}
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
    <link rel="stylesheet" type="text/css" href="css/slider.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <style>
    body,html{font-family:"Source Sans Pro";}
    .folder_name{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
        }
        .folder{

        }
        .folder_name::hover
        {
            cursor: pointer;
        }

        @keyframes blink {
                          0% {
                              color:rgba(255,255,255,1)
                          }
                          50% {
                              color:rgba(255,255,255,0.5)
                          }
                          100% {
                              color:rgba(255,255,255,1)
                          }
                      }

    .wt_txt{
      -moz-transition:all 0.5s ease-in-out;
    -webkit-transition:all 0.5s ease-in-out;
    -o-transition:all 0.5s ease-in-out;
    -ms-transition:all 0.5s ease-in-out;
    transition:all 0.5s ease-in-out; 
        -moz-animation:blink normal 1.5s infinite ease-in-out; /* Firefox */
    -webkit-animation:blink normal 1.5s infinite ease-in-out; /* Webkit */
    -ms-animation:blink normal 1.5s infinite ease-in-out; /* IE */
    animation:blink normal 1.5s infinite ease-in-out; /* Opera */
    }
</style>
</head>
<body>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="font-weight:700;color:#1ab4e2;" href="#">SOCIAL STORY</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse pull-right">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#"><span class="ti-facebook"></span> Facebook</a></li>
            <!-- <li><a href="#about"><span class="ti-twitter-alt"></span> Twitter</a></li> -->
            <li class="dropdown">
              <a style="padding:10px;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <img src="<?php echo $_SESSION['user']['picture']; ?>" style="
    height: 30px;
    border-radius: 30px;
    width: 30px;
    margin-right: 2px;
"> <?php echo $_SESSION['user']['name']; ?><span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="ti-write"></span> &nbsp; About App</a></li>
                <li><a href="#"><span class="ti-user"></span> &nbsp; About Developer</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="logout"><span class="ti-unlock"></span> &nbsp; Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
      
    </nav>

    <!-- Begin page content -->
    <div class="container" id="content">

        <div><h3 style="font-weight:100;"><span class="ti-folder"></span> FACEBOOK ALBUM (<?php echo count($user_album); ?>) &nbsp; 
        <!-- <button class="btn btn-success">DOWNLOAD ALL</button>
        <button class="btn btn-info">DOWNLOAD SELECTED</button> -->
        </h3>
       
        </div>

        <hr/>
        <div class="row">
         <!--  <img src="img/loader.gif" style="
    position: absolute;
    left: 50%;
"> -->

           <?php $fldr_stack; for($i=0;$i<count($user_album);$i++){ ?>
               
                  
                    <div class=" col-lg-3 col-md-3 col-sm-4 col-xs-6 animated bounceIn">
                        <div class="panel ">

                       <div id="prog_<?php echo $user_album[$i]['id']; ?>" style="
    position: absolute;
    z-index: 100;
    height: 100%;
    width: 100%;
    text-align: center;
    display: block;
    background: rgba(0, 0, 0, 0.5);
    padding: 28% 25px;
    color: #fff;
    display: none;
">
          <span id="pgstat_tx_<?php echo $user_album[$i]['id']; ?>"><span class="wt_txt">Zipping Files..</span></span>
       <div class="progress" style="height:5px;">
          <div id="pgstat_<?php echo $user_album[$i]['id']; ?>" class="progress-bar " role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </div> 
                 <?php 
                         if($user_album[$i]['photo_count'] > 0)
                           {
                             if($user_album[$i]['photo_count'] > 100 )
                             {
                              $len = ($user_album[$i]['photo_count']/$user_album[$i]['photo_count']);
                              $offset = 0;
                              for($j=0;$j<$len;$j++)
                              {
                                 $offset+=100;
                                 $off_response = $fb->get('/'.$user_album[$i]['id'].'/photos?pretty=0&fields=source&offset='.$offset.'&limit=100', $_SESSION['fb_access_token']);
                                 $m = $off_response->getGraphEdge();
                                   $user_album[$i]['photos'] = array_merge($user_album[$i]['photos'], $m->asArray());
                              }
                             }
                           }
                     ?>
                            <div class="panel-heading " style="background: url('<?php echo $user_album[$i]['picture']['url']; ?>')center no-repeat;background-size:100%;">

                                <div style="position:absolute;bottom:-1px;padding:5px;width:100%;color:#fff;    background: rgba(0, 0, 0, 0.5);">
                                    <div class="col-xs-3">
                                        
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><span class="ti-image"></span> <?php echo $user_album[$i]['photo_count']; ?> Photos </div>
                                    </div>
                                </div>
                            </div>
                                <div class="panel-footer nopadding">
                                   <div class="col-lg-7 col-xs-10 folder_name ">
                                        <input  id="<?php echo "folder".$i; ?>" type="checkbox" name="folder[]" value='<?php echo $user_album[$i]['id'];  ?>' />
                                         <label alt="<?php echo $user_album[$i]['name']; ?>" style="display: inline-block;width: 100%;padding: 12px 0;" for="<?php echo "folder".$i; ?>"> <?php echo $user_album[$i]['name']; ?> </label>

                                   </div>
                                   <div class="col-lg-5 col-xs-12 text-center" style="padding:10px 0;">
                                        <button class="folder_usibility">
                                           <img data-toggle="tooltip" data-placement="bottom" title="Upload to google drive" style="height: 16px;margin-top: -4px;" src="img/drive_12.png">
                                       </button>
                                        <button onclick='slideShow(<?php echo '{"name":"'.$user_album[$i]['name'].'","images":'.json_encode($user_album[$i]['photos']).'}'; ?>);' class="folder_usibility">
                                        <span class="ti-layout-slider" data-toggle="tooltip" data-placement="bottom" title="View Slide Show"></span>
                                        </button>
     <button onclick='download(<?php echo '{"id":"'.$user_album[$i]['id'].'","name":"'.$user_album[$i]['name'].'","images":'.json_encode($user_album[$i]['photos']).'}'; ?>);' class="folder_usibility">

                                        <span class="ti-download" data-toggle="tooltip" data-placement="bottom" title="Download Folder"></span>
                                        </button>
                                   </div>

                                    <div class="clearfix"></div>
                                </div>
                        </div>
                    </div>
              <?php }  ?>
        </div>

    </div>

<!--   <div id="" style="
    border: 1px solid #ffffff;
    position: fixed;
    bottom: 71px;
    width: 191px;
    background: #fbfbfb;
    left: 15px;
    /* min-height: 65px; */
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    border-radius: 3px;
">
   <div style="
    height: 50px;
    background: #35a5c7;
    padding: 15px;
    color: #fff;
    border-radius: 3px 3px 0 0;
">2 FILES
</div>

    <ul style="
    display: block;
    margin: 0px;
    padding: 0px;
">
        <li style="
    display: block;
    height: 45px;
    width: 100%;
    padding: 10px;
">dwonload 1</li>
        
    </ul>
  </div> -->

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
 </div> 
<!-- <pre>
 <?php
  
 ?> -->


    <footer class="footer" style="box-shadow: 0 0 15px rgba(0,0,0,0.2);z-index:1000;position: fixed;">
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
    </footer>


 
 	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="js/slider.js"></script>

<script>
  $(document).ready(function(){$('[data-toggle="tooltip"]').tooltip(); });
  function download(args)
  {
      
      var id = args.id;  
      if(args.images === undefined)
        return false;
      $('#pgstat_'+args.id).css('width',"0%");
      
      $('#prog_'+args.id).fadeIn(500);
     backup(args,0,0);
  }

  function backup(args,i,t)
  {
      if(i < args.images.length)
      {
        var m = {'index':i+1,'folder_id':args.id,'folder_name':args.name,'file':args.images[i]['source']};     
       $.ajax({
             type: "POST",
             data: {info:m},
             async:true,
             cache :false,
             dataType : "json",
             url: "download_folder.php",
             success: function(data){
                 console.log(data);
               t +=1;
               var per = Math.ceil((t/args.images.length)*100);
               $('#pgstat_'+args.id).css('width',per+"%");
               $('#pgstat_tx_'+args.id).html(per+"%");
               if(per == 100)
                {
                  $('#prog_'+args.id).fadeOut(1700);
                }
                i+=1
                backup(args,i,t);                 
             }
        });
      }
  } 

  function loader(id)
  {
    $('#prog_'+id).css('display','block');
  }


  function downloadSel()
  {
     var m = new Array();
     $("input[name='folder[]']:checked").each(function(){  m.push($(this).val());});
     console.log(m);
     $.ajax({
             type: "POST",
             data: {info:m},
             async:true,
             url: "down_all_folder.php",
             success: function(data){
                 console.log(data);               
             }
        });
  }
  function downloadAll()
  {
     var m = new Array();
     $("input[name='folder[]']").each(function(){ m.push($(this).val()); });
     console.log(m);
     $.ajax({
             type: "POST",
             data: {info:m},
             async:true,
             url: "down_all_folder.php",
             success: function(data){
                 console.log(data);               
             }
        });
  }
  function backupSel()
  {
     var m = new Array();
     $("input[name='folder[]']:checked").each(function(){  m.push($(this).val());});
     console.log(m);
  }
  function backupAll()
  {
     var m = new Array();
     $("input[name='folder[]']").each(function(){ m.push($(this).val()); });
     console.log(m);
  }
</script> 

</body>

</body>
</html>