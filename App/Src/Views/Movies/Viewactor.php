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
<?php $msg->display() ?>

<?php if(!empty($data['actor'])): ?>  
<h1><?php  echo $data['actor']->name ?></h1>
<hr>
<div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-book"></i> </span>
            <h5> Actor details </h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span6">
                <table class="">
                  <tbody>
                    <tr>
                      <td><h4><?php echo $data['actor']->name ?></h4></td>
                    </tr>
                    <tr>
                      <td>
                		<div class="actions"> 
                			<a class="lightbox_trigger" href="<?php echo  $data['actor']->image ?>">
                				<?php echo Media::httpimg($data['actor']->image) ?>
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
                      <td class="width30">Imdb</td>
                      <td class="width70">
                      		<button data-action="actorimdb" class="btn btn-mini btn-inverse">Preview</button>
                      </td>
                    </tr>
                     <tr>
                      <td class="width30">Images imdb</td>
                      <td class="width70">
                          <button data-action="img" class="btn btn-mini btn-warning">Preview Images</button>
                      </td>
                    </tr>
                    <tr>
		                	<td>Ocuption</td>
	                    <td><?php echo trim($data['actor']->ocupation,"{}") ?></td>
	                 </tr>
                   <tr>
                      <td class="width30">Description</td>
                      <td class="width70"><?php echo $data['actor']->description ?></td>
                   </tr>
                    </tbody>
                  
                </table>
              </div>
              <div class="span10">
                <div class="widget-box">
                  <div class="widget-title"> <span class="icon"> <i class="icon-picture"></i> </span>
                    <h5>Gallery</h5>
                  </div>
                  <div class="widget-content">
                   <ul class="thumbnails">
                    <?php foreach ($data['actor_movies'] as $key => $movie): ?>
                       <li class="span2">
                        <a> <?php echo Media::httpimg($movie->image,'100%','100%') ?> </a>
                        <div style="clear:both"></div>
                        <div class="actions">
                          <a title="Se details" data-action="movie" href="#" id="<?php echo Crypt::Tokenid($movie->movie_idm) ?>">
                              <i class="icon-eye-open"></i>
                          </a>
                          <a title="View on imdb"  data-link="<?php echo $movie->movie_idm ?>" data-action="movieidm" >
                              <i class="icon-cloud"></i>
                          </a>
                          <a class="lightbox_trigger"  href="<?php echo $movie->image ?>">
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
	    				case "actorimdb":
	    				window.location = "http://www.imdb.com/name/<?php echo $data['actor']->idm_id ?>";
	    				break;
              case "img":
              window.location="http://www.imdb.com/name/<?php echo $data['actor']->idm_id ?>/mediaviewer/"
              break;
              case "author":
              window.location = "/Books/Viewauthors/"+id;
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
	    	}
	    }
	    Thisbook.init({
	    	button:$('button'),
        alink:$('.thumbnails').find('a')


	    });
    });

    </script>
<?php else: ?>
<h1>No data</h1>
<?php endif ?>