<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;
use Go\Crypt as Crypt;
/***********************************
* 2016-11-16                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/
?>
<h1><?php echo $data['content-title'] ?></h1>
<hr>
<style>
 .mysearch{
 	border: 1px solid #ce00ff !important;
    padding: 11px 16px !important;
    width: 400px !important;
 }
 .mysearchbutton{
    border: 0 !important;
    margin-left: -3px !important;
    margin-top: -9px !important;
    padding: 11px 20px 12px !important;
 }
</style>
<div class="taskOptions">
<input class="mysearch" type="text" placeholder="Search Movies,Books,Authors,Actors">
	<button class="mysearchbutton" style="background:#28b779;color: white;" type="button" >
		<i class="icon-search icon-white"></i>
	</button>
</div>
<?php $imgstyle = "style='height:50px  !important;width:40px'";?>
<div class="row-fluid">
<div class="span6">
<?php if(!empty($data['searchs']['movies'])): ?>
    <div class="widget-box">
          <div class="widget-title">
            <h5>Movies</h5>
          </div>
          <div class="widget-content nopadding">
            <ul class="recent-posts">
            <?php foreach ($data['searchs']['movies'] as $key => $movie): ?>
              <li>
                <div class="user-thumb"> <img <?php echo $imgstyle ?> alt="<?php echo $movie->title ?>" src="<?php echo $movie->image ?>"> </div>
                <div class="article-post">
                  <div class="fr">
                  	<a id="<?php echo Crypt::Tokenid($movie->id);  ?>" data-fromsearch="movielucultura" class="btn btn-primary btn-mini">View more</a>
                  	<a  id="<?php echo $movie->idm_id  ?>" data-fromsearch="movieonsite" class="btn btn-inverse btn-mini">Origin site</a>
                  </div>
                  <span class="user-info"><?php echo $movie->title  ?> / <?php echo $movie->released  ?> -> <?php echo $movie->genres  ?></span>
                  <p><a> <?php echo substr($movie->description,0,200)."....." ?></a> </p>
                </div>
              </li>
            <?php endforeach; ?>
            </ul>
          </div>
    </div>
<?php endif ?>
<?php if(!empty($data['searchs']['actors'])): ?>
    <div class="widget-box">
          <div class="widget-title">
            <h5>Actors of Movies</h5>
          </div>
          <div class="widget-content nopadding">
            <ul class="recent-posts">
            <?php foreach ($data['searchs']['actors'] as $key => $actor): ?>
              <li>
                <div class="user-thumb"> <img <?php echo $imgstyle ?> alt="<?php echo $actor->name;?>" src="<?php echo $actor->image ?>"> </div>
                <div class="article-post">
                  <div class="fr">
                  	<a id="<?php echo Crypt::Tokenid($actor->idm_id);  ?>" data-fromsearch="actorlucultura" class="btn btn-primary btn-mini">View more</a>
                  	<a  id="<?php echo $actor->idm_id  ?>" data-fromsearch="actoronsite" class="btn btn-inverse btn-mini">Origin site</a>
                  </div>
                  <span class="user-info"><?php echo $actor->name  ?> | <?php echo $action->ocupation  ?></span>
                  <p><a> <?php echo substr($actor->description,0,200)."....." ?></a> </p>
                </div>
              </li>
            <?php endforeach; ?>
            </ul>
          </div>
    </div>
<?php endif ?>
</div>
<div class="span6">
<?php if(!empty($data['searchs']['books'])): ?>
    <div class="widget-box">
          <div class="widget-title">
            <h5>Books</h5>
          </div>
          <div class="widget-content nopadding">
            <ul class="recent-posts">
            <?php foreach ($data['searchs']['books'] as $key => $book): ?>
              <li>
                <div class="user-thumb"> <img <?php echo $imgstyle ?> alt="<?php echo $book->title;?>" src="<?php echo $book->image ?>"> </div>
                <div class="article-post">
                  <div class="fr">
                  	<a id="<?php echo Crypt::Tokenid($book->google_id);  ?>" data-fromsearch="booklucultura" class="btn btn-primary btn-mini">View more</a>
                  	<a  id="<?php echo $book->previewlink  ?>" data-fromsearch="bookonsite" class="btn btn-inverse btn-mini">Origin site</a>
                  </div>
                  <span class="user-info"><?php echo $book->title  ?> | <?php echo $book->publisherdate  ?> | <?php echo $book->categories  ?></span>
                  <p><a> <?php echo substr($book->description,0,200)."....." ?></a> </p>
                </div>
              </li>
            <?php endforeach; ?>
            </ul>
          </div>
    </div>
<?php endif ?>
<?php if(!empty($data['searchs']['authors'])): ?>
    <div class="widget-box">
          <div class="widget-title">
            <h5>Books Authors</h5>
          </div>
          <div class="widget-content nopadding">
            <ul class="recent-posts">
            <?php foreach ($data['searchs']['authors'] as $key => $author): ?>
              <li>
                <div class="article-post">
                  <div class="fr">
                  	<a id="<?php echo Crypt::Tokenid($author->id);  ?>" data-fromsearch="authorlucultura" class="btn btn-primary btn-mini">View more</a>
                  </div>
                  <span class="user-info"><?php echo $author->fullname  ?> </span>
 
                </div>
              </li>
            <?php endforeach; ?>
            </ul>
          </div>
    </div>
<?php endif ?>
</div>

</div>

<div class="row-fluid">
	<div class="span3">
	<?php if(!empty($data['searchs']['videos'])): ?>
	    <div class="widget-box">
	          <div class="widget-title">
	            <h5>Videos</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <ul class="recent-posts">
	            <?php foreach ($data['searchs']['videos'] as $key => $video): ?>
	              <li>
	                <div class="user-thumb">
	                	<img <?php echo $imgstyle ?> alt="<?php echo $video->tags;?>" src=" https://i.vimeocdn.com/video/<?php echo $video->picture_id;?>_200x150">
	                </div>
	                <div class="article-post">
	                  <div class="fr">
	                  	<a id="<?php echo Crypt::Tokenid($video->id);  ?>" data-fromsearch="videolucultura" class="btn btn-primary btn-mini">View more</a>
	                  	<a  id="<?php echo $video->pageurl  ?>" data-fromsearch="videoonsite" class="btn btn-inverse btn-mini">Origin site</a>
	                  </div>
	                  <span class="user-info"><?php echo $video->tags  ?> | <?php echo $video->duration  ?> | <?php echo $video->size  ?></span>
	                  <p><a><?php echo $video->webwidth?> | <?php echo $video->webheight?></a> </p>
	                </div>
	              </li>
	            <?php endforeach; ?>
	            </ul>
	          </div>
	    </div>
	<?php endif ?>
	</div>
	<div class="span3">	
	<?php if(!empty($data['searchs']['natyres'])): ?>
	    <div class="widget-box">
	          <div class="widget-title">
	            <h5>Images</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <ul class="recent-posts">
	            <?php foreach ($data['searchs']['natyres'] as $key => $natyre): ?>
	              <li>
	                <div class="user-thumb">
	                <img <?php echo $imgstyle ?> alt="<?php echo $natyre->weburl;?>" src="<?php echo $natyre->weburl ?>">
	                </div>
	                <div class="article-post">
	                  <div class="fr">
	                  	<a  id="<?php echo $natyre->pageurl  ?>" data-fromsearch="imgonsite" class="btn btn-inverse btn-mini">
	                  		Origin site
	                  	</a>
	                  </div>
	                  <span class="user-info"><?php echo $video->tags  ?></span>
	                  <p><a><?php echo $natyre->webwidth?> | <?php echo $natyre->webheight?></a> </p>
	                </div>
	              </li>
	            <?php endforeach; ?>
	            </ul>
	          </div>
	    </div>
	<?php endif ?>
	</div>
</div>
<div class="taskDesc">
<?php if(empty( $data['searchs']['movies'] ) 
			&& empty($data['searchs']['books']) 
				&& empty( $data['searchs']['actors']
		  			&& empty($data['searchs']['authors']) ) 
		  				&& !empty($_GET['rf_words'])): ?>
<h3>No results.... </h3>
<?php endif ?>
</div>
<hr>
<div class="pagination alternate"><?php echo $data['pageLinks'] ?></div>


<script type="text/javascript">
(function () {
$('.row-fluid').find('a').on('click',function(event){
        data    = $(this).data('fromsearch');
        id      = $(this).attr('id');
        switch(data){
            case "movieonsite":
            window.location="http://www.imdb.com/title/"+id;
            break;
            
            case "movielucultura":
                window.location="/Movies/View/"+id;     
            break;

            case "actoronsite":
            window.location="http://www.imdb.com/name/"+id;
            break;

            case "actorlucultura":    
            window.location="/Movies/Viewactor/"+id;     
            break;

            case "bookonsite":
            window.location=id;
            break;

            case "booklucultura":
            window.location="/Books/View/"+id;     
            break;

            case "authorlucultura":
            window.location="/Books/Viewauthors/"+id;
            break;

            case "videolucultura":
            window.location="/Natyres/Viewvideo/"+id;
            break;

            case "videoonsite":
            window.location=id;
            break;

            case "imgonsite":
            window.location=id;
            break;
        }
        event.preventDefault();
})
})();

</script>