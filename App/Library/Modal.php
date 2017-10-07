<?php 
namespace Go;
/*
	klevis cipi 
	cipiklevis@gmail.com
*/
class Modal
{	

	public static function button($type=[]){
		if(is_array($type) && !empty($type)){
			if(!empty($type['id'])){
				$id = "id='{$type['id']}'";
			}else{
				$id = "";
			}
			if(!empty($type['class'])){
				$class = "class='{$type['class']}'";
			}else{
				$class = "";
			}
			if(!empty($type['text'])){
				$text = $type['text'];
			}else{
				$text = "MyModal";
			}
		}
		$html .= "<button {$id} {$class}>{$text}</button>";

		return $html;
	}


	public static function js($idmodal,$idbutton){
		$js= "<script>

					 $(document).ready(function () {
								var modal 	= $('#{$idmodal}');
								var btn 	= $('#{$idbutton}');

								var span 	=$('span.modal_close_go') ;

								btn.on('click',function(e){
									modal.css('display','block');


								})

								span.on('click',function(){
									modal.css('display','none');
								})

								window.onclick = function(event) {
									h = event.target.nodeName;


								    if (h == 'DIV') {

								        modal.css('display','none'); 
								   }
								}
							});

				</script>";

		return $js;
	}
}