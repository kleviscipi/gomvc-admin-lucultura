<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;

/***********************************
* 2016-11-18                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

?>
<h1>Images And Videos from nature, world.</h1>
<hr>
<div class="row-fluid">
	<div class="span6">
		<div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active">
              	<a data-toggle="tab" href="#img">Add Book</a>
              </li>
              <li class="">
              	<a data-toggle="tab" href="#video">Add Video</a>
              </li>
            </ul>
          </div>
          <div class="widget-content tab-content">
            <div id="img" class="tab-pane active">
	            <p>Insert a keyword for inserting images like(natyre,people)!</p>
				<form id='imgform' class="form-horizontal">
		            <div class="control-group">
		              <label class="control-label">Images Keord</label>
		              <div class="controls">
		                <input type="text" id='img_id' name='img_id' class="span11" placeholder="Image Keyword">
		              </div>
		            </div>
		            <div class="form-actions" id='contentimg'>
		              <button type="button" id='addimg'  class="btn btn-success">Insert</button>
		            </div>
		            <div class="clock" style="margin:1em;"></div>
				</form>
            </div>
            <div id="video" class="tab-pane">
              <p>Insert a keyword for inserting video like(natyre,people)!</p>
              <p>Video are graped from https://pixabay.com !</p>         
				<form id='videoform' class="form-horizontal">
		            <div class="control-group">
		              <label class="control-label">Video Keword</label>
		              <div class="controls">
		                <input type="text" id='video_id' name='video_id' class="span11" placeholder="Video Keyword">
		              </div>
		            </div>
		            <div class="form-actions" id='contentvideo'>
		              <button type="button" id='addvideo'  class="btn btn-success">Insert</button>
		            </div>
		            <div class="clockvideo" style="margin:1em;"></div>
				</form>
            </div>
          </div>
        </div>
	</div>
</div>
<div id='error_ajax'></div>
<script type="text/javascript">
var clock;
$( document ).ready(function($) {

	var Natyre = {
		init:function(conf){
			this.conf = conf;
			this.events();
		},
		events:function(){
			this.conf.buttonimg.live('click',this.addimg);
			this.conf.buttonvideo.live('click',this.addvideo);
		},
		addimg:function(){
			var self = Natyre,post;
			if(Request.check(self.conf.img_id.val())){
			Request.input('img_id',false);
			clock = new FlipClock($('.clock'), {
				clockFace: 'Counter',
				autoStart: true
			});
			self.conf.spancontent.html(self.conf.img);
			$('.clock').css('display','block');

			post ='&img_id='+self.conf.img_id.val();
			post +='&keyapi='+self.conf.pixapikey;	
				Request.callPost('/Api/Natyres/add',post,function(response){
					console.log(response);
					$('.clock').css('display','none');
					self.conf.spancontent.html(self.conf.i_content);
				});
			}else{
				Request.gritererror('Empty','Image name is empty, please inserte one!');
				Request.input('img_id');
				return false;
			}
		},
		addvideo:function(){
			var self = Natyre,post;
			if(Request.check(self.conf.video_id.val())){
			Request.input('video_id',false);
			clock = new FlipClock($('.clockvideo'), {
				clockFace: 'Counter',
				autoStart: true
			});
			self.conf.spancontentvideo.html(self.conf.img);
			$('.clockvideo').css('display','block');

			post ='&video_id='+self.conf.video_id.val();
			post +='&keyapi='+self.conf.pixapikey;
			
			Request.callPost('/Api/Natyres/addvideo',post,function(response){
				console.log(response);
				$('.clockvideo').css('display','none');
				self.conf.spancontentvideo.html(self.conf.v_content);
			});

			}else{
				Request.gritererror('Empty','Video keyword is empty, please inserte one!');
				Request.input('video_id');
				return false;
			}
		}
	}
	Natyre.init({
		buttonimg: 		$('#addimg'),
		buttonvideo:  	$('#addvideo'),
		formimg: 		$('#bookform'),
		formvideo: 		$('#bookform'),
		pixapikey:'3788418-e2d1fda475bb9e8eb53575098',
		spancontent:  	$('#contentimg'),
		spancontentvideo:  	$('#contentvideo'),
		img:'<?php echo Media::img('spinner.gif')?>  Loading.......',
		i_content:"<button type='button' id='addimg'  class='btn btn-success'>Insert</button>",
		v_content:"<button type='button' id='addvideo'  class='btn btn-success'>Insert</button>",
		img_id:$('#img_id'),
		video_id:$('#video_id')
	});
});
</script>

