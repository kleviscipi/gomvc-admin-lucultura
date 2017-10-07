<?php
namespace Go;

class Document
{


    public static function getFileType($extension)
    {
        $images = array('jpg', 'gif', 'png', 'bmp');
        $docs   = array('txt', 'rtf', 'doc', 'docx', 'pdf');
        $apps   = array('zip', 'rar', 'exe', 'html');
        $video  = array('mpg', 'wmv', 'avi', 'mp4');
        $audio  = array('wav', 'mp3');
        $db     = array('sql', 'csv', 'xls','xlsx');

        if (in_array($extension, $images)):
            return "Image";
        endif;
        if (in_array($extension, $docs)):
            return "Document";
        endif;
        if (in_array($extension, $apps)):
            return "Application";
        endif;
        if (in_array($extension, $video)):
            return "Video";
        endif;
        if (in_array($extension, $audio)):
            return "Audio";
        endif;
        if (in_array($extension, $db)):
            return "Database/Spreadsheet";
        endif;

        return "Other";
    }

    public static function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public static function getBytesSize( $value )
    {
        return preg_replace_callback('/^\s*(\d+)\s*(?:([kmgt]?)b?)?\s*$/i', function ($m) {
            switch (strtolower($m[2])):
                case 't':
                    $m[1] *= 1024;
                    break;
                case 'g':
                    $m[1] *= 1024;
                    break;
                case 'm':
                    $m[1] *= 1024;
                    break;
                case 'k':
                    $m[1] *= 1024;
                    break;
            endswitch;
            return $m[1];
        }, $value);
    }

    public static function getFolderSize( $path )
    {
        $io = popen('/usr/bin/du -sb '.$path, 'r');
        $size = intval(fgets($io, 80));
        pclose($io);
        return $size;
    }

    public static function getExt( $file )
    {
        $getext = pathinfo( $file, PATHINFO_EXTENSION );
        return $getext;
    }

    public static function removeExt( $file )
    {
        if ( strpos( $file, '.' ) ):
            $file = pathinfo($file, PATHINFO_FILENAME);
        endif;
        return $file;
    }
}
