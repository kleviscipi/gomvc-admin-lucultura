<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;
use Go\Time  as Time;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

?>
<!-- Start of Emojics Code -->
<div id="emojics-root"></div>
<script>
  window.emojicsOpts = {
	widget: 'a10d38c2df40cd0d0f333ff40a0d32'
  };
  (function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	js = d.createElement(s);
	js.id = id;
	js.src = "//emojics-app.local/dist/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
  })(document, "script", "emojics-js");
</script>
<!-- End of Emojics Code -->

<h1>Admin Dashboard</h1>
<hr>
<div class="row-fluid">
	<div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab1">Terminal</a></li>
            </ul>
          </div>
          <div class="widget-content tab-content">
            <div id="tab1" class="tab-pane active">
            <p>Commands: img, videos, start, backupcsv, importcsv,deleteall,dropall,delete-table:table,drop-table:table </p>
              <div style="border: none;background: black;color: green;width:100%;height:100px">admin@lucultura:~ 
              <input id="command" type=''  name="command" style="background:black;color:white;border:none;border">

              </div>
              <div id="result_terminal" style="background:black;color:white;width:100%;height:auto;overflow: scroll"></div>
            </div>
          </div>
	</div>
	<div class="widget-box">
        <div class="widget-title bg_lb"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Statistics</h5>
        </div>
        <div class="widget-content">
          <div class="row-fluid">
            <div class="span4">
              <ul class="site-stats">
                <li class="bg_lr"><i class="icon-film"></i> 
                	<strong id="movies"></strong> <small>Movies</small>
                </li>
                <li class="bg_lb  "><i class="icon-group"></i>
                	<strong id="actors"></strong> <small>Actors</small>
                </li>
                <li class="bg_lg  "><i class="icon-tags"></i>
                	<strong id="companyes"></strong> <small>Movie Company</small>
                </li>
                <li class="bg_lh "><i class="icon-tag"></i>
                	<strong id="noactorid"></strong> <small>Movies with no actor id</small>
                </li>
                <li class="bg_lo  "><i class="icon-book"></i>
                	<strong id="books"></strong> <small>Books</small>
                </li>
                <li class="bg_ls  "><i class="icon-group"></i>
                	<strong id="authors"></strong> <small>Books Authors</small>
                </li>
                <li class="bg_lb  "><i class="icon-picture"></i>
                	<strong id="natyres"></strong> <small>Images</small>
                </li>
                <li class="bg_lr  "><i class="icon-facetime-video"></i>
                	<strong id="videos"></strong> <small>Videos</small>
                </li>
                 <li class="bg_lr  "><i class="icon-user-md"></i>
                	<strong id="users"></strong> <small>Users</small>
                </li>
                <li class="bg_ly  "><i class="icon-wrench"></i>
                	<strong id="roles"></strong> <small>Roles</small>
                </li>
              </ul>
            </div>
            <div class="span8">
			  	<div class="widget-box">
			    <div class="widget-title bg_lb"><span class="icon"><span id="cronjobs" class="badge badge-important"></span></span>
			      <h5> <i class="icon-cogs"></i> Last cron jobs</h5> 
			    </div>
				<div class="widget-content nopadding">
		            <table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Where</th>
		                  <th>By</th>
		                  <th>Duration</th>
		                  <th>Records</th>
		                  <th>Created</th>
		                </tr>
		              </thead>
		              <tbody id="htmlcronjobs">

		              </tbody>
		            </table>
		          </div>

			  </div>
			</div>
			<div class="span4">
			  	<div class="widget-box">
			    <div class="widget-title bg_lb"><span class="icon"><i class="icon-key"></i> </span></span>
			      <h5>Last access on panel</h5> 
			    </div>
				<div class="widget-content nopadding">
		            <table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Action</th>
		                  <th>Ip</th>
		                  <th>Username</th>
		                  <th>email</th>
		                  <th>Created</th>
		                </tr>
		              </thead>
		              <tbody id="htmlaccess">
		              </tbody>
		            </table>
		        </div>
			  </div>
			</div>
			<div class="span4">
			  	<div class="widget-box">
			    <div class="widget-title bg_lb"><span class="icon"><i class="icon-edit"></i> </span></span>
			      <h5>Last Actions</h5> 
			    </div>
				<div class="widget-content nopadding">
		            <table class="table table-striped table-bordered">
		              <thead>
		                <tr>
                          <th>Action</th>
                          <th>Controller</th>
                          <th>Description</th>
		                </tr>
		              </thead>
		              <tbody id="notice">
		              </tbody>
		            </table>
		        </div>
			  </div>
			</div>
          </div>
        </div>
      </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var Admin= {
		init:function(conf){
			this.conf= conf;
			this.events();
			this.statistics();
			this.cronjobs();
			this.access();
			this.actions();
		},
		events:function(){
			this.conf.terminal.keypress(function(event){
	
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13'){
						command = $(this).val();
						if(!command==''){
							Admin.terminal(command);
						}
						
					}
			});
		},
		terminal:function(command){
			var self = Admin,html="";
 
			if(command=="dropall"){
			  html +="Are you sure?<br>";
			  html +="Insert Y:dropall or N:dropall";
			  self.conf.terminal.val("");
			  self.conf.terminal.attr("placeholder","Y or  N");
			}else if(command=="N:dropall"){
				html +="Command abborted.";
				self.conf.terminal.val("");
				self.conf.terminal.attr("placeholder","");
			}else if(command=="deleteall"){
				html +="Are you sure to delete all records to all tables?<br>";
				html +="Insert Y:deleteall or N:deleteall";
				self.conf.terminal.val("");
			  	self.conf.terminal.attr("placeholder","Y or  N");
			}else if(command=="N:deleteall"){
				html +="Command abborted.";
				self.conf.terminal.val("");
				self.conf.terminal.attr("placeholder","");
			}else if(command=="shoutdown"){
				Request.logout();
			}else{
				html +="Start......<br>"; 
				html +="Please wait......<br>";
				command = command;
			}

		    $.get('/Admin/cronjobs/'+command, function(e){
		   		html +=e; 
		   		self.conf.terminalresponse.html(html);
		    });

		    self.conf.terminalresponse.html(html);

	
		},
		statistics:function(){
			var  self = Admin;
			post = '';
			Request.dataPost('/Api/Admin/statistics',post,function(response){
			  if(response.error < 1 ){
				  data = response.data;
		          self.conf.movies.html(data.movies.count);
		          self.conf.actors.html(data.actors.count);
		          self.conf.company.html(data.company.count);
		          noactorid = data.movies.count - data.moviewithactor.count;
		          self.conf.mwithnoactor.html(noactorid);
		          self.conf.books.html(data.books.count);
		          self.conf.authors.html(data.authors.count);
		          self.conf.natyres.html(data.natyres.count);
		          self.conf.videos.html(data.videos.count);
		          self.conf.cronjobs.html(data.cronjobs.count);
		          self.conf.users.html(data.users.count);
		          self.conf.roles.html(data.roles.count);
			  }

	        });
		},
		cronjobs:function(){
			var self = Admin,html = ""; 
			Request.dataPost('/Api/Admin/cronjobs',post,function(response){
				console.log(response.data);
				if(response.error < 1){
					data = response.data;
					length = Object.keys(data).length;
					for (var i = length - 1; i >= 0; i--) {
						html +='<tr>'
		                  	+'<td class="taskDesc"><i class="icon-info-sign"></i>'+data[i].type+'</td>'
		                  	+'<td class="taskDesc">'+data[i].actionby+'</td>'
		                  	+'<td class="taskDesc">'+data[i].duration+'</td>'
		                  	+'<td class="taskDesc">'+data[i].records+'</td>'
		                  	+'<td class="taskDesc">'+data[i].created+'</td>'
		                +'</tr>'
					}
					self.conf.htmlcronjobs.html(html);
				}
			});
		},
		access:function(){
			var self = Admin,html = ""; 
			Request.dataPost('/Api/Admin/access',post,function(response){

				if(response.error < 1){
					data = response.data;
					if(!data==null){
					length = Object.keys(data).length;
					for (var i = length - 1; i >= 0; i--) {
						if(data[i].action){
							txt = "Login";
							cl  ="done";
						}else{
							txt = 'Logout';
							cl  = 'pending';
						}
						html +='<tr>'
		                  	+'<td class="taskStatus"><span class="'+cl+'">'+txt+'</span></td>'
		                  	+'<td class="taskDesc">'+data[i].ip+'</td>'
		                  	+'<td class="taskDesc">'+data[i].username+'</td>'
		                  	+'<td class="taskDesc">'+data[i].email+'</td>'
		                  	+'<td class="taskDesc">'+data[i].created+'</td>'
		                +'</tr>'
					}
					self.conf.htmlaccess.html(html);					}

				}
			});
		},
		actions:function(){
        var html = "",self = Admin;
        Request.dataPost('/Api/Admin/actions',post,function(response){
          if(response.error < 1){
            data = response.data;
            if(!data==null){
	            length = Object.keys(data).length;
	            for (var i = length - 1; i >= 0; i--) {
	              if(data[i].action=="Add"){
	                cl = "done";
	              }
	              if(data[i].action=="Delete"){
	                cl = "pending";
	              }
	              html +='<tr><td class="taskStatus"><span class="'+cl+'">'+data[i].action+'</span></td>'
	                        +'<td class="taskDesc">'+data[i].controller+'</td>'
	                        +'<td><span class="badge badge-important">'+data[i].name +" "+ data[i].subname+'</span> '+ data[i].description+'</td>'
	                        +'</tr>';              
	            }
	            self.conf.lastnotice.append(html);           
            }

          }
        });
      },
	}
	Admin.init({
		movies 		:$('#movies'),
		actors 		:$('#actors'),
		company 	:$('#companyes'),
		mwithnoactor:$('#noactorid'),
		books 		:$('#books'),
		authors 	:$('#authors'),
		natyres: 	$('#natyres'),
		videos 		:$('#videos'),
		cronjobs 	:$('#cronjobs'),
		htmlcronjobs:$('#htmlcronjobs'),
		htmlaccess 	:$('#htmlaccess'),
		users 		:$('#users'),
		roles 		:$('#roles'),
		lastnotice  :$('#notice'),
		terminal	:$('#command'),
		terminalresponse: $('#result_terminal')
	});
});
</script>
