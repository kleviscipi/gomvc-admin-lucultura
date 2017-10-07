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
<h1>Movies</h1>
<hr>
<div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>List of movies</h5>
          </div>
          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Imdb Id</th>
                  <th>Actor id</th>
                  <th>Title</th>
                  <th>Site</th>
                  <th>Header</th>
                  <th>Year</th>
                  <th>Duration</th>
                  <th>Rating</th>
                  <th>Released</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id='contentfilms'>
              <?php  $i = 0; ?>
              <?php foreach ($data['movies'] as $key => $movie):?>
                  <tr class="gradeX" id="<?php echo $i; ?>">
                    <td><?php echo $movie->idm_id ?></td>
                    <td><?php echo $movie->idm_actor ?></td>
                    <td><?php echo substr($movie->title,0,20) ?></td>
                    <td><?php 
                    if($movie->onsite){
                      $movie->onsite = "Yes";
                    }else{
                      $movie->onsite = "No";
                    }
                    echo $movie->onsite ?>
                    </td>
                    <td><?php 
                    if($movie->onheadersite){
                      $movie->onheadersite = "Yes";
                    }else{
                      $movie->onheadersite = "No";
                    }
                    echo $movie->onheadersite ?>
                    </td>
                    <td><span class="badge badge-info"><?php echo $movie->year ?></span></td>
                    <td><?php echo $movie->duration ?></td>
                    <td>
                      <?php
                      if(empty($movis->rating)){
                        $class = "badge-important";
                        $txt = "No Rating";
                      }else{
                        $class = "badge-info";
                        $txt = $movie->rating;
                      }?>

                      <span class="badge <?php echo $class ?>"><?php echo $txt ?></span>

                    </td>
                    <td><span class="badge badge-info"><?php echo $movie->released ?></span></td>
                    <td class="taskOptions">
                    <a id="<?php echo Crypt::Tokenid($movie->id) ?>" class="tip-top" data-original-title="View" data-action='view'>
                      <i class="icon-eye-open"></i>
                    </a>
                    <a href="#" data-action='delete' data-idtable='<?php echo $i; ?>' id="<?php echo Crypt::Tokenid($movie->id) ?>" class="tip-top" data-original-title="Delete">
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

      var Movies={
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
              window.location = "/Movies/View/"+id;
              break;
              case "delete":
              idtable = $(this).data('idtable');
              Movies.delete(id,idtable);
              break;
            }
          });
        },
        delete:function(id,idtable){
          post ='&id='+id;
          $('#'+idtable).css({'background-color':'red','color':'white'});
          Request.callPost('/Api/Movies/delete',post,function(response){
            if(response.error < 1){
              $('#'+idtable).fadeTo('2000',0,function(){
                $('#'+idtable).remove();
              });
            }
          });

        }
      }
      Movies.init({
        button:$('.taskOptions').find('a')


      });
    });

</script>