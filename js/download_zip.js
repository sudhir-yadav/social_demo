 
 function download(args)
  {
     var id = args.id;  
     if(args.images === undefined)
        return false;
     $('#pgstat_'+args.id).css('width',"0%"); 
    $('#pgstat_tx_'+args.id).css('display',"block");
     $('#prog_'+args.id).fadeIn(500);
     $("#funct_"+args.id).children(".temp_a").remove();
     backup_zip(args,0,0);
  }

  function backup_zip(args,i,t)
  {
      if(i < args.images.length)
      {
       var m = {'index':i+1,'folder_id':args.id,'folder_name':args.name,'file':args.images[i]['source'],'total':args.images.length};     
       $.ajax({
             type: "POST",
             data: {info:m},
             async:true,
             cache :false,
             dataType : "json",
             url: "web_service/download_folder.php",
             success: function(data){
              console.log(data);
               t +=1;
               var per = Math.ceil((t/args.images.length)*100);
               $('#pgstat_'+args.id).css('width',per+"%");
               $('#pgstat_tx_'+args.id+' .txt').html(per+"%");
               if(per == 100) {
                 $('#prog_'+args.id).fadeOut(1700);               
                 var btn = '<a id="a_'+args.id+'" class="down_lin folder_usibility" href=\''+data["link"]+'\' download=\''+args.name+'\'><span class="ti-zip" data-toggle="tooltip" data-placement="bottom" title="Download Zip"></span></a>';
                 $('#funct_'+args.id).append(btn); 
                 $('#pgstat_tx_'+args.id).css('display',"none");
               }
                i+=1
                backup_zip(args,i,t);                 
             }
        });
      }
  } 

  function downloadSel()
  {
     var m = new Array();
     $("input[name='folder[]']:checked").each(function(){  m.push($(this).val());});
      $('#modal1').css("display","table");
      $('body').addClass('modal_no_margin');
     $.ajax({
             type: "POST",
             data: {info:m},
             async:true,
             url: "web_service/down_all_folder.php",
             success: function(data){
                 console.log(data);
                 if(data){
                   $("input[name='folder[]']:checked").each(function(){ $(this).removeAttr('checked'); });
                   $("#arc_count").html(data.archive_count);
                  $('#modal1').fadeOut();$('body').removeClass('modal_no_margin');
                 }               
             }
        });
  }

  function downloadAll()
  {
    $('#modal1').css("display","table");
    $('body').addClass('modal_no_margin');
     var m = new Array();
     $("input[name='folder[]']").each(function(){ m.push($(this).val()); });
     $.ajax({
             type: "POST",
             data: {info:m},
             async:true,
             url: "web_service/down_all_folder.php",
             success: function(data){
                 console.log(data); 
                 if(data){
                   $("input[name='folder[]']").each(function(){ $(this).removeAttr('checked'); });
                    $("#arc_count").html(data.archive_count);
                  $('#modal1').fadeOut();$('body').removeClass('modal_no_margin');
                 }                
             }
        });
  }