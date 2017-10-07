    <?php
    
    use Go\Language as Language;
    use Go\Media as Media;
    use Go\Link as Link;
    use Go\Session as Session;

   ?>
  <h2><?php echo Language::show('user_title_perm','Permissions') ?> <?php echo $data['user']->name ?> <?php echo $data['user']->subname ?></h2>
  <div class="row-fluid">
  
        <div class="span6">
	        <div class="widget-box">
	          <div class="widget-title"> <span class="icon"> <i class="icon-eye-open"></i> </span>
	            <h5><?php echo Language::show('user_details','Permissions') ?></h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table">
	              <thead>
	                <tr>
	                  <th><?php echo Language::show('user_detail','Permissions') ?></th>
	                  <th>-</th>
	                </tr>
	              </thead>
	              <tbody>
	                <tr>
	                  <td><?php echo $data['user']->name ?> <?php echo $data['user']->subname ?></td>
	                  <td><?php echo Language::show('user_fullname','Permissions') ?></td>
	                </tr>
	                <tr>
	                  <td><?php echo $data['user']->email ?></td>
	                  <td><?php echo Language::show('user_email','Permissions') ?></td>
	                </tr>
	                <tr>
	                  <td><?php echo $data['user']->username ?></td>
	                  <td><?php echo Language::show('user_username','Permissions') ?></td>
	                </tr>
	                <tr>
	                  <td><span class="label label-inverse"><?php echo $data['user']->rolename ?></span></td>
	                  <td><?php echo Language::show('user_role','Permissions') ?></td>
	                </tr>
	                <tr>
	                  <td><span class="date badge badge-info"><?php echo $data['user']->created ?></span></td>
	                  <td><?php echo Language::show('user_created','Permissions') ?></td>
	                </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>
			<div class="widget-box">
			  <div class="widget-title"> <span id='spanperm' class="icon"><i  class="icon-plus"></i></span>
			    <h5><?php echo Language::show('title_permissions','Permissions'); ?></h5>
			  </div>
			  <div class="widget-content nopadding">
			    <table class="table table-striped table-bordered">
			      <thead>
			        <tr>
			          <th><?php echo Language::show('title_controller','Permissions') ?></th>
			          <th><?php echo Language::show('title_controller','Permissions') ?></th>
			          <th><?php echo Language::show('title_param1','Permissions') ?></th>
			          <th><?php echo Language::show('title_opt','Permissions') ?></th>
			        </tr>
			      </thead>
			      <tbody id='listpermissions'></tbody>
			    </table>
			  </div>
			</div>
			</div>
			<div class="span6">
	        <div class="widget-box">
	          <div class="widget-title"> <span id='spanpermuser' class="icon"><i class="icon-th"></i></span>
	            <h5><?php echo Language::show('usert_thatpersmissions','Permissions'); ?></h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-striped table-bordered">
	              <thead>
	                <tr>
	                  <th><?php echo Language::show('title_controller','Permissions') ?></th>
	                  <th><?php echo Language::show('title_controller','Permissions') ?></th>
	                  <th><?php echo Language::show('title_param1','Permissions') ?></th>
	                  <th><?php echo Language::show('perms_status','Permissions') ?></th>
	                  <th>Opts</th>
	                </tr>
	              </thead>
	              <tbody id ="listssetspermissions"></tbody>
	            </table>
	          </div>
	        </div>
			</div>
		</div>

<div id='error_ajax'></div>


