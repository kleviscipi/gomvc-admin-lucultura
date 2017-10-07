<?php
	namespace Go;
	use Go\Language as Language;
	use Go\Assets as Assets;
	use Go\Session as Session;
	use Go\Link as Link;
	use Go\Media as Media;
	use Go\SocialMedia as SocialMedia;
  use Go\Crypt as Crypt;
  use Go\AppModel as AppModel;
  use Go\Disk as Disk;?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $data['title'].' - '.SITETITLE;?></title>
    <link href="/favicon.ico?<?php echo time() ?>" type="image/x-icon" rel="icon"/><link href="/favicon.ico?<?php echo time() ?>"type="image/x-icon" rel="shortcut icon"/>
<?php
  if(isset($GLOBALS['menu'])){ $menu_model = $GLOBALS['menu'];} //start menu 
  if(isset($GLOBALS['menupermited'])){ $menu_model_permited  = $GLOBALS['menupermited'];}
  $disk       = new Disk('/');
  $freeSpace  = $disk->freeSpace();
  $totalSpace = $disk->totalSpace();
  $barWidth   = ($disk->usedSpace() * 100) / $totalSpace;
  $barWidth   = round($barWidth, 1);
  echo Media::css('bootstrap.min.css'). "\n";
  echo Media::css('bootstrap-responsive.min.css'). "\n";
  echo Media::css('bootstrap-wysihtml5.css'). "\n";
  echo Media::css('colorpicker.css'). "\n";
  echo Media::css('jquery.gritter.css'). "\n";
  echo Media::css('uniform.css'). "\n";
  echo Media::css('matrix-style.css'). "\n";
  echo Media::css('matrix-media.css'). "\n";
  echo Media::css('select2.css'). "\n";
  echo Media::customcss('fonts/css/font-awesome.css'). "\n";
  echo Media::httpcss('//fonts.googleapis.com/css?family=Open+Sans:400,700,800'). "\n";
  echo Media::css('flipclock.css'). "\n";
  echo Media::js('jquery.min.js'). "\n";
?>
<?php $lk_icon = ["Permissions" =>'<i class="icon  icon-fire"></i>',
                    "Admin"       =>'<i class="icon  icon-cogs"></i>',
                    "Books"       =>'<i class="icon  icon-book"></i>',
                    "Movies"      =>'<i class="icon  icon-film"></i>',
                    "Natyres"     =>'<i class="icon  icon-facetime-video"></i>'];
?>
<?php if(Session::get('language') =="it"){
  $icon = "";
  $style_it = "border: 1px solid #05b505;";
  }else if(Session::get('language') =="en"){
  $icon = "";
  $style_en = "border: 1px solid #05b505;";
  }else{
  $style_en = "";
  $style_it = "";
  }
?>
<script type="text/javascript"> var key  = "<?php echo Crypt::crypt(KEY_API); ?>";</script>
</head>
<body>
<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Matrix Admin</a></h1>
</div>
<!--close-Header-part--> 
<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
<?php if(!empty(Session::get('name'))): ?>
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" >
      <a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
        <i class="icon icon-user"></i><span class="text"> Welcome <?php echo Session::get('name') ?></span>
        <b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li><a href="/Admin/Profile"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="/Admin/"><i class="icon-check"></i> My Tasks</a></li>
      </ul>
    </li><?php if(Session::get('superuser')=="t"): ?>
    <li class="dropdown" data-superuser="<?php echo Session::get('superuser'); ?>" id="menu-messages">
      <a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i>
        <span class="text">Notifications</span>
        <span id ="countnotice" class="label label-important"></span><b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="/Admin/Notifications/"><i class="icon-plus"></i>Go to list</a></li>
      </ul>
    </li><?php endif; ?>
    <li class="">
      <a title="Permissions" href="/Permissions/"><i class="icon icon-cog"></i>
        <span class="text">Settings</span>
      </a>
    </li>
    <li class="dropdown">
      <a href="#" data-toggle="dropdown"  class="dropdown-toggle"><i class="icon icon-globe"></i>
        <span class="text">Languages</span>
        <span class="badge badge-warning">2</span><b class="caret"></b>
      </a>
      <ul id='setlanguage' class="dropdown-menu">
        <li style="<?php echo $style_it ?>">
          <a class="sAdd" title="" data-action='language' data-value='it' href="#">
            <i class="icon-ok"></i>It
          </a>
        </li>
        <li class="divider"></li>
        <li style="<?php echo $style_en ?>">
          <a class="sInbox" title="" data-action='language' data-value='en' href="#">
            <i class="icon-ok"></i>En
          </a>
        </li>
      </ul>
    </li>
    <li>
      <a title="Logout" id='logout' href="#" onclick="Request.logout()"><i class="icon icon-off"></i>
        <span class="text-warning">Logout</span>
      </a>
    </li>
  </ul>
