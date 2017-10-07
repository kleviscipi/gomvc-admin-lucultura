<div class="alert alert-danger alert-dismissible" role="alert" id="flash_error">
  <button class="close"><span aria-hidden="true">&times;</span></button>
  <?php echo $message; ?>
</div>

<script type="text/javascript">
$('#flash_error').addClass('animated fadeInDown');
$( ".close" ).click(function() {
    jQuery('#flash_error').removeClass(' fadeInDown');
    jQuery('#flash_error').addClass(' fadeOutUp');
});
</script>
