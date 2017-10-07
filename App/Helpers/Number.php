<?php

class Number
{

    public static function format($number, $prefix = '4')
    {
        // Remove any spaces in the number.
        $number = str_replace(" ", "", $number);
        $number = trim($number);

        // Make sure the number is actually a number.
        if ( is_numeric( $number ) ):
            // If the number doesn't start with a 0 or a $prefix, add a 0 to the start.
            if ( $number[0] != 0 && $number[0] != $prefix ):
                $number = "0".$number;
            endif;

            // If the number starts with a 0, replace it with a $prefix.
            if( $number[0] == 0 ):
                $number[0] = str_replace("0", $prefix, $number[0]);
                $number = $prefix.$number;
            endif;

            // Return the number.
            return $number;

        // The number is not a number.
        else:
            // Return nothing
            return false;
        endif;
    }


    public static function percentage( $val1, $val2 )
    {
        if ( $val1 > 0 && $val2 > 0 ):
            $division = $val1 / $val2;
            $res = $division * 100;
            return round($res).'%';
        else:
            return '0%';
        endif;
    }

    /**
     * returns the human readable size
     */
    public static function humanSize($bytes, $decimals = 2)
    {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');

        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
