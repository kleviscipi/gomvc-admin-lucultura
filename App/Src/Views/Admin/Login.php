<?php
use Go\Media as Media;
use Go\Language as Language;
use Go\Crypt as Crypt;
use Go\Link as Link;
use Go\Session as Session;


?>
<?php 
    echo Media::js('jquery.min.js');
    echo Media::css('jquery.gritter.css');
    echo Media::css('bootstrap.min.css');
    echo Media::css('bootstrap.min.css');
    echo Media::customcss('fonts/css/font-awesome.css');
    echo Media::httpcss('//fonts.googleapis.com/css?family=Open+Sans:400,700,800');
    echo Media::css('matrix-login.css')
?>
<script type="text/javascript">
var key  = "<?php echo Crypt::crypt(KEY_API); ?>";
</script>
<?php echo Media::css('matrix-login.css') ?>

<div id="loginbox">            
    <form id="loginform" class="form-vertical">
		 <div class="control-group normal_text"> <h3><?php echo Media::img('gologo_1.png')?></h3></div>

        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" name="email" placeholder="<?php echo Language::show('login_email','Admin') ?>" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="icon-lock"></i></span><input name='password' type="password" placeholder="<?php echo Language::show('login_password','Admin') ?>" />
                </div>
            </div>
        </div>
        <div class="form-actions">
            <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
            <span class="pull-right">

                <button type="button" id='login_admin' class="btn btn-success" /> Login</button>

                <button type="button" id='login_guest' class="btn btn-danger" /> Login As Guest</button>

            </span>
        </div>
    </form>
    <form id="recoverform" action="#" class="form-vertical">
		<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
		
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                </div>
            </div>
       
        <div class="form-actions">
            <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
            <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
        </div>
    </form>
</div>

<?php 
echo Media::js('jquery.gritter.min.js');
echo Media::js('matrix.login.js') 

?>
<?php echo Media::js('gojs.js') ?>

<script type="text/javascript">
    var Login={
        init:function(conf){
            this.conf = conf;
            this.events()
        },
        events:function(){
            this.conf.button.on('click',this.login);
            this.conf.buttonguest.on('click',this.loginguest);
        },
        login:function(){
            var self = Login;
            post = self.conf.form.serialize();
            post +='&from=login'; 
            Request.callPost('/Api/Admin/login',post,function(response){
                if(response.error < 1){
                    Request.redirect('/Permissions');
                }
            });
        },
        loginguest:function(){
            var self = Login;
            post ='';
            post +='&from=login'; 
            Request.callPost('/Api/Admin/loginguest',post,function(response){
                if(response.error < 1){
                    Request.redirect('/');
                }
            });
        }
    }

    Login.init({
        form:$('#loginform'),
        button:$('#login_admin'),
        buttonguest:$('#login_guest')

    });
</script>

