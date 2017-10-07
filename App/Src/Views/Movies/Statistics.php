<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;

/***********************************
* 2016-11-16                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/
?>
<h1><?php echo $data['content-title'] ?></h1>
<hr>
<div class="row-fluid">
	<div class="widget-box">
        <div class="widget-title bg_lb"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Site Analytics</h5>
        </div>
        <div class="widget-content">
          <div class="row-fluid">
            <div class="span6">
              <ul class="site-stats">
                <li class="bg_lr"><i class="icon-user"></i> 
                <strong><?php echo $data['statistics']->movies->count; ?></strong> <small>Movies</small>
                </li>
                <li class="bg_lb"><i class="icon-plus"></i>
                <strong><?php echo $data['statistics']->actors->count; ?></strong> <small>Actors</small>
                </li>
                <li class="bg_lh"><i class="icon-shopping-cart"></i> <strong><?php echo $data['statistics']->company->count; ?></strong> <small>Company</small></li>
                <li class="bg_lh"><i class="icon-tag"></i> <strong><?php echo $data['statistics']->movies->count - $data['statistics']->moviewithactor->count; ?></strong> <small>Movies with no actor id</small></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
</div>