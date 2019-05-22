<!-- Main Footer -->
  <footer class="main-footer no-print">
    <!-- To the right -->
    <!-- <div class="pull-right hidden-xs">
      Anything you want
    </div> -->
    <!-- Default to the left -->
    <small>
    	{{ config('app.name', 'Hisabe') }} - V{{config('author.app_version')}} | Copyright &copy; {{ date('Y') }} All rights reserved.
    </small>
    <div class="btn-group pull-right">
      	<button type="button" class="btn btn-success btn-xs toggle-font-size" data-size="s"><i class="fa fa-font"></i> <i class="fa fa-minus"></i></button>
      	<button type="button" class="btn btn-success btn-xs toggle-font-size" data-size="m"> <i class="fa fa-font"></i> </button>
      	<button type="button" class="btn btn-success btn-xs toggle-font-size" data-size="l"><i class="fa fa-font"></i> <i class="fa fa-plus"></i></button>
      	<button type="button" class="btn btn-success btn-xs toggle-font-size" data-size="xl"><i class="fa fa-font"></i> <i class="fa fa-plus"></i><i class="fa fa-plus"></i></button>
    </div>
    
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