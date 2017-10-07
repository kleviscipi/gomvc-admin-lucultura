<!-- Container fluid -->
</div> 
<!-- end Container fluid -->
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2016 &copy; Admin Lucultura. Developed by <a>Klevis Cipi</a> </div>
</div>
<!--End-Footer-part-->
<?php
use Go\Media as Media;
use Go\Url as Url;
use Go\Session as Session;
use Go\Crypt as Crypt;
?>
<?php 
    echo Media::js('jquery.dataTables.min.js');
    echo "<br>";
    echo Media::js('matrix.tables.js');
    echo "<br>";
    echo Media::js('bootstrap.min.js');
    echo "<br>";
    echo Media::js('jquery.ui.custom.js');
    echo "<br>";
    echo Media::js('gojs.js');
    echo "<br>";
    echo Media::js('jquery.gritter.min.js');
    echo "<br>";
    echo Media::js('jquery.peity.min.js');
    echo "<br>";
    echo Media::js('matrix.js');
    echo "<br>";
    echo Media::js('select2.min.js');
    echo "<br>";
    echo Media::js('matrix.interface.js');
    echo "<br>";
    echo Media::js('matrix.popover.js');
    echo "<br>";
    echo Media::js('bootstrap-wysihtml5.js');
    echo "<br>";
    echo Media::js('jquery.uniform.js');
    echo "<br>";
    echo Media::js('matrix.form_common.js');
    echo "<br>";
    echo Media::js('flipclock.js');
    echo "<br>";
?>
<script type="text/javascript">
(function () {
$('#contenuto').find('a').live('click',function(event){
        data    = $(this).data('redirect');
        id      = $(this).attr('id');
        post ='&word='+id;
        switch(data){
            case "movieonsite":
            window.location="http://www.imdb.com/title/"+id;
            break;
            
            case "movielucultura":
            Request.dataPost('/Api/Admin/redirects',post,function(response){
                window.location="/Movies/View/"+response.data;     
            });
            break;

            case "actoronsite":
            window.location="http://www.imdb.com/name/"+id;
            break;

            case "actorlucultura":
            Request.dataPost('/Api/Admin/redirects',post,function(response){
                window.location="/Movies/Viewactor/"+response.data;     
            });
            break;

            case "bookonsite":
            window.location=id;
            break;

            case "booklucultura":
            Request.dataPost('/Api/Admin/redirects',post,function(response){
                window.location="/Books/View/"+response.data;     
            });
            break;

            case "authorlucultura":
            Request.dataPost('/Api/Admin/redirects',post,function(response){
                window.location="/Books/Viewauthors/"+response.data;     
            });

            break;
        }
        event.preventDefault();
})
})();

</script>
</body>
</html>
