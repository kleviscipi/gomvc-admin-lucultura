<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

?>

<h1>Adds from GOOGLE API</h1>
<hr>
<div class="row-fluid">
	<div class="span6">
		<div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#actor">Add Book</a></li>
            </ul>
          </div>
          <div class="widget-content tab-content">
            <div id="actor" class="tab-pane active">
              <p>Insert a name of Author example "Don Brawn", or tilte of the book like "Angels and Demons"</p>
              <p>Max records from google api (request) is 40."</p>
				<form id='bookform' class="form-horizontal">
				            <div class="control-group">
				              <label class="control-label">Book or Author</label>
				              <div class="controls">
				                <input type="text" id='google_id' name='google_id' class="span11" placeholder="Book or Author">
				              </div>
				            </div>
				            <div class="form-actions" id='contentbook'>
				              <button type="button" id='addbook'  class="btn btn-success">Insert</button>
				            </div>
				             <div class="clock" style="margin:1em;"></div>
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

	var Book = {
		init:function(conf){
			this.conf = conf;
			this.events();
		},
		events:function(){
			this.conf.buttonbook.live('click',this.addbook);
		},
		addbook:function(){
			var self = Book,post;
			if(Request.check(self.conf.google_id.val())){
			Request.input('google_id',false);
			clock = new FlipClock($('.clock'), {
				clockFace: 'Counter',
				autoStart: true
			});
			self.conf.spancontent.html(self.conf.img);
			$('.clock').css('display','block');

			post ='&google_id='+self.conf.google_id.val();
			post +='&keygoogleapi='+self.conf.googleapikey;
			
			Request.callPost('/Api/Books/add',post,function(response){
				console.log(response);
				$('.clock').css('display','none');
				self.conf.spancontent.html(self.conf.b_content);
			});

			}else{
				Request.gritererror('Empty','Book & Author name is empty, please inserte one!');
				Request.input('google_id');
				return false;
			}


		}
	}

	Book.init({
		buttonbook:$('#addbook'),
		formbook:$('#bookform'),
		googleapikey:'AIzaSyDeBy8qO1yRB1CK64zZS-z3CIvG8Qw2rf8',
		spancontent: $('#contentbuttonactor'),
		img:'<?php echo Media::img('spinner.gif')?>  Loading.......',
		b_content:"<button type='button' id='addbook'  class='btn btn-success'>Insert</button>",
		google_id:$('#google_id'),

	});
});

</script>

