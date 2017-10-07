<?php

class

{
    public function uploadFile( $data, $path='', $arr_ext = array() )
    {

        //Kontrollojm nese eshte vendosur ne form uploadi ndonje objekt
        if( !empty( $data['name'] ) ):
            $file = $data; //vendosim te dhenat ne kete variable per perdorim te thjesht

            $ext = substr( strtolower( strrchr( $file['name'], '.') ), 1 ); //marrim extensionin

            //processi eshte i vlefshem vetem nese kemi extension te pranueshem:
            if( in_array( $ext, $arr_ext ) OR empty( $arr_ext ) ):
                //do the actual uploading of the file. First arg is the tmp name, second arg is

                //vendi ku ruajm filet e ngarkuara:
//                $path = WWW_ROOT . 'img'.DS.'uploads'.DS.$this->modelClass.'/';
                //kontrollojm nese ekziston direktoria/ nese jo e krijojm:
                if( !is_dir( $path ) ):
                    mkdir( $path, 0777, true );
                endif;

                //Kontrollojm nese ekziston nje file me te njejtin emer ne te njejten direktori:
                //nese ekziston ateher e riemerojm:
                if( file_exists( $path.$file['name'] ) ):

                    $filename_arr = explode( '.', $file['name'] );
                    array_pop( $filename_arr ); // heqim extensionin

                    $filename = implode('.', $filename_arr ); //i ngjisim pjeset prap nese ka pas pika dhe pergjat emrit

                    $filaname_arr = explode('-', $filename ); // indekset e fileve i kemi emrifileit-{index}.ext
                    $index = end( $filename_arr ); //marrim pjesen e fundit per te verifikuar indexin

                    //kontrollojm nese eshte numerik:
                    if( is_numeric( $index ) ):
                        //Nese eshte numerik e marrim per index dhe e inkrementojm me nji :
                        $index++;
                        //Nderkoh duhet te zevendesojm dhe index-in tek emri i file-it:
                        array_pop($filename_arr); // e heqim pjesen fundore
                    else:
                        $index= 1;
                    endif;
                    $filename = implode('-', $filename_arr);
                    $this->nextName($path, $filename,$ext, $index);
                    $file['name'] = $filename;
                endif;

//                debug($file);
//                debug($path. $file['name']);

                move_uploaded_file($file['tmp_name'],  $path. $file['name']);

                //Emri i file-it eshte gati per tu ruajtur ne db
                return $file['name'];
            endif;
        endif;

        return false;

    }

    public function nextName( $path, &$name, $ext, $index='' )
    {
        if( is_numeric($index) ):
            if( file_exists( $path.$name.'-'.$index.'.'.$ext ) ):
                $index++;
                $this->nextName($path, $name,$ext, $index);
            else:
                $name = $name.'-'.$index.'.'.$ext;
                return $name;
            endif;
        else:

            $this->nextName($path, $name,$ext, 1);

        endif;

    }
}
