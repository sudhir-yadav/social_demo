      
      function backup(id)
      {
         var m = new Array();
         m.push(id);
          $('#pgstat_b_'+id).fadeIn(500);  
          $('#prog_'+id).fadeIn(500);
             $.ajax({
                     type: "POST",
                     data: {info:m},
                     async:true,
                     url: "web_service/google_drive_service.php",
                     success: function(data){
                         console.log(data);
                         if(data.status == 0){
                           $('#pgstat_b_'+id).fadeOut(100);  
                           $('#prog_'+id).fadeOut(100);
                           $('#modal2').css("display","table");
                           $('body').addClass('modal_no_margin');
                         } 
                         if(data.status == 1){
                          $('#prog_'+id).fadeOut(1700);
                          $('#pgstat_b_'+id).fadeOut(1700); 
                         }           
                     }
                });
      }

      function backupSel()
      {
         var m = new Array();
         $('#modal3').css("display","table");
        $('body').addClass('modal_no_margin');
         $("input[name='folder[]']:checked").each(function(){  m.push($(this).val());});
         $.ajax({
                     type: "POST",
                     data: {info:m},
                     async:true,
                     url: "web_service/google_drive_service.php",
                     success: function(data){
                         console.log(data);
                         if(data.status == 0){
                           $('#pgstat_b_'+id).fadeOut(100);  
                           $('#prog_'+id).fadeOut(100);
                           $('#modal2').css("display","table");
                           $('body').addClass('modal_no_margin');
                         } 
                         if(data.status == 1){
                            $('#modal3').fadeOut();$('body').removeClass('modal_no_margin');
                         }           
                     }
                });
      }

      function backupAll()
      {
         var m = new Array();
          $('#modal3').css("display","table");
        $('body').addClass('modal_no_margin');
         $("input[name='folder[]']").each(function(){ m.push($(this).val()); });
         $.ajax({
                     type: "POST",
                     data: {info:m},
                     async:true,
                     url: "web_service/google_drive_service.php",
                     success: function(data){
                         console.log(data);
                         if(data.status == 0){
                           $('#pgstat_b_'+id).fadeOut(100);  
                           $('#prog_'+id).fadeOut(100);
                           $('#modal2').css("display","table");
                           $('body').addClass('modal_no_margin');
                         } 
                         if(data.status == 1){
                            $('#modal3').fadeOut();$('body').removeClass('modal_no_margin');
                          
                         }           
                     }
                });
      }