<script type="text/javascript">
$(document).ready(function(){
	var Set={
		datapermision:[],
		init:function(conf){
			this.conf=conf;
			this.events();
			
		},
		events:function(){
			this.permissions();
			this.permissionsuser();
			this.conf.linkuserperm.live('click',function(e){
				id 		=$(this).attr('id');
				data 	= $(this).data('action');
				switch(data){
					case "updatestatus":
						Set.updatestatus(id);
					break;
					case"deletethisperm":
						content = $(this).data('content');
						Request.deletealert(id,'deleteuserpermisions',content);
					break;
					case "deleteuserpermisions":
						content = $(this).data('content');

						Set.deleteuserpermisions(id,content);
					break;
					case"addpermission":
						idobject = $(this).data('datas');
						Set.setpermissions(id,idobject);
					break;
				}
				e.preventDefault();
			});
			this.conf.linkperm.live('click',function(e){
				id 		=$(this).attr('id');
				data 	= $(this).data('action');
				switch(data){
					case"addpermission":
						Set.setpermissions(id);
					break;
				}
				e.preventDefault();
			});
		},
		setpermissions:function(id){
			var self =Set;
			post ='&id='+id; 
			post +='&iduser='+self.conf.id;
			post +='&role_id=<?php echo $data['user']->role_id ?>';

			Request.callPost('/Api/Permissions/adduserpermissions',post,function(response){
				Set.permissions();
				Set.permissionsuser();
			});
		},
		permissions:function(id=''){
			var html, self = Set,perm_set,perm_class,perm_txt;
			self.conf.spanperm.html(self.conf.img);
			if(id =='' || typeof id == "undefined"){
				id = Set.conf.id;
				post = "&id="+id;
			}else{
				post = "&id="+id;
			}
			Request.dataPost('/Api/Permissions/permissionsuser',post,function(response){
				data = response.data;
				Set.datapermision = data;

				length = Object.keys(response.data).length;
				html = "";
				if(data==null || data==''){
					html +='<tr><td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td></tr>';
		         			self.conf.tablepermissions.html(html);
				}else{
					for(i=0; i < length; i++ ){
						if(data[i].param1 == ''){
						  	data[i].param1 = '-';
						}
						if(data[i].permited==null  && data[i].userid == null){
							perm_set = 'addpermission';
							perm_txt = 'Add';
							perm_class='<a href="#" id='+data[i].id+' data-action="'+perm_set+'" class="tip-top"><span class="label label-inverse">'+perm_txt+'</span></a>';

						}else if(data[i].permited==true || data[i].permited == false ){
							if( data[i].userid == self.conf.id ){
								perm_txt = 'Added';
								perm_class='<span class="label label-success">'+perm_txt+'</span>';								
							}else{
								perm_set = 'addpermission';
								perm_txt = 'Add';
								perm_class='<a href="#" id='+data[i].id+' data-action="'+perm_set+'" class="tip-top"><span class="label label-inverse">'+perm_txt+'</span></a>';
							}

						}

						html +='<tr><td class="taskDesc">'+data[i].controller+'</td>'
								+'<td class="taskDesc">'+data[i].method+'</td>'
								+'<td class="taskDesc">'+data[i].param1+'</td>'
			         			+'<td id="tdpermissions" class="taskOptions">'+perm_class+'</td></tr>';
						self.conf.tablepermissions.html(html);

					}
				}
					self.conf.spanperm.html(self.conf.iconplus);

			});

		},
		permissionsuser:function(){
			var html, self = Set,status_class,status_txt,thatstatus;
			self.conf.spanpermuser.html(self.conf.img);
			id = self.conf.id;
			if(!id =='' || typeof !id == "undefined"){
				post = "&user_id="+id;
			}
			Request.dataPost('/Api/Permissions/user_permisions',post,function(response){
				data = response.data;
				console.log(data);
				length = Object.keys(response.data).length;
				html = "";
				if(data==null || data==''){
					html +='<tr><td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td>'
							+'<td class="taskDesc">-</td></tr>';
		         			self.conf.tablesetspermissions.html(html);
				}else{
					for(i=0; i < length; i++ ){
						if(data[i].param1 == ''){
						  	data[i].param1 = '-';
						}
						if(data[i].permited){
							status_class = "label-success";
							status_txt = "Active";
							thatstatus = false;
						}else{
							status_class = "label-important";
							status_txt = "No Active";
							thatstatus = true;
						}


						html +='<tr><td class="taskDesc">'+data[i].controller+'</td>'
								+'<td class="taskDesc">'+data[i].method+'</td>'
								+'<td class="taskDesc">'+data[i].param1+'</td>'
								+'<td id="contentuserperm" class="taskStatus"><a data-action="updatestatus" id="setstatus-'+data[i].id+'-'+thatstatus+'-'+data[i].user_id+'" href=""><span class="label '+status_class+'">'+status_txt+'</span></a></td>'
			         			+'<td id="tdpermissions" class="taskOptions">'
			         			+'<a href="#" id='+data[i].id+' data-action ="deletethisperm" data-content="alertperm'+data[i].id+'"  class="tip-top" data-original-title="Delete">'	
			         			+'<i class="icon-remove"></i></a><div id="alertperm'+data[i].id+'"></div></td></tr>';
						self.conf.tablesetspermissions.html(html);

					}
				}
					self.conf.spanpermuser.html(self.conf.iconth);

			});
		},
		updatestatus:function(id){
			console.log(id);
			post ='&id='+id; 
			Request.callPost('/Api/Permissions/updatestatus',post,function(response){
				Set.permissions();
				Set.permissionsuser();
			});
		},
		deleteuserpermisions:function(id,content){
			self = Set;
			post ='&id='+id;
			post +='&userid='+self.conf.id;
			Request.callPost('/Api/Permissions/deleteuserpermisions',post,function(response){
				self.permissions();
				self.permissionsuser();
				Request.cleardelete(content);
			});
		},
	}
	Set.init({
		id:'<?php echo $data['user']->id ?>',
		tablepermissions:$('#listpermissions'),
		tablesetspermissions:$('#listssetspermissions'),
		img:'<?php echo Media::img('spinner.gif')?>',
		iconplus:'<i class="icon-plus">',
		iconth:'<i class="icon-th"></i>',
		spanperm:$('#spanperm'),
		spanpermuser:$('#spanpermuser'),
		linkuserperm:$('#listssetspermissions a'),
		linkperm:$('#tdpermissions a'),


	});
});

</script>