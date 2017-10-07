<?php 
namespace Go;

class Link

{
	public static function autoLink( $text, $custom = null,$type=[])
    {
        $regex   = '@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@';
        if(!empty($type)){
    	     foreach ($type as $key => $value) {
   				$type['all'] .=  $key.'='."'$type[$key]'" . " ";
			 }
        }
        if ( $custom === null ):

            $replace = '<a href="http$2://$4" '.$type['all'].'>$1$2$3$4</a>';
        else:
            $replace = '<a href="http$2://$4" '.$type['all'].'>'.$custom.'</a>';
        endif;

        return preg_replace($regex, $replace, $text);
    }
    public static function thisLink( $text,$custom=null,$type=[])
    {
        if(!empty($type)){
             foreach ($type as $key => $value) {
                $type['all'] .=  $key.'='."'$type[$key]'"." ";
             }
        }else{
            $type['all']=" ";
        }
        if ( $custom === null ):
            $replace = '<a href='.$text.' '.$type['all'].'>'.$text.'</a>';
        else:
            $replace = '<a href='.$text.' '.$type['all'].'>'.$custom.'</a>';
        endif;
        return $replace;
    }
    
    public static function generateSafeSlug( $slug )
    {
        setlocale(LC_ALL, "en_US.utf8");

        $slug = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));

        $slug = htmlentities($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $slug = preg_replace($pattern, '$1', $slug);

        $slug = html_entity_decode($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~[^0-9a-z]+~i';
        $slug = preg_replace($pattern, '-', $slug);

        return strtolower(trim($slug, '-'));
    }

    public static function segments()
    {
        return explode('/', $_SERVER['REQUEST_URI']);
    }


    public static function getSegment($segments, $id)
    {
        if ( array_key_exists( $id, $segments ) ):
            return $segments[ $id ];

        endif;
    }

 
    public static function lastSegment( $segments )
    {
        return end( $segments );
    }


    public static function firstSegment( $segments )
    {
        return $segments[0];
    }

            // $oldlink = base64_encode($_SERVER['PATH_INFO']);
            // Url::redirectTo('/Admin/login?oldlink='.$oldlink);
    public static function redirect( $url = null, $fullPath = false, $code = 302 )
    {
        $url = ( $fullPath === false ) ? $url : site_url($url);
        throw new RedirectToException( $url, $code );
    }

    public static function redirectTo( $url = null )
    {

        header("Location: $url");
        exit();
    }

    public static function validLink($url)
    {
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) {
            return Error::display('Invalid Url');
        }else{
            return $url;
        } 
    }

    public static function detectUri()
    {
            $requestUri = $_SERVER['REQUEST_URI'];
            $scriptName = $_SERVER['SCRIPT_NAME'];

            $pathName = dirname( $scriptName );

            if ( strpos( $requestUri, $scriptName) === 0 ):
                $requestUri = substr($requestUri, strlen($scriptName));
            elseif ( strpos( $requestUri, $pathName ) === 0 ):
                $requestUri = substr( $requestUri, strlen( $pathName ) );
            endif;

            $uri = parse_url( ltrim( $requestUri, '/' ), PHP_URL_PATH );

            if ( !empty( $uri ) ):
                return str_replace(array('//', '../'), '/', $uri);
            endif;

        // Empty URI of homepage; internally encoded as '/'
        return '/';
    }


}
?>