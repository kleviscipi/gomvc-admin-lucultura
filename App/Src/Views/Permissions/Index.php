    <?php
    
    use Go\Language as Language;
    use Go\Media as Media;
    use Go\Link as Link;
    USE Go\Session as Session;

   ?>
   <h2><?php echo $data['headertitle'] ?></h2>
  <hr>
  <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title"> <span id='spanrole' class="icon"> <i class="icon-asterisk"></i></span>
          <h5><?php echo Language::show('perm_addrole_title','Permissions') ?></h5>
        </div>
        <div class="widget-content nopadding">
          <form  id='formrole' class="form-horizontal">
            <div class="control-group">
              <label class="control-label"><?php echo Language::show('add_role','Permissions') ?></label>
              <div class="controls">
              	<input type="hidden" id='idrole' name="id" value="" >
                <input type="text" id='name' name='name' class="span4" placeholder="<?php echo Language::show('add_name','Permissions') ?>" />
                  <button type="button"  id='saverole' class="btn btn-success"><?php echo Language::show('add_save','Permissions') ?></button>
                  <button type="button"  id='clear_role' class="btn btn-inverse"><?php echo Language::show('add_clear','Permissions') ?></button>

              </div>
            </div>

          </form>
        </div>
      </div>
      <div class="widget-box">
        <div class="widget-title"> <span id='spanperm' class="icon"> <i class="icon-asterisk"></i> </span>
          <h5><?php echo Language::show('perm_addpermisions_title','Permissions') ?> <?php echo Link::thisLink('/Permissions'); ?></h5>
        </div>
        <div class="widget-content nopadding">
          <form  id='formpermisions' class="form-horizontal">
            <div class="control-group">
              <label class="control-label"><?php echo Language::show('add_permissions','Permissions') ?></label>
              <div class="controls">
                <input type="hidden" id='id_permissions' name="id" value="" >
                <input type="text" id='controller' name='controller' class="span4" placeholder="<?php echo Language::show('add_controller','Permissions') ?>" />
          
                <input type="text" name='method' id='method' class="span4" placeholder="<?php echo Language::show('add_method','Permissions') ?>" />
                <input type="text" name='param1' class="span2" placeholder="<?php echo Language::show('add_param1','Permissions') ?>" />
                <button type="button"  id='savepermissions' class="btn btn-success"><?php echo Language::show('add_save','Permissions') ?></button>
                <button type="button"  id='clear_permissions' class="btn btn-inverse"><?php echo Language::show('add_clear','Permissions') ?></button>
              </div>
            </div>

          </form>
        </div>
      </div>
 
<div class="span4">
<div class="widget-box">
  <div class="widget-title"> <span id='spandeleterole' class="icon"><i class="icon-time"></i></span>
    <h5><?php echo Language::show('title_roles','Permissions'); ?></h5>
  </div>
  <div class="widget-content nopadding">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th><?php echo Language::show('title_description','Permissions') ?></th>
          <th><?php echo Language::show('title_superuser','Permissions') ?></th>
          <th><?php echo Language::show('title_status','Permissions') ?></th>
          <th><?php echo Language::show('title_opt','Permissions') ?></th>
        </tr>
      </thead>
      <tbody id='listroles'>
      </tbody>
    </table>
  </div>
</div>
</div>
<div class="span6">
<div class="widget-box">
  <div class="widget-title"> <span id='spandeleteperm' class="icon"><i  class="icon-time"></i></span>
    <h5><?php echo Language::show('title_permissions','Permissions'); ?></h5>
  </div>
  <div class="widget-content nopadding">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th><?php echo Language::show('title_controller','Permissions') ?></th>
          <th><?php echo Language::show('title_controller','Permissions') ?></th>
          <th><?php echo Language::show('title_param1','Permissions') ?></th>
          <th>Sublink</th>
          <th><?php echo Language::show('title_opt','Permissions') ?></th>
        </tr>
      </thead>
      <tbody id='listpermissions'>

      </tbody>
    </table>
  </div>
</div>
</div>
</div>

