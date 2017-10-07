<?php 
use Go\Validator as Validator;
use Go\Csv as Csv;
use Go\Link as Link;
use Go\Crypt as Crypt;
Use Go\Document as Document;
use Go\Media as Media;

echo "<br><br><br><br><br><br><br><br><br><br>";

echo $data['title'];

	foreach ($data['persons'] as $key => $value) {
		echo $value->name;
	}
echo "<br>";
echo Validator::words('mywoefefrds')->ucf;
$string = [
		'1'=>"test1",
		'2'=>"test2",
		'3'=>"tsest3",
		'4'=>"test4",
		'5'=>"test5",
		'6'=>"test6"

	];
echo "<br>";
			echo Document::getExt('AdminLTE.min.css');
		
?>

<button id='yourButton' onclick="call()" >My button</button>

<script type="text/javascript">

// function call(){
//   console.log('ok');
//   var l ;
//  Request.callPost('/Api/Pagedd/start/','mypost',function(response){
//  		console.log(response.text);
//   },'Perso added success fully');
 
  

// }


</script>
