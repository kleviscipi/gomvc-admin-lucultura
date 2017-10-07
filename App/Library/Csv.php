<?php
namespace Go; 
use Go\Error as Error;

class Csv
{	

	public static $file;
	public static $csv_line = [];
	public static $folder = "Files/csv/";

	public static function csv_url($f){
		return DIR_VENDOR.DIR.static::$folder.$f;
	}

	public static function csvGet($file)
	{	
		static::$file = $file;
		$thatfile =static::csv_url(static::$file);

		$fopen = fopen($thatfile,'r') or die(Error::display('Can\'t open the file: '.$file));
		
		while(!feof($fopen)){

		$line = fgets($fopen);
		$delimiter = static::delimiter($line)->delimiter;
		static::$csv_line[] = explode($delimiter,$line);

		}
		fclose($fopen);

		return (object)   static::$csv_line;
	}

	public static function delimiter($line){

		$thatline = explode(';',$line);
			$return['delimiter'] = ";";
			if(count($thatline) > 1) return (object) $return;
		$thatline = explode(',',$line);
			$return['delimiter'] = ",";
			if(count($thatline) > 1) return (object) $return;
		$thatline = explode(':',$line);
			$return['delimiter'] = ":";
			if(count($thatline) > 1) return (object) $return;
		$thatline = explode('|',$line);
			$return['delimiter'] = "|";
			if(count($thatline) > 1) return (object) $return;
	}

	public static function csvPut($file,$string = [],$type=null){
		static::$file = $file;
		$thatfile =static::csv_url(static::$file);

		if(!file_exists(DIR_VENDOR.DIR.static::$folder)){

			mkdir(DIR_VENDOR.DIR.static::$folder,0777);
		}

		if(empty($type)) $type = "w";

		$fput = fopen($thatfile,$type) or die(Error::display('Cant\'open file'.$thatfile . " " . $type));
		foreach ($string as $key => $value) {
			fwrite($fput, $value.":");		
		}
		fclose($fput);

		return true;
	}

	public static function download($string = [],$type=null){

	    ob_end_clean();
	    header( 'Content-Type: text/csv' );
	    header( 'Content-Disposition: attachment;filename=pedidos.csv');
	    $fp = fopen('php://output', 'w');
	    $headrow = $string;
	    fputcsv($fp, array_keys($headrow));
	    foreach ($result as $data) {
	        fputcsv($fp, $data);
	    }
	    fclose($fp);
	    $contLength = ob_get_length();
	    header( 'Content-Length: '.$contLength);  
	    die();
	}
}

