<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;
use Go\Crypt as Crypt;
use Go\Number as Number;
/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/
?>
<div class="row-fluid">
<?php $msg->display();?>
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
	    <h5>List of videos</h5>
	  </div>
	  <div class="dataTables_filter" id="example_filter">
	  	<label>Search: <input type="text" aria-controls="example"></label>
	  </div>
	  <div class="widget-content nopadding">
	    <table class="table table-bordered data-table">
	      <thead>
	        <tr>
	          <th>Tags</th>
	          <th>Web width</th>
	          <th>Web height</th>
	          <th>Downloads</th>
	          <th>Size</th>
	          <th>Duration</th>
	          <th>Action</th>
	        </tr>
	      </thead>
	      <tbody id='contentfilms'>
	      <?php $i=0; ?>
	      <?php foreach ($data['videos'] as $key => $video):?>
	          <tr class="gradeX" id="<?php echo $i ?>">
	            <td>
	            <?php $tags = explode(",",$video->tags);?>
	            <?php foreach ($tags as $key => $tag):?>
	            	<span class="badge badge-info" ><?php echo $tag ?></span>
	            <?php endforeach?>
	            </td>
	            <td><?php echo $video->webwidth?></td>
	            <td><?php echo $video->webheight ?></td>
	            <td>
	            <?php
	            if(empty($video->downloads)){
	                $video->downloads = "No Downloads";
	                $class= "badge-important";
	            }else{
	                $class= "badge-warning";
	            }?>
	             <span class="badge <?php echo $class ?>"><?php echo $video->downloads  ?></span>
	            </td>
	            <td><?php echo Number::humanSize($video->size) ?></td>
	            <td><?php echo $video->duration ?></td>
	            <td class="taskOptions">
		            <a data-action='view' id="<?php echo Crypt::Tokenid($video->id) ?>" class="tip-top" data-original-title="View">
		            	<i class="icon-eye-open"></i>
		            </a>
		            <a href="<?php echo $video->pageurl ?>" target='new' class="tip-top" data-original-title="Pixababy">
		            	<i class="icon-cloud"></i>
		            </a>
		            <a data-action='delete' data-idtable="<?php echo $i ?>" id="<?php echo Crypt::Tokenid($video->id) ?>" class="tip-top" data-original-title="Delete">
		            	<i class="icon-remove"></i>
		            </a>
	            </td>
	          </tr>
	          <?php $i ++; ?>
	      <?php endforeach ?>
	      </tbody>
	    </table>
	  </div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  var Videos={
    init:function(conf){
      this.conf = conf;
      this.events();
    },
    events:function(){
      this.conf.button.on('click',function(){
        data = $(this).data('action');
        id   = $(this).attr('id');
        switch(data){
          case "view":
          window.location = "/Natyres/viewvideo/"+id;
          break;
          case "delete":
          idtable = $(this).data('idtable');
          Videos.delete(id,idtable);
          break;
        }
      });
    },
    delete:function(id,idtable){
      post ='&id='+id;
      $('#'+idtable).css('background-color','red');
      Request.callPost('/Api/Natyres/deletevideo',post,function(response){
        if(response.error < 1){
          $('#'+idtable).fadeTo('2000',0,function(){
            $('#'+idtable).remove();
          });
        }
      });

    }
  }
  Videos.init({
    button:$('.taskOptions').find('a')


  });
});
</script>