<?php else:?>
<ul class="nav">
  <li>
    <a title="" href="#" class="dropdown-toggle"><i class="icon icon-user"></i>
    <span class="text-info">Welcome <?php echo Session::get('guest'); ?></span>
    </a>
  </li>
  <li class="dropdown">
    <a href="#" data-toggle="dropdown"  class="dropdown-toggle"><i class="icon icon-globe"></i>
      <span class="text">Languages</span>
      <span class="badge badge-warning">2</span><b class="caret"></b>
    </a>
      <ul id='setlanguage' class="dropdown-menu">
        <li style="<?php echo $style_it ?>">
          <a class="sAdd" title="" data-action='language' data-value='it' href="#">
            <i class="icon-ok"></i>It
          </a>
        </li>
        <li class="divider"></li>
        <li style="<?php echo $style_en ?>">
          <a class="sInbox" title="" data-action='language' data-value='en' href="#">
            <i class="icon-ok"></i> En
          </a>
        </li>
      </ul>
    </li>
  <li>
    <a title="" href="/Admin/Login" class="dropdown-toggle">
        <i class="icon icon-signin"></i><span class="text-success">Login</span>
    </a>
  </li>
</ul>

<?php endif ?>
</div>
<!--start-top-serch--><?php if(!empty(Session::get('name'))): ?>
<div id="search">
  <input id="lusearch" type="text" placeholder="Search here..."/>
  <button type="button" id="typesearchs" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>

  <div id="contenuto" style="right: 0px;
    margin: auto;
    border: 1px solid rgb(47, 182, 183);
    top: 33px;
    position: absolute;
    background-color: #f9f9f9;
    height: auto;
    max-height: 800px;
    width: 400px;
    overflow-x: hidden;
    overflow-y: scroll;
    display:none

    ">
    <div id="closecontenuto"></div>
    <div id="bookscontenuto"></div>
    <div id="authorscontenuto"></div>
    <div id="moviescontenuto"></div>
    <div id="actorscontenuto"></div>
    <div id="pagescontenuto"></div>
    <div id="morecontenuto"></div>
  </div>

</div><?php endif ?>
<!--close-top-serch--> 
<!--sidebar-menu-->
<div id="sidebar">
  <a href="#" class="visible-phone">
    <i class="icon icon-fullscreen"></i>Full width
  </a>
  <ul>
  <?php if(!empty($menu_model->ul)): ?><?php foreach ($menu_model->ul as $key => $menu):?>
    <li class="submenu">
        <a href="#"><?php echo $lk_icon[$menu->controller] ?>
          <span class="badge badge-info"><?php echo $menu->count ?></span>
          <span>  <?php echo $menu->controller; ?> </span>
        </a>
        <ul>
          <?php foreach ($menu_model->li as $key => $thatmenu): ?>
          <?php if($menu->controller == $thatmenu->controller){ ?>
              <li><?php if (!empty($thatmenu->param1)){
                  $thatmenu->param1 = $thatmenu->param1;
                }else{
                  $thatmenu->param1 = "";
                }
                if($thatmenu->method=="Index" ){
                  $method=$thatmenu->controller;
                }else{
                   $method =  $thatmenu->method;
                }echo Link::thisLink("/".$thatmenu->controller."/".$thatmenu->method."/".$thatmenu->param1,$method);?></li>
           <?php } ?>
         <?php  endforeach; ?>
        </ul>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
  <?php if(!empty($menu_model_permited)): ?>
    <?php foreach ($menu_model_permited as $ul => $menu):?>
      <li class="submenu"> <a href="#"><?php echo $lk_icon[$ul] ?>
        <span><?php echo ucfirst($ul); ?> </span>
        <span class="label label-important"><?php echo count($menu_model_permited[$ul]) ?></span>
        <ul>
          <?php  foreach ($menu_model_permited[$ul] as $li => $thatmenu): ?>
              <li><?php echo Link::thisLink("/".ucfirst($ul)."/".ucfirst($thatmenu)."/",ucfirst($thatmenu) ) ?></li>
         <?php endforeach; ?>
        </ul>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
    <li class="content"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width:<?php echo $barWidth ?>%;" class="bar"></div>
      </div>
      <span class="percent"><?php echo $barWidth ?>%</span>
      <div class="stat">Free: <?php echo $freeSpace ?> (of <?php echo $totalSpace ?>)</div>
    </li>
  </ul>
</div>
<!--main-container-part-->
<?php if(!empty($data['content-title'])):
      $c_title = $data['content-title'];
     else: 
      $c_title = $GLOBALS['method'];
     endif;
 ?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
    		<a href="/<?php echo $GLOBALS['class'] ?>" title="Go to <?php echo $GLOBALS['class'] ?>" class="tip-bottom">
    			<i class="icon-home"></i><?php echo $GLOBALS['class']; ?></a>
    		<a><?php echo $c_title ?></a>
    </div>
    <?php if(!empty($data['header-title'])):?>
 		<h1><?php echo $data['header-title'] ?></h1>
    <?php endif; ?>
</div>
<div class="container-fluid">
