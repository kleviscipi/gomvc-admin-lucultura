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
<h1><?php echo $data['book']->author_name ?></h1>
<hr>
<div class="row-fluid">
  <div class="span12">
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"> <i class="icon-book"></i> </span>
        <h5> Book details </h5>
      </div>
      <div class="widget-content">
        <div class="row-fluid">
          <div class="span6">
            <table class="">
              <tbody>
                <tr>
                  <td><h4><?php echo $data['book']->title ?></h4></td>
                </tr>
                <tr>
                  <td><button data-action="author" class="btn btn-mini btn-info" id="<?php echo Crypt::Tokenid($data['book']->author_id) ?>"><?php echo $data['book']->author_name ?></button></td>
                </tr>
                <tr>
                  <td>
            		<div class="actions"> 
            			<a class="lightbox_trigger" href="<?php echo  $data['book']->image ?>">
            				<?php echo Media::httpimg($data['book']->image) ?>
            			</a>
            		</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="span6">
            <table class="table table-bordered table-invoice">
              <tbody>
              		<tr>
                      <td class="width30">Google ID:</td>
                      <td class="width70"><strong><?php echo $data['book']->google_id ?></strong>
                      <button data-action="google" class="btn btn-mini btn-inverse">Preview</button>
                    </tr>
                    <tr>
                      <td>Publisher</td>
                      <td><strong><?php echo $data['book']->publisher ?></strong></td>
                    </tr>
                    <tr>
                      <td>Date:</td>
                      <td><strong><?php echo $data['book']->publisherdate ?></strong></td>
                    </tr>
                  	<tr>
                  	<td class="width30">Rating</td>
                    <td class="width70">
	                    <?php
	                    if(empty($book->rating)){
	                        $book->rating = "No rating";
	                        $class= "badge-important";
	                    }else{
	                        $class= "badge-warning";
	                    }?>
                     <span class="badge <?php echo $class ?>"><?php echo $book->rating  ?></span>
                     </td>
                  	</tr>
	                <tr>
                      <td>Pages</td>
                      <td><strong><?php echo $data['book']->pages ?></strong></td>
                    </tr>
                    <tr>
                      	<td>Languages</td>
                      	<td><span class="badge badge-inverse"><?php echo strtoupper($data['book']->language) ?></span></td>
                    </tr>
	                <tr>
	                	<td>Categories</td>
                     	<td><?php echo trim($data['book']->categories,"{}") ?></td>
                    </tr>
                </tbody>
            </table>
          </div>
          <div class="span10">
	        <div class="widget-box">
	          <div class="widget-title"><span class="icon"> <i class="icon-list"></i> </span>
	            <h5>Description</h5>
	          </div>
	          <div class="widget-content"><?php echo $data['book']->description ?></div>
	        </div>
	      </div>
        </div>
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
        id = $(this).attr('id');
    			data = $(this).data('action');
    			switch(data){
    				case "google":
    				window.location = "<?php echo $data['book']->previewlink ?>";
    				break;
          case "author":
          window.location = "/Books/Viewauthors/"+id;
          break;
    			}
    		});
    	}
    }
    Thisbook.init({
    	button:$('button')
    });
});
</script>