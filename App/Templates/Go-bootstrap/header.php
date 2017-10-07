<?php
namespace Go;
use Go\Language as Language;
use Go\Assets as Assets;
use Go\Session as Session;
use Go\Link as Link;
use Go\Media as Media;
  use Go\SocialMedia as SocialMedia;


?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title.' - '.SITETITLE;?></title>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">  -->
 
<?php echo  Media::httpscss('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css','sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u','anonymous'); ?>
<?php echo Media::css('gocss.css');?>

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">


<nav class="navbar navbar-default">
  <div class="container">
      
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
       <a class="navbar-brand" href="#myPage">  <?=SITETITLE;?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#education">EDUCATION</a></li>
        <li><a href="#services">SERVICES</a></li>
        <li><a href="#portfolio">PORTFOLIO</a></li>
        <li><a href="#contact">CONTACT</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
<?php echo Link::autoLink("www.site.com",'ddd'); ?>

<br>
<div id='error_ajax'></div>
