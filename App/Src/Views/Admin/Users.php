<?php 
use Go\Language as Language;
use Go\Media as Media;
use Go\Session as Session;
 ?>

<div class="container-fluid">
<h1>List of users</h1>
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span id='spanuser' class="icon"> <i class="icon-th"></i> </span>
            <h5>Static table</h5>
          </div>
          <div id="usercontent" class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th><?php echo Language::show('user_name','Admin') ?></th>
                  <th><?php echo Language::show('user_lastname','Admin') ?></th>
                  <th><?php echo Language::show('user_email','Admin') ?></th>
                  <th><?php echo Language::show('user_username','Admin') ?></th>
                  <th><?php echo Language::show('user_role','Admin') ?></th>
                  <th>Opts</th>
                </tr>
              </thead>
              <tbody id='listusers'>
              </tbody>
            </table>
          </div>
        </div>
      </div>
     </div>

<script type="text/javascript">

$(document).ready(function(){
	var Users={
		iduser:"",
		init:function(conf){
			this.conf  = conf;
			this.events();

		},
		events:function(){
			this.getusers();
			this.conf.link.live('click',function(e){
				var data = $(this).data('action');
				var id = $(this).attr('id');
				switch(data){
					case "deletealert":
					 Users.deletealert(id);
					break;
					case "deleteuser":
					 Users.deleteuser(id);
					break;
					case "updateuser":
						Users.initupdate(id);
					break;
					case "redirect":
					 window.location.href = $(this).attr('href');
					break;

				}
				e.preventDefault();
			});
		this.conf.pushbutton.live('click',function(e){
			id = $(this).attr('id');
			Users.iduser = id;
			Users.getroles(id);
			if($(this).data('action') == 'userupdates'){
				Users.setupdates(id);
			}else if($(this).data('action') == 'clear'){
				Users.getusers();
			}else if($(this).data('action') == 'profile'){ 
				post ='&word='+id;
				Request.dataPost('/Api/Admin/redirects',post,function(response){
	                window.location= "/Admin/Profile/"+response.data; 
	            });
			}
		});
		this.conf.setthisrole.live('click',function(e){
			if($(this).data('action') == 'setrole'){
				id = Users.iduser;
				val = $(this).data('value');
				Users.setroles(id,val);	
			}

		});

		},
		initupdate:function(id){
			var html = "";
			 $('#td-'+id+' input').css('border','1px solid green' );
			 $('#td-'+id+' input').removeAttr('disabled' );
			 html +='<button id='+id+' data-action="userupdates" class="btn btn-success btn-mini">Save</button>';
			 html +='<button id='+id+' data-action="profile" class="btn btn-info btn-mini">Profile</button>';  
			 html +='<button  data-action="clear" class="btn btn-inverse btn-mini">Clear</button>'; 
			 Users.conf.spanuser.html(html);
		},
		setupdates:function(id=''){
			var self = Users;
			if(!id==''){
			 name 	 = $('#td-'+id+' input[name=name]').attr('value');
			 subname = $('#td-'+id+' input[name=subname]').attr('value');
			 email 	 = $('#td-'+id+' input[name=email]').attr('value');
			 username= $('#td-'+id+' input[name=username]').attr('value');
			 post  ="&id="+id;
			 post +="&name="+name;
			 post +="&subname="+subname;
			 post +="&email="+email;
			 post +="&username="+username;

			}
	        if(Request.check(name)){
	          Request.input('name-'+id,false);
	          if(Request.check(subname)){
	            Request.input('subname-'+id,false);
                    if(Request.checkemail(email)){
                        Request.input('email-'+id,false);
                            if(Request.check(username)){
                           	 Request.input('username-'+id,false);
                           	 	self.conf.spanuser.html(self.conf.img);
								Request.callPost('/Api/Admin/updateuser',post,function(response){
									self.getusers();
									self.conf.spanuser.html(self.conf.icontable);
							    });
							}else{
			                    Request.gritererror('Empty','<?php echo Language::show('empty_username','Admin') ?>');
			                    Request.input('username-'+id);
			                    return false;
			                } 

	                  }else{
	                    Request.gritererror('Empty','<?php echo Language::show('empty_email','Admin') ?>');
	                    Request.input('email-'+id);
	                    return false;
	                  }

	          }else{
	            Request.gritererror('Empty','<?php echo Language::show('empty_lastname','Admin') ?>');
	            Request.input('subname-'+id);
	            return false;
	          }
	        }else{
	          Request.gritererror('Empty','<?php echo Language::show('empty_name','Admin') ?>');
	          Request.input('name-'+id);
	          return false;
	        }

		},
		getusers:function(id=''){
		var self  = Users,html="",style = "style='border:none;background: white;width: 82%;padding:2px 3px' ;";
			if(!id==''){
				post ="&id="+id;
			}else{
				post='';
			}
			self.conf.spanuser.html(self.conf.img);
   
			Request.dataPost('/Api/Admin/getusers',post,function(response){
			data = response.data;
			if(typeof data =="undefined" || data == null || data ==''){
				html +='<tr class="odd gradeX">'
	              +'<td>-</td>'
	              +'<td>-</td>'
	              +'<td>-</td>'
	              +'<td class="center">-</td>'
	              +'<td class="center">-</td>'
	              +'<td  class="taskOptions">'
	              +'</td></tr>';
	              self.conf.listusers.html(html);
			}else{

				length = Object.keys(response.data).length;
				for (var i = length - 1; i >= 0; i--) {
						
					html +='<tr id="td-'+data[i].id+'" class="odd gradeX">'
		                  +'<td><input id="name-'+data[i].id+'" '+style+' disabled name="name" value="'+data[i].name+'" ></td>'
		                  +'<td><input id="subname-'+data[i].id+'" '+style+' disabled name="subname" value="'+data[i].subname+'" ></td>'
		                  +'<td><input id="email-'+data[i].id+'" '+style+' disabled name="email" value="'+data[i].email+'" ></td>'
		                  +'<td class="center"><input id="username-'+data[i].id+'" '+style+' disabled name="username" value="'+data[i].username+'"></td>'
		                  +'<td class="center"><div  class="btn-group">'
		                  +'<button id="'+data[i].id+'"" data-drop="thisrole" data-toggle="dropdown" class="btn btn-mini btn-inverse dropdown-toggle">'+data[i].rolename+  '<span class="caret"></span></button>'
			              +'<ul id="droproles-'+data[i].id+'" class="dropdown-menu">'
			              +'</ul>'
			              +'</div></td>'
		                  +'<td id="linksoptions"  class="taskOptions">'
		                  +'<a href="/Permissions/Userpermissions/'+data[i].id+'" data-action="redirect" class="tip-top"  data-original-title="Settings">'
			         			+'<i class="icon-key"></i></a>   <a href="#" class="tip-top" id='+data[i].id+' data-action="updateuser" data-original-title="Update">'
			         			+'<i class="icon-edit"></i></a>   <a href="#" data-action="deletealert" id='+data[i].id+' class="tip-top" data-original-title="Delete">'
			         			+'<i class="icon-remove"></i></a><div id="contentalert'+data[i].id+'"></div></td></tr>';

				}

			}

			self.conf.listusers.html(html);
			self.conf.spanuser.html(self.conf.icontable);

			});
		},
		getroles:function(id =""){
		  var html = "";
		  console.log(id);
	      Request.dataPost('/Api/Permissions/getroles','',function(response){
	        data = response.data;
	        length = Object.keys(response.data).length;

	        for (var i = length - 1; i >= 0; i--) {
	           html +="<li><a href='#' data-value="+data[i].id+" data-action='setrole'>"+data[i].name+"</a></li>"
	        }
	        $('#droproles-'+id).html(html);

	      });
		},

		setroles:function(id,val){
		  var self = Users;
		  console.log(id);
		  	if(!id=='' && !val==""){
				post ="&id="+id;
				post +="&val="+val;
			}else{
				post='';
			}
	      Request.callPost('/Api/Admin/setrole',post,function(response){
				self.getusers();
	      });
		},

		deletealert:function(id){
			var html = "";
			html +='<div style="position:absolute;right:100px;margin-top:-31px;" class="alert alert-error">'
				+'<strong>Notice!</strong>Sei sicuro di dover cancellare questo utente?  <a href="#" id="'+id+'" data-action="deleteuser" class="btn btn-danger btn-mini">Delete</a> <button class="btn btn-inverse btn-mini" data-dismiss="alert">Close</button></div>';

			$('#contentalert'+id).append(html);
		},
		deleteuser:function(id){
			var self = Users;
			post ='id='+id;
			self.conf.spanuser.html(self.conf.img);
			Request.callPost('/Api/Admin/deleteuser',post,function(response){
				
				self.getusers();
				$('#contentalert'+id).append('');
				self.conf.spanuser.html(self.conf.icontable);

			});
		}
	}

	Users.init({
		listusers:$('#listusers'),
		img:'<?php echo Media::img('spinner.gif')?>',
		spanuser:$('#spanuser'),
		icontable:'<i class="icon-th"></i>',
		link:$('#linksoptions a'),
		name:$('input[name=name]'),
		subname:$('input[name=subname]'),
		email:$('input[name=email]'),
		input:$('input'),
		pushbutton:$('button'),
		setthisrole:$('li a')
	});

});
</script>
