<div class="alert alert-warning alert-dismissible" role="alert" id="flash_warning">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo $message; ?>
</div>


<script type="text/javascript">
$('#flash_warning').addClass('animated fadeInDown');
$( ".close" ).click(function() {
    jQuery('#flash_warning').removeClass('fadeInDown');
    jQuery('#flash_warning').addClass('fadeOutUp');
});
</script>
