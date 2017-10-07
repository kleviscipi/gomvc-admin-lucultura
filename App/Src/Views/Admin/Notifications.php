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
          <h5>Notifications</h5>
        </div>
        <div class="widget-content">
          <div class="row-fluid">
            <div class="span6">
              <div class="widget-box">
                  <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
                    <h5>All notifications</h5>
                  </div>
                  <div class="widget-content nopadding">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Action</th>
                          <th>Controller</th>
                          <th>Description</th>
                          <th>Opts</th>
                        </tr>
                      </thead>
                      <tbody id="allnotice">
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <div class="span6">
              <div class="widget-box">
                  <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
                    <h5>Notifications of the day</h5>
                  </div>
                  <div class="widget-content nopadding">
                    <table id="mt"  class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Action</th>
                          <th>Controller</th>
                          <th>Description</th>
                          <th>Opts</th>
                        </tr>
                      </thead>
                      <tbody id="daynotice">
                      
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  var Notice={
      init:function(conf){
        this.conf = conf;
        this.events();
      },
      events:function(){
        Notice.set();
        Notice.select();
        Notice.selectday();
      },
      set:function(){
        var post;
        post='&set=true';
        Request.dataPost('/Api/Admin/updatenotice',post,function(response){
          console.log(response.error);
        });
      },
      select:function(){
        var html = "",self = Notice;
        Request.dataPost('/Api/Admin/notificationlist',post,function(response){
          if(response.error < 1){
            data = response.data;
            length = Object.keys(data).length;
            for (var i = length - 1; i >= 0; i--) {
              if(data[i].action=="Add"){
                cl = "done";
              }
              if(data[i].action=="Delete"){
                cl = "pending";
              }
              html +='<tr><td class="taskStatus"><span class="'+cl+'">'+data[i].action+'</span></td>'
                        +'<td class="taskDesc">'+data[i].controller+'</td>'
                        +'<td><span class="badge badge-important">'+data[i].name +" "+ data[i].subname+'</span> '+ data[i].description+'</td>'
                        +'<td class="taskOptions"><a href="#" class="tip-top" data-original-title="Update"><i class="icon-ok"></i></a>'
                        +'<a href="#" class="tip-top" data-original-title="Delete"><i class="icon-remove"></i></a></td>'
                        +'</tr>';              
            }
            self.conf.allnotice.append(html);

          }
        });
      },
      selectday:function(){
        var self= Notice,html = "";
        Request.callPost('/Api/Admin/notificationday',post,function(response){
                    if(response.error < 1){
            data = response.data;
            length = Object.keys(data).length;
            for (var i = length - 1; i >= 0; i--) {
              if(data[i].action=="Add"){
                cl = "done";
              }
              if(data[i].action=="Delete"){
                cl = "pending";
              }
              html +='<tr><td class="taskStatus"><span class="'+cl+'">'+data[i].action+'</span></td>'
                        +'<td class="taskDesc">'+data[i].controller+'</td>'
                        +'<td><span class="badge badge-important">'+data[i].name +" "+ data[i].subname+'</span> '+ data[i].description+'</td>'
                        +'<td class="taskOptions"><a href="#" class="tip-top" data-original-title="Update"><i class="icon-ok"></i></a>'
                        +'<a href="#" class="tip-top" data-original-title="Delete"><i class="icon-remove"></i></a></td>'
                        +'</tr>';              
            }
            self.conf.daynotice.append(html);
          }
        });
      }
  }
  Notice.init({
    allnotice:$('#allnotice'),
    daynotice:$('#daynotice')
  });
});


</script>