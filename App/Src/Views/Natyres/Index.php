<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;
use Go\Crypt as Crypt;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/
?>
<?php echo Media::css('justified.css'); ?>
<?php echo Media::js('imagesloaded.pkgd.min.js'); ?>
<?php echo Media::js('justified.min.js'); ?>
<h1>Images from Pixabay</h1>
<hr>
<div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-picture"></i> </span>
            <h5>Gallery</h5>
          </div>
          <div class="widget-content">
          <div id="grid-container">
            <?php foreach ($data['natyres'] as $key => $natyre):?>
             <a class="lightbox_trigger" href="<?php echo $natyre->weburl; ?>"> <?php echo Media::httpimg($natyre->weburl,'100%','100%','grid-item') ?>
              </a>
             <?php endforeach ?>
          </div>
          <div class="pagination alternate"><?php echo $data['pageLinks'] ?></div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
  $(document).ready(function(){
    var Natyre={
      init:function(conf){
        this.conf = conf;
        this.events();
        Natyre.img();
      },
      events:function(){
        this.conf.button.on('click',function(){
          data = $(this).data('action');
          id   = $(this).attr('id');
          switch(data){
            case "view":
            window.location = "/Books/view/"+id;
            break;
            case "delete":
            idtable = $(this).data('idtable');
            Natyre.delete(id,idtable);
            break;
          }
        });
      },
      delete:function(id,idtable){
        post ='&id='+id;
        $('#'+idtable).css('background-color','red');
        Request.callPost('/Api/Books/delete',post,function(response){
          if(response.error < 1){
            $('#'+idtable).fadeTo('2000',0,function(){
              $('#'+idtable).remove();
            });
          }
        });

      },
      img:function(){
          var parameters = {
            gridContainer: '#grid-container',
            gridItems: '.grid-item',
            enableImagesLoaded: true
          };
          var grid = new justifiedGrid(parameters);
              $('body').imagesLoaded( function() {
              grid.initGrid();
           }); 

        }
    }
    Natyre.init({
      button:$('.taskOptions').find('a')


    });
  });
</script>