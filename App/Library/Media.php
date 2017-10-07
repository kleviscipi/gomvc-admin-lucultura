<?php 
namespace Go;
use Go\Crypt AS Crypt;
use Go\Document as Document;

class Media
{

	public static function css($file){

		$css = ROOT_ASSETS.'css'.DIR.$file;
		if(file_exists($css)){
			$css = URL_ASSETS.'css'.DIR.$file;
			$css = '<link rel="stylesheet" type="text/css" href="'.$css.'">';
			return $css;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($css), DON'T EXIST ");
			die;
		}

	}

	public static function customcss($file){

		$css = ROOT_ASSETS.DIR.$file;
		if(file_exists($css)){
			$css = URL_ASSETS.$file;
			$css = '<link rel="stylesheet" type="text/css" href="'.$css.'">';
			return $css;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($css), DON'T EXIST ");
			die;
		}

	}
	public static function httpcss($file,$integrity = null,$crossorigin=null){

		if(!empty($file)){
			if($integrity!=null){
				$i_t='integrity="'.$integrity.'"';
			}else{
				$i_t = '';
			}
			if($crossorigin!=null){
				$c_t='crossorigin="'.$crossorigin.'"';
			}else{
				$c_t = '';
			}

			 $css = '<link rel="stylesheet" type="text/css" href="http:'.$file.'" '.$i_t.' '.$c_t.'>';
			 return $css;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($css), DON'T EXIST OR EMPTY");
			die;
		}

	}
	public static function httpjs($file,$integrity = null,$crossorigin=null){

		if(!empty($file)){
			if($integrity!=null){
				$i_t='integrity="'.$integrity.'"';
			}else{
				$i_t = '';
			}
			if($crossorigin!=null){
				$c_t='crossorigin="'.$crossorigin.'"';
			}else{
				$c_t = '';
			}
			$js = '<script '.$i_t.' '.$c_t.' src="http:'.$file.'"></script>';
			return $js;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($js), DON'T EXIST OR EMPTY");
			die;
		}

	}
	public static function httpscss($file,$integrity = null,$crossorigin=null){

		if(!empty($file)){
			if($integrity!=null){
				$i_t='integrity="'.$integrity.'"';
			}else{
				$i_t = '';
			}
			if($crossorigin!=null){
				$c_t='crossorigin="'.$crossorigin.'"';
			}else{
				$c_t = '';
			}

			 $css = '<link rel="stylesheet"  type="text/css" href="https:'.$file.'" '.$i_t.' '.$c_t.'>';
			 return $css;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($css), DON'T EXIST OR EMPTY");
			die;
		}

	}
	public static function httpsjs($file,$integrity = null,$crossorigin=null){

		if(!empty($file)){
			if($integrity!=null){
				$i_t='integrity="'.$integrity.'"';
			}else{
				$i_t = '';
			}
			if($crossorigin!=null){
				$c_t='crossorigin="'.$crossorigin.'"';
			}else{
				$c_t = '';
			}
			$js = '<script src="https:'.$file.'"  '.$i_t.' '.$c_t.'></script>';
			return $js;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($js), DON'T EXIST OR EMPTY");
			die;
		}

	}
	public static function js($file){
		$js= ROOT_ASSETS.'js'.DIR.$file;
		if(file_exists($js)){
			$js=URL_ASSETS.'js'.DIR.$file;
			$js = '<script type="text/javascript" src="'.$js.'"></script>';
			return $js;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($js), DON'T EXIST ");
			die;
		}
		
	}

	public static function font($file){
		$font=ROOT_ASSETS.'fonts'.DIR.$file;
		if(file_exists($font)){
			$font=URL_ASSETS.'fonts'.DIR.$file;
			$font = $font;
			return $font;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($font), DON'T EXIST ");
			die;
		}
		
	}

	public static function img($file,$width = null,$height = null,$style = null,$alt = ''){
		$img= ROOT_ASSETS.'img'.DIR.$file;

		if(file_exists($img)){
			$img= URL_ASSETS.'img'.DIR.$file;
			if($width && $height ==null && $style ==null){
				$img = '<img width="'.$width.'"  alt="'.$alt.'"  src="'.$img.'">';	
			}else if($width && $style ==null){
				$img = '<img width="'.$width.'" height="'.$height.'" alt="'.$alt.'" src="'.$img.'">';	
			}else if($width && $height && $style){
				$img ='<img width="'.$width.'" height="'.$height.'" alt="'.$alt.'" class="'.$style.'"  src="'.$img.'">';	
			}else{
				$img = '<img src="'.$img.'" class="'.$style.'" >';	
			}
			
			return $img;			
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($img), DON'T EXIST ");
			die;
		}
		
	}

	public static function httpimg($img,$width = null,$height = null,$style = null){

			if($width && $height ==null && $style ==null){
				$img = '<img width="'.$width.'" src="'.$img.'" alt="'.$alt.'">';	
			}else if($width  && $style ==null){
				$img = '<img width="'.$width.'" height="'.$height.'" src="'.$img.'" alt="'.$alt.'">';	
			}else if($width && $height && $style){
				$img ='<img width="'.$width.'" height="'.$height.'" class="'.$style.'"  src="'.$img.'" alt="'.$alt.'">';	
			}else{
				$img = '<img src="'.$img.'">';	
			}
		
			return $img;			
		
	}
	public static function plugins($file,$plugin='')
	{
		$plug=DIR_VENDOR.'/webroot/plugins'.DIR.$plugin.DIR.$file;
		if(file_exists($plug)){
			$ext = Document::getExt($file);

			if($ext == 'css'){
				$plugcss=URL_PLUGIN.DIR.$plugin.DIR.$file;
				$css = '<link rel="stylesheet" type="text/css" href="'.$plugcss.'">';
				return $css;	
			}else if($ext == 'js'){
				$plugjs=URL_ASSETS.'js'.DIR.$file;
				$js = '<script type="text/javascript" src="'.$plugjs.'"></script>';
				return $js;	
			}		
		}else{
		 	echo Error::display("ERROR......GENERETING FILE ($plug), DON'T EXIST ");
			die;
		}
	}
	public static function uploadFile($data, $path='', $arr_ext = array() )
    {

        //Kontrollojm nese eshte vendosur ne form uploadi ndonje objekt
        if(!empty($data['name'])):
            $file = $data;
            $key  = PREFIX;

            $ext = substr(strtolower(strrchr($file['name'], '.')), 1);

            if(in_array($ext, $arr_ext) OR empty($arr_ext) ):


                if(!is_dir($path) ):
                    mkdir($path, 0777, true);
                endif;

                if(file_exists($path.$file['name']) ):
                    $filename = explode('.', $file['name']);
                    $rename = Crypt::cryptFile($filename[0]);
                    $file['name'] = $key.$rename.".".$filename[1];

                endif;

                $filename = explode('.', $file['name']);
                $rename = Crypt::cryptFile($filename[0]);
                $file['name'] = $key.$rename.".".$filename[1];

                $folder = $path.basename($file['name']);


                move_uploaded_file($file['temp_name'], $folder);

                //Emri i file-it eshte gati per tu ruajtur ne db
                return $file['name'];
            endif;
        endif;



    }

}