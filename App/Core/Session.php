<?php
namespace Go;
use Go\Error as Error;

class Session
{

    private static $sessionStarted = false;


    public static function init()
    {
        if ( static::$sessionStarted == false ):
            static::$sessionStarted = true;

            // Start the native PHP Session.
            session_start();
        endif;
    }


    public static function exists( $key )
    {
        return isset( $_SESSION[ PREFIX .$key ] );
    }


    public static function set( $key, $value = false )
    {

        if ( is_array( $key ) && $value === false ):
            foreach ( $key as $name => $value ):
                $_SESSION[ PREFIX.$name ] = $value;
            endforeach;
        else:
            $_SESSION[PREFIX.$key] = $value;
        endif;
    }

    public static function pull( $key )
    {
        if ( isset( $_SESSION[ PREFIX.$key ] ) ):
            $value = $_SESSION[ PREFIX.$key ];
            unset( $_SESSION[ PREFIX.$key ] );
            return $value;
        endif;
        return null;
    }

    public static function get( $key, $secondkey = false )
    {
        if ($secondkey == true):
            if ( isset( $_SESSION[ PREFIX.$key ][ $secondkey ] ) ):
                return $_SESSION[PREFIX.$key][$secondkey];
            endif;
        else:
            if ( isset( $_SESSION[ PREFIX.$key ] ) ):
                return $_SESSION[ PREFIX.$key ];
            endif;
        endif;
        return null;
    }

    public static function id()
    {
        return session_id();
    }

    public static function regenerate()
    {
        session_regenerate_id(true);

        return session_id();
    }


    public static function display()
    {
        return $_SESSION;
    }

    public static function destroy( $key = '', $prefix = false )
    {
        // Only run if the session has started.
        if ( static::$sessionStarted == true ):
            // If the key is empty and the $prefix is false.
            if ($key =='' && $prefix == false):
                session_unset();
                session_destroy();
            elseif ($prefix == true):
                // Clear all the session for set PREFIX
                foreach ($_SESSION as $key => $value):
                    if ( strpos( $key, PREFIX) === 0 ):
                        unset($_SESSION[$key]);
                    endif;
                endforeach;
            else:
                // Clear the specified session key.
                unset($_SESSION[PREFIX.$key]);
            endif;
        endif;
    }

    public static function GoFlash( $name = '', $message = '', $type = 'flash_success' )
    {
        //We can only do something if the name isn't empty
        if( !empty( $name ) ):
            //No message, create it
            if( !empty( $message ) && empty( $_SESSION[$name] ) ):

                if( !empty( $_SESSION[$name] ) ):
                    unset( $_SESSION[$name] );
                endif;

                if( !empty( $_SESSION[$name.'_class'] ) ):
                    unset( $_SESSION[$name.'_class'] );
                endif;

                $_SESSION[$name] = $message;
                $_SESSION[$name.'_class'] = $type;

            //Message exists, display it
            elseif( !empty( $_SESSION[$name] ) && empty( $message ) ):
                $type = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'flash_success';
                $message = $_SESSION[$name];
                $file = $_SERVER['DOCUMENT_ROOT'].'/App/Src/Views' . DIR . 'Elements'. DIR . $type.'.ctp';
             
                if(file_exists($file)){
                    require $file;

                    unset($_SESSION[$name]);
                    unset($_SESSION[$name.'_class']);
                }else{
                    Error::display('Il file non esiste: $file');
                    
                }

               
            endif;
        endif;
    }
}
