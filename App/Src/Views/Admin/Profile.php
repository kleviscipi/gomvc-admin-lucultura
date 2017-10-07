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
<h1>Profile Page</h1>
<hr>
<div class="row-fluid">
<div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-user"></i> </span>
            <h5>Profile details</h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span3">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>Full Name</td>
                      <td><h4 id="namecontent"><?php echo ucfirst($data['user']->name); ?> <?php echo ucfirst($data['user']->subname); ?> </h4></td>
                    </tr>
                    <tr>
                      <td>Username</td>                    
                      <td id="usernamecontent"><strong><?php echo ucfirst($data['user']->username); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td id="emailcontent"><strong><?php echo $data['user']->email; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Role</td>
                      <td><span class="badge badge-inverse"><?php echo $data['user']->rolename; ?></span></td>
                    </tr>
                  </tbody>
                </table>
              
              <?php if(Session::get('iduser') == $data['user']->id): ?>
              
                <table class="table  table-invoice">
                  <tbody>
                    <tr>
                    </tr><tr>
                      <td class="">
                      		<button id="editpassword" class="btn btn-mini btn-danger">Password</button>
                      </td>
                      <td id="contenutopassword"></td>
                    </tr>
                  <tr>
                    <td><button id="editdetails" class="btn btn-mini btn-inverse">Details</button></td>
                    <td id="contenutodetails"></td>

                  </tr>
                    </tbody>
                  
                </table>
              </div>
          		<?php endif ?>
            </div>

          </div>
        </div>
      </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  var Profile={
  		check :false,
      init:function(conf){
        this.conf = conf;
        this.events();
      },
      events:function(){
      	this.conf.editpassword.on('click',this.editpassword);
      	this.conf.editdetails.on('click',this.editdetails);
      	this.conf.clear.live('click',this.clear);
      	this.conf.cleardetails.live('click',this.cleardetails);
      	this.conf.closedetails.live('click',this.closedetails);
      	this.conf.close.live('click',this.close);
      	this.conf.oldpass.live('keyup',function(){
      		val =$(this).val();
	      	post = '&oldpass='+val;
	      	Request.dataPost('/Api/Admin/profiles',post,function(response){
	      	
 		       if(response.data){
	      			$('#oldpass').css('border','1px solid green');
	      		}else{
	      			$('#oldpass').css('border','1px solid red');	      			
	      		}
	      	});

      	})
        this.conf.savepassword.live('click',function(){
        	newpass =$('#newpass').val();
        	oldpass =$('#oldpass').val();
        	Profile.savepassword(oldpass,newpass);
        });
        this.conf.savedetails.live('click',function(){
        	name 		=$('#name').val();
        	email 		=$('#email').val();
        	subname 	=$('#subname').val();
        	username 	=$('#username').val();
        	Profile.savedetails(name,subname,username,email);
        });
      },
      editpassword:function(){
      	var self = Profile,html ="";
	      	html +="<div  class='controls'>"
	      	html +="<input id='oldpass' type='password' name='oldpassword' placeholder='Old Password'></div>";
	      	html +="<div  class='controls'><input id='newpass' type='password' name='newpassword' placeholder='New Password'></div>";
	      	html +="<div  class='controls'><button id='savepassword' style='margin-top: -10px;margin-left: 2px;' class='btn btn-mini btn-inverse'>Update</button>";
	      	html +="<button id='clear' style='margin-top: -10px;margin-left: 2px;' class='btn btn-mini  btn-warning'>Clear</button>";
	      	html +="<button id='close' style='margin-top: -10px;margin-left: 2px;' class='btn btn-mini btn-danger'>Close</button>";
	      	html +="<div>"
      	self.conf.contenutopassword.html(html);

      },
      editdetails:function(){
      	var self = Profile,html ="";
	      	html +="<div  class='controls'>"
	      	html +="<input id='name' type='text' name='name' value='<?php echo  $data['user']->name ?>' placeholder='Name'><div>";
	      	html +="<div  class='controls'><input id='subname' type='text' value='<?php echo $data['user']->subname ?>' name='subname' placeholder='Subname'></div>";
	      	html +="<div  class='controls'><input id='email' type='text' name='email' value='<?php echo  $data['user']->email ?>' placeholder='Email'></div>";
	      	html +="<div  class='controls'><input id='username' type='text' name='username' value='<?php echo  $data['user']->username ?>' placeholder='Username'></div>";
	      	html +="<div  class='controls'><button id='savedetails' style='margin-top: -10px;margin-left: 2px;' class='btn btn-mini  btn-success'>Update Details</button";
	     	html +="<div>"
	     	html +="<div  class='controls'><button id='cleardetails' style='margin-top: -10px;margin-left: 2px;' class='btn  btn-mini btn-warning'>Clear</button";
	     	html +="<div>"
	     	html +="<div  class='controls'><button id='closedetails' style='margin-top: -10px;margin-left: 2px;' class='btn  btn-mini btn-danger'>Close</button";
	     	html +="<div>"
      	self.conf.contenutodetails.html(html);

      },
      savepassword: function(old,newpass){
      	    var self = Profile;
      	    post = '&newpass='+newpass;
      	    post += '&oldpass='+old;
	      	Request.callPost('/Api/Admin/savepassword',post,function(response){
	      		$('#newpass').val("");
        		$('#oldpass').val("");
        		if(response.error == 1	){
					$('#oldpass').css('border','1px solid red');
					$('#newpass').css('border','1px solid red');
        		}else if(response.error == 0){
        			$('#oldpass').css('border','');
					$('#newpass').css('border','');
        		}
        		
	  		});     	
      },
      savedetails: function(name,subname,username,email){
      	    var self = Profile,html = "";
      	    post +='&name='+name;
      	    post +='&subname='+subname;
      	    post += '&email='+email;
      	    post += '&username='+username;
	        if(Request.check(name)){
	          Request.input('name',false);
	          if(Request.check(subname)){
	            Request.input('subname',false);
	                if(Request.checkemail(email)){
	                    Request.input('email',false);
 						if(Request.check(username)){
 							Request.input('username',false);
	 						Request.callPost('/Api/Admin/saveprofile',post,function(response){
	 							$('#namecontent').html(response.data.name.substr(0, 1).toUpperCase() + response.data.name.substr(1) + " " + response.data.subname.substr(0, 1).toUpperCase() + response.data.subname.substr(1));
	 							$('#emailcontent').html(response.data.email);
	 							$('#usernamecontent').html(response.data.username.substr(0, 1).toUpperCase() + response.data.username.substr(1));
	 						});
 						}else{
	                 		Request.gritererror('Notice','Username is empty,Please insert one');
	                 	 	Request.input('username');
	                  		return false;
	               		 }

	                }else{
	                  Request.gritererror('Notice','<?php echo Language::show('check_email','Admin') ?>');
	                  Request.input('email');
	                  return false;
	                }

	          }else{
	            Request.gritererror('Empty','<?php echo Language::show('empty_lastname','Admin') ?>');
	            Request.input('subname');
	            return false;
	          }
	        }else{
	          Request.gritererror('Empty','<?php echo Language::show('empty_name','Admin') ?>');
	          Request.input('name');
	          return false;
	        }
   	
      },
      clear:function(){
      	 $('#oldpass').val("");
      	 $('#newpass').val("");
      	 $('#oldpass').css('border','');
      	 $('#newpass').css('border','');
      },
      cleardetails:function(){
      	 $('#name').val("");
      	 $('#subname').val("");
      	 $('#username').val("");
      	 $('#email').val("");
      	 $('#name').css('border','');
      	 $('#subname').css('border','');
      	 $('#email').css('border','');
      	 $('#username').css('border','');
      },
      closedetails:function(){
      	$('#contenutodetails').html("");
      },
      close:function(){
      	$('#contenutopassword').html("");
      }

}
  Profile.init({
  	editpassword 	:$('#editpassword'),
  	editdetails 	:$('#editdetails'),
  	contenutopassword:$('#contenutopassword'),
  	contenutodetails :$('#contenutodetails'),
  	oldpass 		:$('#oldpass'),
  	newpass 		:$('#newpass'),
  	name 			:$('#name'),
  	subname 		:$('#subname'),
  	username 		:$('#username'),
  	email 			:$('#email'),
  	savepassword    :$('#savepassword'),
   	savedetails     :$('#savedetails'),
  	clear 			:$("#clear"),
  	cleardetails 	:$('#cleardetails'),
  	closedetails 	:$('#closedetails'),
  	close 			:$('#close')

  });
});


</script>