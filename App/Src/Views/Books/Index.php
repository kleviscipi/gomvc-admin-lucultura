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
    <h5>List of books</h5>
  </div>
  <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>
  <div class="widget-content nopadding">
    <table class="table table-bordered data-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Publisher date</th>
          <th>Rating</th>
          <th>Pages</th>
          <th>Language</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id='contentfilms'>
      <?php $i=0; ?>
      <?php foreach ($data['books'] as $key => $book):?>
          <tr class="gradeX" id="<?php echo $i ?>">
            <td><?php echo substr($book->title,0,30) ?></td>
            <td><span class="badge badge-info"><?php echo substr($book->author_name,0,20) ?></span></td>
            <td><?php echo $book->publisherdate ?></td>
            <td>
            <?php
            if(empty($book->rating)){
                $book->rating="No rating";
                $class="badge-important";
            }else{
                $class="badge-warning";
            }?>
            <span class="badge <?php echo $class ?>"><?php echo $book->rating?></span>
            </td>
            <td><?php echo $book->pages ?></td>
            <td><?php echo $book->language ?></td>
            <td class="taskOptions">
            <a href="#" data-action='view' id="<?php echo Crypt::Tokenid($book->google_id) ?>" class="tip-top" data-original-title="View"><i class="icon-eye-open"></i></a>
            <a href="<?php echo $book->previewlink ?>" target='new' id="<?php echo $book->id ?>" class="tip-top" data-original-title="Google"><i class="icon-cloud"></i></a>
            <a data-action='delete' data-idtable="<?php echo $i ?>" href="#" id="<?php echo Crypt::Tokenid($book->id) ?>" class="tip-top" data-original-title="Delete"><i class="icon-remove"></i></a></td>
          </tr>
          <?php $i ++; ?>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  var Books={
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
          window.location = "/Books/view/"+id;
          break;
          case "delete":
          idtable = $(this).data('idtable');
          Books.delete(id,idtable);
          break;
        }
      });
    },
    delete:function(id,idtable){
      post ='&id='+id;
      $('#'+idtable).css('background-color','red');
      Request.callPost('/Api/Books/delete',post,function(response){
        if(response.error < 1){
          $('#'+idtable).fadeTo('2000',0,function(){
            $('#'+idtable).remove();
          });
        }
      });

    }
  }
  Books.init({
    button:$('.taskOptions').find('a')


  });
});
</script>