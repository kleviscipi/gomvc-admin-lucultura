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
          <h5>Books Statistics</h5>
        </div>
        <div class="widget-content">
          <div class="row-fluid">
            <div class="span6">
              <ul class="site-stats">
                <li class="bg_lr"><i class="icon-book"></i> 
                	<strong><?php echo $data['statistics']->books->count; ?></strong>
                	<small>Books</small>
                </li>
                <li class="bg_lb">
                	<i class="icon-user"></i>
               		<strong><?php echo $data['statistics']->authors->count; ?></strong>
               		<small>Authors</small>
                </li>
                <li class="bg_lh">
                	<i class="icon-check-empty"></i>
                		<strong>
                			<?php echo $data['statistics']->bookemptyauthor->count; ?>
                		</strong>
                	<small>Empty Authors</small>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
</div>