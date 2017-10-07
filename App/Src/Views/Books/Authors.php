<?php
use Go\Language as Language;
use Go\Media as Media;
use Go\Link as Link;
use Go\Session as Session;
use Go\Crypt as Crypt;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/
?>
<div class="row-fluid">
<?php $msg->display();?>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>List Authors (books)</h5>
          </div>
          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Number Books</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id='contentfilms'>
              <?php $i=0; ?>
              <?php foreach ($data['authors'] as $key => $author):?>
                  <tr id="<?php echo $i; ?>" class="gradeX">
                    <td><?php echo $author->fullname ?></td>
                    <td>
                     <span class="badge badge-info"><?php echo $author->count  ?></span>
                    </td>
                    <td class="taskOptions">
                        <a id="<?php echo Crypt::Tokenid($author->id) ?>" class="tip-top" data-original-title="View" data-action='view'>
                          <i class="icon-eye-open"></i>
                        </a>
                        <a href="#" data-action='delete' data-idtable='<?php echo $i; ?>' id="<?php echo Crypt::Tokenid($author->id) ?>" class="tip-top" data-original-title="Delete">
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
  var Thisauthors={
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
          window.location = "/Books/viewauthors/"+id;
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
      Request.callPost('/Api/Books/deleteauthor',post,function(response){
        if(response.error < 1){
          $('#'+idtable).fadeTo('2000',0,function(){
            $('#'+idtable).remove();
          });
        }
      });
    }
  }
  Thisauthors.init({
    button:$('.taskOptions').find('a')
  });
});
</script>