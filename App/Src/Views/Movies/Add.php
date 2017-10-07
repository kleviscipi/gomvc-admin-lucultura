<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;

/***********************************
* 2016-11-16                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

?>

<h1>Adds from IMDB</h1>
<hr>
<div class="row-fluid">
	<div class="span8">
		<div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#actor">Add Actor</a></li>
              <li class=""><a data-toggle="tab" href="#companie">Add Company</a></li>
              <li class=""><a data-toggle="tab" href="#movie">Add Movie</a></li>
              <li class=""><a data-toggle="tab" href="#cast">Insert from cast</a></li>
              <li class=""><a data-toggle="tab" href="#optimize">Optimize</a></li>
            </ul>
          </div>
          <div class="widget-content tab-content">
            <div id="actor" class="tab-pane active">
              <p>Insert imbd id example(nm0000314)</p>
				<form id='actorform' class="form-horizontal">
				            <div class="control-group">
				              <label class="control-label">Actor id</label>
				              <div class="controls">
				                <input type="text" id='idm_actor' name='idm_actor' class="span11" placeholder="Actor id">
				              </div>
				            </div>
				            <div class="form-actions" id='contentbuttonactor'>
				              <button type="button" id='addactor'  class="btn btn-success">Insert</button>
				            </div>
				             <div class="clock" style="margin:1em;"></div>
				</form>
            </div>
            <div id="companie" class="tab-pane">
               <p>Insert imbd id companie(co0000314)</p>
				<form id='comform' class="form-horizontal">
				            <div class="control-group">
				              <label class="control-label">Company id</label>
				              <div class="controls">
				                <input type="text" id='idm_comp' name='idm_comp' class="span11" placeholder="Actor id">
				              </div>
				            </div>
				            <div class="form-actions" id='contentbuttoncom'>
				              <button type="button" id='addcom'  class="btn btn-success">Insert</button>
				             
				            </div>
				            <div class="clockcom" style="margin:1em;"></div>
				             

				</form>
            </div>
            <div id="movie" class="tab-pane">
              <p>Insert imbd id example(tt0085204)</p>
				<form id='movieform' class="form-horizontal">
				            <div class="control-group">
				              <label class="control-label">Movie id</label>
				              <div class="controls">
				                <input type="text" id='idm_movie' name='idm_movie' class="span11" placeholder="Actor id">
				              </div>
				            </div>
				            <div class="form-actions" id='contentbuttonmovie'>
				              <button type="button" id='addmovie'  class="btn btn-success">Insert</button>
				            </div>
				             <div class="clockmovie" style="margin:1em;"></div>
				</form>
            </div>

            <div id="cast" class="tab-pane">
              	<p>Insert imbd id movie example(tt0085204)</p>
				<form id='moviecastform' class="form-horizontal">
				            <div class="control-group">
				              <label class="control-label">Movie id</label>
				              <div class="controls">
				                <input type="text" id='idm_castmovie' name='idm_castmovie' class="span11" placeholder="Actor id">
				              </div>
				            </div>
				            <div class="form-actions" id='contentbuttonmoviecast'>
				              <button type="button" id='addmoviecast'  class="btn btn-success">Insert</button>
				            </div>
				             <div class="clockmoviecast" style="margin:1em;"></div>
				</form>
            </div>
            <div id="optimize" class="tab-pane">
              	<p>Optimize</p>
				<form id='moviecastform' class="form-horizontal">
		            <div class="control-group">
		              <label class="control-label">Movie id</label>
		              <div class="controls">
		                <select>
		                		<option>Select</option>
		                		<option>All movies</option>
		                </select>
		              </div>
		            </div>
		            <div class="form-actions" id='contentbuttonmoviecast'>
		              <button type="button" id='addmoviecast'  class="btn btn-success">Insert</button>
		            </div>
		             <div class="clockmoviecast" style="margin:1em;"></div>
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

	var Movie = {
		init:function(conf){
			this.conf = conf;
			this.events();
		},
		events:function(){
			this.conf.buttonactor.live('click',this.addactor);
			this.conf.buttoncom.on('click',this.addcompany);
			this.conf.buttonmovie.live('click',this.addmovie);
			this.conf.buttonmoviecast.live('click',this.addmoviecast);
		},
		addactor:function(){
			var self = Movie;
			if(Request.check(self.conf.idm_actor.val())){
			Request.input('idm_actor',false);
			clock = new FlipClock($('.clock'), {
				clockFace: 'Counter',
				autoStart: true
			});
			$('.clock').css('display','block');
			post = self.conf.formactor.serialize();
			post +="&urlget="+self.conf.url;
			self.conf.spancontent.html(self.conf.img);
			Request.callPost('/Api/Movies/addactor',post,function(response){
				console.log(response);
				$('.clock').css('display','none');
				self.conf.spancontent.html(self.conf.b_content);
			});

			}else{
				Request.gritererror('Empty','Id actor is empty plese inserte one!');
				Request.input('idm_actor');
				return false;
			}


		},
		addcompany:function(){
			var self = Movie;
			if(Request.check(self.conf.idm_com.val())){
			Request.input('idm_comp',false);
			clock = new FlipClock($('.clockcom'), {
				clockFace: 'Counter',
				autoStart: true
			});
			$('.clockcom').css('display','block');
			post = self.conf.formcom.serialize();
			post +="&urlget="+self.conf.url;
			self.conf.spancontentcom.html(self.conf.img);
			Request.callPost('/Api/Movies/addcompany',post,function(response){
				console.log(response);
				$('.clockcom').css('display','none');
				self.conf.spancontentcom.html(self.conf.b_contentcompany);
			});

			}else{
				Request.gritererror('Empty','Id Company is empty plese inserte one!');
				Request.input('idm_comp');
				return false;
			}

		},
		addmovie:function(){
			var self = Movie;
			if(Request.check(self.conf.idm_movie.val())){
			Request.input('idm_movie',false);
			clock = new FlipClock($('.clockmovie'), {
				clockFace: 'Counter',
				autoStart: true
			});
			$('.clockmovie').css('display','block');
			post = self.conf.formmovie.serialize();
			post +="&urlget="+self.conf.url;
			self.conf.spancontentmovie.html(self.conf.img);
			Request.callPost('/Api/Movies/addmovie',post,function(response){
				console.log(response);
				$('.clockmovie').css('display','none');
				self.conf.spancontentmovie.html(self.conf.b_contentmovie);
			});

			}else{
				Request.gritererror('Empty','Id Movie is empty, please inserte one!');
				Request.input('idm_movie');
				return false;
			}

		},
		addmoviecast:function(){
			var self = Movie;
			if(Request.check(self.conf.idm_moviecast.val())){
			Request.input('idm_castmovie',false);
			clock = new FlipClock($('.clockmoviecast'), {
				clockFace: 'Counter',
				autoStart: true
			});
			$('.clockmoviecast').css('display','block');
			post = self.conf.formmoviecast.serialize();
			post +="&urlget="+self.conf.url;
			self.conf.spancontentmoviecast.html(self.conf.img);
			Request.callPost('/Api/Movies/addmoviecast',post,function(response){
				console.log(response);
				$('.clockmoviecast').css('display','none');
				self.conf.spancontentmoviecast.html(self.conf.b_contentmoviecast);
			});

			}else{
				Request.gritererror('Empty','Id Movie is empty, please inserte one!');
				Request.input('idm_castmovie');
				return false;
			}

		}
	}

	Movie.init({
		buttonactor:$('#addactor'),
		buttoncom:$('#addcom'),
		buttonmovie:$('#addmovie'),
		buttonmoviecast:$('#addmoviecast'),
		url:'http://imdb.wemakesites.net/api/',
		formactor:$('#actorform'),
		formcom:$('#comform'),
		formmovie:$('#movieform'),
		formmoviecast:$('#moviecastform'),
		spancontent: $('#contentbuttonactor'),
		spancontentcom:$('#contentbuttoncom'),
		spancontentmovie:$('#contentbuttonmovie'),
		spancontentmoviecast:$('#contentbuttonmoviecast'),
		img:'<?php echo Media::img('spinner.gif')?>  Loading.......',
		b_content:"<button type='button' id='addactor'  class='btn btn-success'>Insert</button>",
		b_contentcompany:"<button type='button' id='addcom'  class='btn btn-success'>Insert</button>",
		b_contentmovie:"<button type='button' id='addmovie'  class='btn btn-success'>Insert</button>",
		b_contentmoviecast:"<button type='button' id='addmoviecast'  class='btn btn-success'>Insert</button>",
		idm_actor:$('#idm_actor'),
		idm_com:$('#idm_comp'),
		idm_movie:$('#idm_movie'),
		idm_moviecast:$('#idm_castmovie')


	});
});

</script>

