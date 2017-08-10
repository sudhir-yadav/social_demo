    var args_slid1v ;
    var i_slid1v = 0;
    var togglei_slid1v = 0;
        function slideShow(arg)
        {  
            args_slid1v = arg;
            if(args_slid1v.images === undefined)
              return false;
            if(args_slid1v.images.length > 0)
            {
              $('#modal').css("display","table");
              $('body').addClass('modal_no_margin');
              start();
            } 
        }
      $('#playPause').click(function(){if(togglei_slid1v == 0){ pauseB();togglei_slid1v = 1; }else{playB();togglei_slid1v = 0;}});
      function playB(){$("#playPause span").attr('class','ti-control-pause');start();}
      function pauseB(){$("#playPause span").attr('class','ti-control-play');pause();}
      function start(){$('#modal_content img').attr("src",args_slid1v.images[i_slid1v].src);timer = setTimeout(tick, 1800);};
      function tick(){i_slid1v++;if(i_slid1v == (args_slid1v.images.length)){i_slid1v = 0;};start();};
      function pause(){clearTimeout(timer);};
      function next(){pauseB();i_slid1v++;if(i_slid1v == (args_slid1v.images.length-1)){i_slid1v = 0;};$('#modal_content img').attr("src",args_slid1v.images[i_slid1v].src);};
      function prev(){pauseB();i_slid1v--;if(i_slid1v < 0){i_slid1v = (args_slid1v.images.length-1);};$('#modal_content img').attr("src",args_slid1v.images[i_slid1v].src);};
      function stop(){clearTimeout(timer);i_slid1v=0;$('#modal').fadeOut();$('body').removeClass('modal_no_margin');/*$('#content').removeClass('modal_no_margin');*/$("#playPause span").attr('class','ti-control-pause');};
   