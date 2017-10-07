  <?php
    use Go\Language as Language;
    use Go\Media as Media;
   ?>
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span id='spanuser' class="icon"> <i class="icon-plus"></i> </span>
          <h5><?php echo Language::show('add_title','Admin') ?></h5>
        </div>
        <div class="widget-content nopadding">
          <form  id='addadmin' class="form-horizontal">
            <div class="control-group">
              <label class="control-label"><?php echo Language::show('add_name','Admin') ?></label>
              <div class="controls">
                <input type="text" id='name' name='name' class="span11" placeholder="<?php echo Language::show('add_name','Admin') ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label"><?php echo Language::show('add_lastname','Admin') ?></label>
              <div class="controls">
                <input type="text" id='subname' name='subname' class="span11" placeholder="<?php echo Language::show('add_lastname','Admin') ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label"><?php echo Language::show('add_email','Admin') ?></label>
              <div class="controls">
                <input type="text" id='email' name='email' class="span11" placeholder="<?php echo Language::show('add_email','Admin') ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label"><?php echo Language::show('add_username','Admin') ?></label>
              <div class="controls">
                <input type="text" id='username' name='username' class="span11" placeholder="<?php echo Language::show('add_username','Admin') ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label"><?php echo Language::show('add_password','Admin') ?></label>
              <div class="controls">
                <input type="password" id='password' name='password'  class="span11" placeholder="<?php echo Language::show('add_password','Admin') ?>"  />
              </div>
            </div>
            <div class="control-group">
            <div class="control-group">
              <label class="control-label"><?php echo Language::show('add_role','Admin') ?></label>
              <div class="controls">
                <select id='roleresult' name="role"><option select><?php echo Language::show('add_role','Admin') ?></option></select>
              </div>
            </div>
            <div class="form-actions">
              <button type="button"  id='saveadmin' class="btn btn-success"><?php echo Language::show('add_save','Admin') ?></button>
               <button type="button"  id='clearadmin' class="btn btn-inverse"><?php echo Language::show('add_clear','Admin') ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<div id='error_ajax'></div>
<script type="text/javascript">
  
$( document ).ready(function($) {
    var Add = {
      init:function(conf){
        this.conf = conf;
        this.events();
      },
      events:function(){
        this.conf.button.on('click',this.add);
        this.getroles();
        this.conf.buttonclear.on('click',this.clear);

      },
      add:function(){
        var self = Add;
        post = self.conf.data.serialize();
        if(Request.check(self.conf.name.val())){
          Request.input('name',false);
          if(Request.check(self.conf.subname.val())){
            Request.input('subname',false);
              if(Request.check(self.conf.password.val())){
                Request.input('password',false);
                  if(Request.check(self.conf.role.val())){
                    Request.input('s2id_roleresult',false);
                        if(Request.checkemail(self.conf.email.val())){
                            Request.input('email',false);
                            Add.clear();
                            Request.callPost('/Api/Admin/add',post,function(response){
                              console.log(response);
                            });
                        }else{
                          Request.gritererror('Notice','<?php echo Language::show('check_email','Admin') ?>');
                          Request.input('email');
                          return false;
                        }

                  }else{
                    Request.gritererror('Empty','<?php echo Language::show('empty_role','Admin') ?>');
                    Request.input('s2id_roleresult');
                    return false;
                  }
              }else{
                Request.gritererror('Empty','<?php echo Language::show('empty_password','Admin') ?>');
                Request.input('password');
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
      getroles:function(){
      var html="", self = Add;
      self.conf.spanuser.html(self.conf.img);

      Request.dataPost('/Api/Permissions/getrolesadd','',function(response){
        data = response.data;
        length = Object.keys(response.data).length;
        console.log(response);
        html = "<option value='' selected><?php echo Language::show('add_role','Admin') ?></option>";
        for (var i = length - 1; i >= 0; i--) {
           html +="<option value="+data[i].id+">"+data[i].name+"</option>"
        }
        self.conf.listroles.html(html);
        self.conf.spanuser.html(self.conf.iconplus);
      });
    },
    clear:function(){
      var self = Add;
      self.conf.inputs.attr('value','');
    }


    }

    Add.init({
      data: $('#addadmin'),
      button:$('#saveadmin'),
      buttonclear:$('#clearadmin'),
      img:'<?php echo Media::img('spinner.gif')?>',
      spanuser:$('#spanuser'),
      iconplus:'<i class="icon-plus">',
      listroles:$('#roleresult'),
      name:$('#addadmin input[name="name"]'),
      subname:$('#addadmin input[name="subname"]'),
      email:$('#addadmin input[name="email"]'),
      password:$('#addadmin input[name="password"]'),
      role:$('#addadmin select[name="role"]'),
      inputs:$('#addadmin input')

    });
});

  </script>