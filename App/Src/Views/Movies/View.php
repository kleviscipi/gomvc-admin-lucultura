<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;
use Go\Crypt as Crypt;
use Go\Flash as Flash;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

?>
<h1><?php echo $data['movie']->title ?></h1>
<?php echo $msg->display() ?>
<hr>
<div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-book"></i> </span>
            <h5> Movie details </h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span6">
                <table class="">
                  <tbody>
                    <tr>
                      <td><h4><?php echo $data['movie']->title ?></h4></td>
                    </tr>
                    <tr>
                      <td>
                		<div class="actions"> 
                			<a class="lightbox_trigger" href="<?php echo  $data['movie']->image ?>">
                				<?php echo Media::httpimg($data['movie']->image) ?>

                			</a>
                		</div>
                      </td>
                    </tr>

                    <tr>
                      <td><h5>Header site image</h5>
                      <?php if(empty($data['movie']->headerimg)): ?>
                        <p>No image</p>
                      <?php else: ?>
                      <div class="actions"> 
                        <a class="lightbox_trigger" href="/imgmovie/<?php echo  $data['movie']->headerimg ?>">
                          <img width="200px" src="/imgmovie/<?php echo  $data['movie']->headerimg ?>">
                        </a>
                      </div>
                     <?php endif; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="span6">
                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                      <td class="width40">Imdb</td>
                      <td class="width60">
                      		<button data-action="moviemdb" class="btn btn-mini btn-inverse">Preview</button>
                      </td>
                    </tr>
                     <tr>
                      <td class="width40">Images</td>
                      <td class="width60">
                          <button data-action="img" class="btn btn-mini btn-warning">Preview Images</button>
                      </td>
                    </tr>
                    <tr>
                      <td class="width40">Year</td>
                      <td class="width60">
                         <?php echo $data['movie']->year ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="width40">Released</td>
                      <td class="width60">
                         <?php if(empty($data['movie']->released)) : ?>
                          <span class="badge badge-important">No released</span>
                      <?php else: ?>
                          <span class="badge badge-info"><?php echo $data['movie']->released ?></span>
                      <?php endif ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="width40">Rating</td>
                      <td class="width60">
                         <?php if(empty($data['movie']->rating)) : ?>
                          <span class="badge badge-important">No Rating</span>
                      <?php else: ?>
                          <span class="badge badge-info"><?php echo $data['movie']->rating ?></span>
                      <?php endif ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="width40">Casts</td>
                      <td class="width60" id='casts'>
                            <?php 
                            $casts = trim($data['movie']->casts,"{}");
                            $casts = explode(",",$casts);
                            ?>

                            <?php  foreach ($casts as $key => $cast):?>
                            	<span  data-value=<?php echo Crypt::Tokenid(trim($cast,'"'));?> style="cursor:pointer" class="badge badge-success"><?php echo trim($cast,'"') ?></span>
                            <?php endforeach ?>
                      </td>
                    </tr>
                    <tr>
		                <td>Genres</td>
	                    <td>
	                    	<?php 
                            $genre = trim($data['movie']->genres,"{}");
                            $genre = explode(",",$genre);

                            ?>
                            <?php  foreach ($genre as $key => $genr):?>
                            	<span style="cursor:pointer" class="badge badge-inverse"><?php echo trim($genr,'"') ?></span>
                            <?php endforeach ?>

	                    </td>
	                 </tr>
                   <tr>
                      <td class="width40">Description</td>
                      <td class="width60"><?php echo $data['movie']->description ?></td>
                   </tr>
                   <tr>
                      <td class="width40">Actions</td>
                      <td class="width60">
                      <?php 
                      $movie = $data['movie'];
                      if($movie->onsite){
                        $txt      = "Remove from site";
                        $txtalert = "Are you sure to want to remove this movie from site?";
                        $val      = "f";
                        $cl = "btn-danger";
                      }else{
                        $txt      = "Add on site";
                        $txtalert = "Are you sure to want add this movie on site?";
                        $val      = "t";
                        $cl = "btn-success";
                      }
                      if($movie->onheadersite){
                        $txtheader      = "Remove from header site";
                        $txtalerth = "Are you sure to want to remove this movie from header site?";
                        $valh      = "f";
                         $clh = "btn-danger";
                      }else{
                        $txtheader      = "Add on header site";
                        $txtalerth = "Are you sure to want add this movie on header site?";
                        $valh      = "t";
                        $clh = "btn-warning";
                      }
                      if(empty($movie->imgheader)){
                        $txtimg = "Insert Header Img";
                        $climg = "btn-info";
                        $txtalertimg = "Are you sure to want to add one header image?";
                      }else{
                         $txtimg = "Modified Header Img";
                         $climg = "btn-warning";
                         $txtalertimg = "Are you sure to want to edit header image?";
                      }

                      ?>
                         <a data-toggle="modal" href='#moviemodal' class="btn btn-mini btn-inverse">Add Trailer</a>
                         <a data-toggle="modal" href='#moviesite'  id='site' class="btn btn-mini <?php echo $cl ?>"><?php echo $txt ?></a>
                         <a data-toggle="modal" href='#movieheader' id='headersite' class="btn btn-mini <?php echo $clh ?>"><?php echo $txtheader ?></a>
                         <a data-toggle="modal" href='#movieheaderimg' id='headersiteimg' class="btn btn-mini <?php echo $climg ?>"><?php echo $txtimg ?></a>
                        <div id="moviemodal" class="modal hide">
                          <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">×</button>
                            <h3>Insert Trailer</h3>
                          </div>
                          <div class="modal-body">
                            <p>Trailer link example: just id vi956348185</p>
                            <div class="controls">
                              <input type="text" id='movietrailer'  name="trailer" placeholder="Link" class="span12">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <a data-dismiss="modal" id="addtrailer" class="btn btn-primary" href="#">Add</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a>
                          </div>
                        </div>
                        
                        <div id="moviesite" class="modal hide">
                          <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">×</button>
                            <h3>On Site</h3>
                          </div>
                          <div class="modal-body">
                            <p id='modalsmssite'><?php echo $txtalert ?></p>
                          </div>
                          <div class="modal-footer">
                            <a data-dismiss="modal" id="addonsite"  data-value="<?php echo $val ?>" class="btn btn-success">Its OK</a> <a data-dismiss="modal" class="btn btn-danger">Cancel</a>
                          </div>
                        </div>

                        <div id="movieheader" class="modal hide">
                          <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">×</button>
                            <h3>Header Site</h3>
                          </div>
                          <div class="modal-body">
                            <p id='modalsmsheadersite'><?php echo $txtalerth; ?></p>
                          </div>
                          <div class="modal-footer">
                            <a data-dismiss="modal"  data-value="<?php echo $valh ?>" id="addheader" class="btn btn-success">It'is OK </a> <a data-dismiss="modal" class="btn btn-danger">Cancel</a>
                          </div>
                        </div>

                        <div id="movieheaderimg" class="modal hide">
                        <form  action="/Movies/addonheaderimg" method="post" enctype="multipart/form-data">
                          <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">×</button>
                            <h3>Header Image Site</h3>
                          </div>
                          <div class="modal-body">
                          
                            <p id='modalsmsheadersite'><?php echo $txtalertimg; ?></p>
                            <div class="controls">
                                
                                   <input type="hidden" name="idmovie" value="<?php echo $movie->id ?>">
                                   <input type="file"  name="name">
                            </div>
                          </div>
                          <div class="modal-footer">
                          <input type="submit"   class="btn btn-success" value="Upload" class="submit" />
                             <a data-dismiss="modal" class="btn btn-danger">Cancel</a>
                          </div>
                           </form>
                        </div>
                      </td>
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
          <div class="widget-title">
            <h5> Movie Trailers </h5>
          </div>
          <div class="widget-content">
            <?php if(empty($data['movie']->trailerlink)): ?>
              <p>No trailer</p>
            <?php else: ?>
             <iframe src="http://www.imdb.com/videoembed/<?php echo $data['movie']->trailerlink ?>" frameborder="0" allowfullscreen width="90%" height="600">
             </iframe>
           <?php endif ?>
          </div>
      </div>
    </div>

    </div>

    <script type="text/javascript">

    $(document).ready(function(){

	    var Thismovie={
        stateonsite :$('#addonsite').data('value'),
        stateonheader: $('#addheader').data('value'),
	    	init:function(conf){
	    		this.conf = conf;
	    		this.events();
	    	},
	    	events:function(){
	    		this.conf.button.on('click',function(){
            id = $(this).attr('id');
	    			data = $(this).data('action');
	    			switch(data){
	    				case "moviemdb":
	    				window.location = "http://www.imdb.com/title/<?php echo $data['movie']->idm_id ?>";
	    				break;
              case "img":
              window.location="http://www.imdb.com/title/<?php echo $data['movie']->idm_id ?>/mediaviewer/"
              break;
	    			}
	    		});
	          this.conf.alink.on('click',function(){
	            id = $(this).attr('id');
	            data = $(this).data('action');
	            switch(data){
	              case "movieidm":
	              link = $(this).data('link');
	              window.location = "http://www.imdb.com/title/"+link;
	              break;
	              case "movie":
	              window.location = "/Movies/View/"+id;
	              break;
	            }
	          });
	          this.conf.cast.on('click',function(){

	          	 id = $(this).data('value');
	          	 window.location = "/Movies/Viewactor/"+id;
	          });
            this.conf.trailer.live('click',function(){
                val = $('#movietrailer').val();
                id  ="<?php echo $data['movie']->idm_id ?>";
                Thismovie.addtrailer(val,id);
            });
            this.conf.onsite.on('click',function(){
                val = $(this).data('value');
               
              if(Thismovie.stateonsite =="f"){
                $('#site').html('Add on site');
                $('#site').removeClass('btn-danger');
                $('#site').addClass('btn-success');
                 $(this).removeAttr('data-value'); 
                $(this).attr('data-value','t'); 
                $('#modalsmssite').html('Are you sure to want to add this movie on site?'); 
              }else if(Thismovie.stateonsite=="t"){
                $('#site').html('Remove from site');
                $(this).removeAttr('data-value'); 
                $(this).attr('data-value','f'); 
                $('#site').removeClass('btn-success');
                $('#site').addClass('btn-danger');
                $('#modalsmssite').html('Are you sure to want remove this movie from site?'); 
              }
                id  ="<?php echo $data['movie']->idm_id ?>";
                Thismovie.addonsite(Thismovie.stateonsite,id);
            });
            this.conf.onheadersite.on('click',function(){
                val = $(this).data('value');
                if(Thismovie.stateonheader =="f"){
                $('#headersite').html('Add on header site');
                $('#headersite').removeClass('btn-danger');
                $('#headersite').addClass('btn-warning');
                $(this).removeAttr('data-value'); 
                $(this).attr('data-value','t'); 
                $('#modalsmsheadersite').html('Are you sure to want to add this movie on header site?'); 
              }else if(Thismovie.stateonheader=="t"){
                $('#headersite').html('Remove from header site');
                $(this).removeAttr('data-value'); 
                $(this).attr('data-value','f'); 
                $('#headersite').removeClass('btn-warning');
                $('#headersite').addClass('btn-danger');
                $('#modalsmsheadersite').html('Are you sure to want remove this movie from header site?'); 
              }
                id  ="<?php echo $data['movie']->idm_id ?>";
                Thismovie.addonheader(Thismovie.stateonheader,id);
            });

	    	},
        addtrailer:function(val,id){
          if(!val=="" && !id==""){
            post='&value='+val;
            post+='&id='+id;
          }else{
            post="post=empty";
          }
          Request.callPost('/Api/Movies/addtrailer',post,function(){

          });
        },
        addonsite:function(val,id){
          if(!val=="" && !id==""){
            post='&value='+val;
            post+='&id='+id;
          }else{
            post="post=empty";
          }
          Request.callPost('/Api/Movies/addonsite',post,function(response){
            
          });
        },
        addonheader:function(val,id){
          if(!val=="" && !id==""){
            post='&value='+val;
            post+='&id='+id;
          }else{
            post="post=empty";
          }
          Request.callPost('/Api/Movies/addonheadersite',post,function(){

          });
        }
	    }
	    Thismovie.init({
	    	button :$('button'),
	    	cast   :$('#casts').find('span'),
        alink  :$('.thumbnails').find('a'),
        trailer :$('#addtrailer'),
        onsite :$('#addonsite'),
        onheadersite :$('#addheader'),
	    });
    });

    </script>