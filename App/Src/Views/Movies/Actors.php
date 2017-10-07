<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;
use Go\Crypt as Crypt;
/***********************************
* 2016-11-16                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/


?>
<h1>Actors</h1>
<hr>
<div class="row-fluid">
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
        <h5>List of actors</h5>
      </div>
      <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

      <div class="widget-content nopadding">
        <table class="table table-bordered data-table">
          <thead>
            <tr>
              <th>Idm Id</th>
              <th>Ocupation</th>
              <th>Full Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=0 ?>
          <?php foreach ($data['actors'] as $key => $actor):?>
              <tr class="gradeX" id="<?php echo $i ?>">
                <td><?php echo $actor->idm_id ?></td>
                <td>
                <?php 
                  $ocupation= $actor->ocupation ;
                  $ocupation = explode(',',$ocupation);
                ?>
                <?php  foreach ($ocupation as $key => $oc):?>
                  <span class="badge badge-warning"><?php echo trim($oc,"{}") ?></span>
                <?php endforeach ?>
                </td>
                <td><?php echo $actor->name ?></td>
                <td class="taskOptions">
                    <a id="<?php echo Crypt::Tokenid($actor->idm_id) ?>" class="tip-top" data-original-title="View" data-action='view'>
                      <i class="icon-eye-open"></i>
                    </a>
                    <a href="#" data-action='delete' data-idtable='<?php echo $i; ?>' id="<?php echo Crypt::Tokenid($actor->idm_id) ?>" class="tip-top" data-original-title="Delete">
                    <i class="icon-remove"></i>
                    </a>
                </td> 
              </tr>
          <?php $i++; ?>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

      var Thisactor={
        init:function(conf){
          this.conf = conf;
          this.events();
        },
        events:function(){
          this.conf.button.on('click',function(){
            data = $(this).data('action');
            id   = $(this).attr('id');
            switch(data){
              case "view":
              window.location = "/Movies/Viewactor/"+id;
              break;
              case "delete":
              idtable = $(this).data('idtable');
              Thisauthors.delete(id,idtable);
              break;
            }
          });
        },
        delete:function(id,idtable){
          post ='&id='+id;
          $('#'+idtable).css('background-color','red');
          Request.callPost('/Api/Movies/deleteactor',post,function(response){
            if(response.error < 1){
              $('#'+idtable).fadeTo('2000',0,function(){
                $('#'+idtable).remove();
              });
            }
          });

        }
      }
      Thisactor.init({
        button:$('.taskOptions').find('a')


      });
    });

</script>