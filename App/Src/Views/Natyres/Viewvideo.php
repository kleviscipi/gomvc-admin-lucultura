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
<h1>Video on view</h1>
<hr>
<div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-book"></i> </span>
            <h5> Author details </h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span6">
                <table class="table table-bordered table-invoice">
                  <tbody>
                  	<tr>
                  		<td>Tags</td>
                  		<td>
		                	<?php $tags = explode(",",$data['video']->tags);?>
		                    <?php foreach ($tags as $key => $tag):?>
		                    	<span class="badge badge-info" ><?php echo $tag ?></span>
		                    <?php endforeach?>
                  		</td>
                  	</tr>
                    <tr>	
                      <td class="width30">Size</td>
                      <td class="width70">
                      	<span class="badge badge-important">
                      		<?php echo Number::humanSize($data['video']->size) ?>
                      	</span>
                    </tr>
                    <tr>
                      <td class="width30">Downloads</td>
                      <td class="width70">
	                    <?php
	                    if(empty($data['video']->downloads)){
	                        $data['video']->downloads = "No Downloads";
	                        $class= "badge-important";
	                    }else{
	                        $class= "badge-warning";
	                    }?>
                     	<span class="badge <?php echo $class ?>">
                     		<?php echo $data['video']->downloads  ?>
                     	</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="width30">Duration</td>
                      <td class="width70">
                      	<span class="badge badge-success">
                      		<?php echo $data['video']->duration ?>
                      	</span>
                    </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="span10">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-picture"></i> </span>
            <h5>Video</h5>
          </div>
          <div class="widget-content">
			<iframe src="<?php echo $data['video']->weburl ?>" width="100%" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
$(document).ready(function(){
    var Thisbook={
    	init:function(conf){
    		this.conf = conf;
    		this.events();
    	},
    	events:function(){
    		this.conf.button.on('click',function(){
    			data = $(this).data('action');
    			switch(data){
    				case "google":
    				window.location = "<?php echo $data['book']->previewlink ?>";
    				break;
    			}
    		});
    		this.conf.link.on('click',function(){
    			data = $(this).data('action');
    			id = $(this).attr('id');		
    			switch(data){
    				case "view":
    				window.location = "/Books/View/"+id;
    				break;
    				case "google":
					googlelink = $(this).data('link');
    				window.location = googlelink;
    				break;
    			}
    		});
    	}
    }
    Thisbook.init({
    	button:$('button'),
    	link:$('.actions').find('a')
    });
});
</script>