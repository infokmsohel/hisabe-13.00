<!-- Main Footer -->
  <footer class="no-print text-center text-info">
    <!-- To the right -->
    <!-- <div class="pull-right hidden-xs">
      Anything you want
    </div> -->
    <!-- Default to the left -->
    <small>
    	<b>{{ config('app.name', 'hisabe') }} - V{{config('author.app_version')}} | Copyright &copy; {{ date('Y') }} All rights reserved.</b>
    </small>
    
    <!-- for User Inactivity 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
          var idleState = false;
          var idleTimer = null;
          $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
              clearTimeout(idleTimer);
              if (idleState == true) { 
                        idleTimer = 0;
                        //alert(1);
                 // $("body").css('background-color','#fff');            
              }
              idleState = false;
              idleTimer = setTimeout(function () { 
                  window.location.href="{{url('user/inactive')}}";                 
                  idleState = true; },900000);
          });  
      });
    </script>
    -->
</footer>