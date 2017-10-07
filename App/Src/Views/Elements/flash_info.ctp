<div class="alert alert-info alert-dismissible" role="alert" id="flash_info">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo $message; ?>
</div>

<script type="text/javascript">
$('#flash_info').addClass('animated fadeInDown');
$( ".close" ).click(function() {
    jQuery('#flash_info').removeClass('fadeInDown');
    jQuery('#flash_info').addClass('fadeOutUp');
});
</script>
