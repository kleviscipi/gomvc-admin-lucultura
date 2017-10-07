
    <div class="alert alert-success alert-dismissible fadeInDown" role="alert" id="flash_success">
      <button type="button"  class="close" data-dismiss="alert" ><span aria-hidden="true">&times;</span></button>
      <?php echo $message; ?>
    </div>

<script type="text/javascript">
$('#flash_success').addClass('animated fadeInDown');
$( ".close" ).click(function() {
    jQuery('#flash_success').removeClass('animated fadeInDown');
    jQuery('#flash_success').addClass(' animated fadeOutUp');
});
</script>
