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
<h1><?php echo $data['author']->fullname ?></h1>
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
                  		<td>Full Name</td>
                  		<td><h4><?php echo $data['author']->fullname ?></h4></td>
                  	</tr>
                    <tr>
                      <td class="width30">Number of books</td>
                      <td class="width70"><span class="badge badge-info"><?php echo $data['author']->count ?></span>
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
            <h5>Gallery</h5>
          </div>
          <div class="widget-content">
            <ul class="thumbnails">
                <?php foreach ($data['author_books'] as $key => $books):?>
	              <li class="span2">
	                <a> <?php echo Media::httpimg($books->image,'100%','100%') ?> </a>
	                <div style="clear:both"></div>
	                <div class="actions">
	                  <a title="Se details" data-action="view" href="#" id="<?php echo Crypt::Tokenid($books->google_id) ?>">
	                  	<i class="icon-eye-open"></i>
	                  </a>
	                  <a title="View on Google"  data-link="<?php echo $books->previewlink ?>" data-action="google"  href="#">
	                  	<i class="icon-cloud"></i>
	                  </a>
	                  <a class="lightbox_trigger"  href="<?php echo $books->image ?>">
	                  	<i class="icon-search"></i>
	                  </a>
	                </div>
	              </li>
                <?php endforeach ?>
            </ul>
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