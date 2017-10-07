<?php
use Go\Session as Session;
use Go\Language as Language;
?>
<?php $msg->display();


?>
<h1>Welcome <?php echo Session::get('name')  ?></h1>
<hr>
<div class="container-fluid">
	<ul class="quick-actions">
        <li class="bg_lb"> <a href="/Admin"> <i class="icon-dashboard"></i> My Dashboard </a> </li>
        <li class="bg_lg span3"> <a href="/Permissions/"> <i class="icon-legal"></i>Permissions</a> </li>
        <li class="bg_lo span3"> <a href="/Natyres/"> <i class="icon-camera"></i>Images & Videos</a> </li>
        <li class="bg_ls span3"> <a href="/Books/"> <i class="icon-book"></i>Books & Authors</a> </li>
        <li class="bg_lv span3"> <a href="/Movies/"> <i class="icon-film"></i>Movies & Actors</a> </li>
     </ul>

</div>