<div id='error_ajax'></div>
<script type="text/javascript">
$(document).ready(function(){

	var Permissions={
		init:function(conf){
			this.conf = conf;
			this.events();

		},
		events:function(){
			this.conf.saverole.on('click',this.addroles);
			this.conf.saverperm.on('click',this.addpermissions);
			this.getroles();
			this.getpermissions();
			this.conf.delete_role.live('click',function(e){
				data = $(this).data('action');
				switch(data){
					case "deleterole":
						Permissions.deleterole($(this).attr('id'));
					break;
					case "updaterole":
						Permissions.getroles($(this).attr('id'));
					break;
					case "deletethisrole":
						Permissions.deletealert($(this).attr('id'),data);
					break;
					case "updatestatusrole":
						datastatus = $(this).data('status');
						Permissions.rolestatus($(this).attr('id'),datastatus);
					break;
					case "setpermissions":
					 window.location.href = $(this).attr('href');
					break;
				}

				e.preventDefault();
			});
			this.conf.delete_permissions.live('click',function(e){
				data = $(this).data('action');
				switch(data){
					case "deletepermissions":
						Permissions.deletepermissions($(this).attr('id'));
					break;
					case "updatepermissions":
						Permissions.getpermissions($(this).attr('id'));
					break;
					case "deletethisperm":
						Permissions.deletealert($(this).attr('id'),data);
					break;
				}

				e.preventDefault();
			});
			this.conf.tdstatus.live('click',function(e){
				data = $(this).data('action');
				switch(data){
					case "updatestatusrole":
						datastatus = $(this).data('status');
						Permissions.rolestatus($(this).attr('id'),datastatus);
					break;
					case "updatethisusper":
						datastatus = $(this).data('status');
						Permissions.superstatus($(this).attr('id'),datastatus);
					break;

				}

				e.preventDefault();
			});
			this.conf.roleclear.on('click',this.clearrole);
			this.conf.permisionsclear.on('click',this.clearpermissions);
			this.conf.droplinks.live('click',function(){
			 action = $(this).data('action');
			 value  = $(this).data('value');
			 id 	= $(this).attr('id'); 
			 if(action == "sublink"){
			 	Permissions.updatesublink(id,value);
			 }
			});

		},
		updatesublink:function(id,val){
			var self = Permissions;
			if(!id == "" && !val ==""){
				post 	="&id="+id;
				post   +="&val="+val;
				self.conf.spanperm.html(self.conf.img);
			}else{
				return false;
			}
			Request.callPost('/Api/Permissions/updatesublink',post,function(response){
				Permissions.getpermissions();
				self.conf.spanperm.html(self.conf.iconasterix);
			});
		},
		addroles:function(){
			self = Permissions;
			post = self.conf.formrole.serialize();
			if(Request.check(self.conf.name.val())){
				Request.input('name',false);
				self.conf.spanrole.html(self.conf.img);
				Request.callPost('/Api/Permissions/addrole',post,function(response){
					Permissions.getroles();
					self.conf.spanrole.html(self.conf.iconasterix);
					Permissions.clearrole();
				});
			}else{
				Request.gritererror('Empty', "<?php echo trim(Language::show('empty_name','Permissions')) ?>");
				Request.input('name');
				return false;
			}
		},
		addpermissions:function(){
			self = Permissions;
			post = self.conf.formpermisions.serialize();
			if(Request.check(self.conf.controller.val())){
				if(Request.check(self.conf.method.val())){
					Request.input('controller',false);
					Request.input('method',false);
					self.conf.spanperm.html(self.conf.img);

					Request.callPost('/Api/Permissions/addpermissions',post,function(response){
						Permissions.getpermissions();
						self.conf.spanperm.html(self.conf.iconasterix);
						Permissions.clearpermissions();

					});
				}else{
				Request.gritererror('Empty','<?php echo Language::show('empty_method','Permissions') ?>');
				Request.input('controller');
				return false;
				}
			}else{
				Request.gritererror('Empty','<?php echo Language::show('empty_controller','Permissions') ?>');
				Request.input('controller');
				return false;
			}
		},
		getroles:function(id=''){
			var html, self = Permissions,status_class,status_set;
			self.conf.spanrole.html(self.conf.img);
			post = "&id="+id;
			Request.dataPost('/Api/Permissions/getroles',post,function(response){
				data = response.data;
				dataone = response.dataone;
				length = Object.keys(response.data).length;
					if(response.action){
						self.conf.spanrole.html(self.conf.iconasterix);
						Permissions.updaterole(dataone);

					}
				html = "";
				if(data==null || data==''){
					html +='<tr><td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td></tr>';
		         			self.conf.tablerole.html(html);
		         }else{
					for(i=0; i < length; i++ ){
							if(data[i].status == true){
							  	data[i].status = 'Active';
								status_class = 'done';
								status_set = false;
							}else{
								data[i].status = 'Disattive';
								status_class = 'pending';
								status_set = true;
							}
							if(data[i].superuser == true){
							  	data[i].superuser = 'Y';
								super_class = 'done';
								super_set = false;
							}else{
								data[i].superuser = 'N';
								super_class = 'pending';
								super_set = true;
							}
							html +='<tr><td class="taskDesc"><i class="icon-info-sign"></i>'+data[i].name+'</td>'
									+'<td id="tdstatus" class="taskStatus"><a href="#" class="tip-top" id='+data[i].id+' data-status="'+super_set+'" data-action="updatethisusper"><span class="'+super_class+'">'+data[i].superuser+'</span></a></td>'
				         			+'<td id="tdstatus" class="taskStatus"><a href="#" class="tip-top" id='+data[i].id+' data-status="'+status_set+'" data-action="updatestatusrole"><span class="'+status_class+'">'+data[i].status+'</span></a></td>'
				         			+'<td id="tdroles" class="taskOptions">'
				         			+'<a href="/Permissions/Rolepermissions/'+data[i].id+'" class="tip-top" data-action="setpermissions" data-original-title="Update"><i class=" icon-wrench"></i></a> '				         			
				         			+'<a href="#" class="tip-top" id='+data[i].id+' data-action="updaterole" data-original-title="Update">'
				         			+'<i class="icon-edit"></i></a> <a href="#" data-action="deletethisrole" id='+data[i].id+' class="tip-top" data-original-title="Delete">'
				         			+'<i class="icon-remove"></i></a><div id="contentalertrole'+data[i].id+'"></div></td></tr>';
							self.conf.tablerole.html(html);

					}
				}
				self.conf.spanrole.html(self.conf.iconasterix);
			});
		},

		getpermissions:function(id=''){
			var html, self = Permissions,status_class;
			self.conf.spanperm.html(self.conf.img);
			post = "&id="+id;
			Request.dataPost('/Api/Permissions/getpermissions',post,function(response){
				data = response.data;
				dataone = response.dataone;

				length = Object.keys(response.data).length;
					if(response.action){
						self.conf.spanperm.html(self.conf.iconasterix);
						Permissions.updatepermissions(dataone);	

					}
				html = "";
				if(data==null || data==''){
					html +='<tr><td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td></tr>';
		         			self.conf.tablepermissions.html(html);
				}else{
					for(i=0; i < length; i++ ){
						if(data[i].param1 == ''){
						  	data[i].param1 = '-';
						}
						if(data[i].sublink){
						  	data[i].sublink = 'Yes';
						  	classe = "btn-inverse";
						}else{
							data[i].sublink = 'No';
				 			classe = "btn-danger";

						}
						html +='<tr><td class="taskDesc">'+data[i].controller+'</td>'
								+'<td class="taskDesc">'+data[i].method+'</td>'
								+'<td class="taskDesc">'+data[i].param1+'</td>'
								+'<td class=taskDesc><div class="btn-group">'
					            +'<button data-toggle="dropdown" class="btn btn-mini '+classe+'  dropdown-toggle">'+data[i].sublink+' <span class="caret"></span></button>'
					            +'<ul id="droplinks" class="dropdown-menu">'
					            +' <li><a data-action="sublink" data-value ="t" id="sublinkno-'+data[i].id+'" href="#">Si</a></li>'
					            +' <li><a  data-action="sublink" data-value ="f"  id="sublinksi-'+data[i].id+'" href="#">No</a></li>'
					            +' </ul>'
					     	    +' </div></td>'
			         			+'<td id="tdpermissions" class="taskOptions"><a  id='+data[i].id+' data-action="updatepermissions" class="tip-top" data-original-title="Update">'
			         			+'<i class="icon-edit"></i></a> <a  id='+data[i].id+' data-action ="deletethisperm"  class="tip-top" data-original-title="Delete">'	
			         			+'<i class="icon-remove"></i></a><div id="contentalertperm'+data[i].id+'"></div></td></tr>';
						self.conf.tablepermissions.html(html);

					}
				}
					self.conf.spanperm.html(self.conf.iconasterix);

			});


		},
		deletealert:function(id,data){
			var html = "";
			if(data=="deletethisrole"){
				html +='<div style="position:absolute;right:1px;margin-top:-31px;" class="alert alert-error">'
				+'<strong>Notice!</strong> Sei sicuro ?  <a href="#" id="'+id+'" data-action="deleterole" class="btn btn-danger btn-mini">Delete</a> <button class="btn btn-inverse btn-mini" data-dismiss="alert">Close</button></div>';
				$('#contentalertrole'+id).append(html);

			}else{
				html +='<div style="position:absolute;right:1px;margin-top:-31px;" class="alert alert-error">'
				+'<strong>Notice!</strong>Sei sicuro ?  <a href="#" id="'+id+'" data-action="deletepermissions" class="btn btn-danger btn-mini">Delete</a> <button class="btn btn-inverse btn-mini" data-dismiss="alert">Close</button></div>';

				$('#contentalertperm'+id).append(html);

			}
			
		},
		deleterole:function(id){
			self = Permissions;
			post ='id='+id;
			Request.callPost('/Api/Permissions/deleterole',post,function(response){
				self.getroles();
				$('#contentalertrole'+id).append('');
				Permissions.clearrole();
			});
		},
		deletepermissions:function(id){
			self = Permissions;
			post ='id='+id;
			Request.callPost('/Api/Permissions/deletepermissions',post,function(response){
				self.getpermissions();
				$('#contentalertperm'+id).append('');
				Permissions.clearpermissions();
			});
		},
		updaterole:function(data){
			self = Permissions;
			self.conf.name.val(data[0].name);
			self.conf.idrole.val(data[0].id);

		},
		rolestatus:function(id,state){
			self = Permissions;
			post ='&id='+id;
			post +='&status='+state;
			Request.callPost('/Api/Permissions/rolestatusupdate',post,function(response){
				self.getroles();

			});

		},
		superstatus:function(id,state){
			self = Permissions;
			post ='&id='+id;
			post +='&superstatus='+state;
			Request.callPost('/Api/Permissions/superstatusupdate',post,function(response){
				self.getroles();

			});

		},
		clearrole:function(data){
			self = Permissions;
			self.conf.name.val('');
			self.conf.idrole.val('');

		},			
		updatepermissions:function(data){
			self = Permissions;
			self.conf.idperm.val(data[0].id);
			self.conf.controller.val(data[0].controller);
			self.conf.method.val(data[0].method);
			self.conf.param1.val(data[0].param1);

		},
		clearpermissions:function(){
			self = Permissions;
			self.conf.idperm.val('');
			self.conf.controller.val('');
			self.conf.method.val('');
			self.conf.param1.val('');

		}		
	}

	Permissions.init({
	saverole:$('#saverole'),
	formrole:$('#formrole'),
	saverperm:$('#savepermissions'),
	formpermisions:$('#formpermisions'),
	name:$("input[name='name']"),
	idrole:$("#idrole"),
	idperm:$("#id_permissions"),
	controller:$("input[name='controller']"),
	method:$("input[name='method']"),
	param1:$('input[name="param1"]'),
	tablerole:$('#listroles'),
	tablepermissions:$('#listpermissions'),
	delete_role:$('#tdroles a'),
	delete_permissions:$('#tdpermissions a'),
	img:'<?php echo Media::img('spinner.gif')?>',
	spanrole:$('#spanrole'),
	spanperm:$('#spanperm'),
	iconasterix:'<i class="icon-asterisk">',
	roleclear:$('#clear_role'),	
	permisionsclear:$('#clear_permissions'),
	tdstatus:$('#tdstatus a'),
	droplinks:$('#droplinks a')	


	});
});
</script>