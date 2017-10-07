<?php
namespace Go;
class Form
{

    public static function open($params = array())
    {
        $o = '<form';
        $o .= (isset($params['id']))        ? " id='{$params['id']}'"                       : '';
        $o .= (isset($params['name']))      ? " name='{$params['name']}'"                   : '';
        $o .= (isset($params['class']))     ? " class='{$params['class']}'"                 : '';
        $o .= (isset($params['onsubmit']))  ? " onsubmit='{$params['onsubmit']}'"           : '';
        $o .= (isset($params['method']))    ? " method='{$params['method']}'"               : ' method="post"';
        $o .= (isset($params['action']))    ? " action='{$params['action']}'"               : '';
        $o .= (isset($params['files']))     ? " enctype='multipart/form-data'"              : '';
        $o .= (isset($params['style']))     ? " style='{$params['style']}'"                 : '';
        $o .= (isset($params['role']))      ? " role='{$params['role']}'"                   : '';
        $o .= (isset($params['autocomplete'])) ? " autocomplete='{$params['autocomplete']}'" : '';
        $o .= '>';
        // Create a token and append the form name to the end of the token name (if provided).
        $o .= "\n<input type='hidden' name='csrfToken".ucwords($params['name'])."' value='".Csrf::makeToken('csrfToken'.ucwords($params['name']))."'>\n";
        return $o."\n";
    }

    public static function close()
    {
        return "</form>\n";
    }


    public static function textBox($params = array())
    {
        return self::textarea($params);
    }

    public static function textarea($params = array())
    {
        $o = '<textarea';
        $o .= (isset($params['id']))        ? " id='{$params['id']}'"                           : '';
        $o .= (isset($params['name']))      ? " name='{$params['name']}'"                       : '';
        $o .= (isset($params['class']))     ? " class='form-input textbox {$params['class']}'"  : '';
        $o .= (isset($params['onclick']))   ? " onclick='{$params['onclick']}'"                 : '';
        $o .= (isset($params['cols']))      ? " cols='{$params['cols']}'"                       : '';
        $o .= (isset($params['rows']))      ? " rows='{$params['rows']}'"                       : '';
        $o .= (isset($params['disabled']))  ? " disabled='{$params['disabled']}'"               : '';
        $o .= (isset($params['placeholder']))  ? " placeholder='{$params['placeholder']}'"      : '';
        $o .= (isset($params['maxlength']))     ? " maxlength='{$params['maxlength']}'"         : '';
        $o .= (isset($params['style']))     ? " style='{$params['style']}'"                     : '';
        $o .= (isset($params['required']))     ? " required='required'"                         : '';
        $o .= '>';
        $o .= (isset($params['value']))     ? $params['value']                                  : '';
        $o .= "</textarea>\n";
        return $o;
    }


    public static function input($params = array())
    {
        $o  = '<input ';
        $o .= (isset($params['type']))      ? " type='{$params['type']}'"                    : 'type="text"';
        $o .= (isset($params['id']))        ? " id='{$params['id']}'"                        : '';
        $o .= (isset($params['name']))      ? " name='{$params['name']}'"                    : '';
        $o .= (isset($params['class']))     ? " class='{$params['class']}'"                  : '';
        $o .= (isset($params['onclick']))   ? " onclick='{$params['onclick']}'"              : '';
        $o .= (isset($params['onkeypress']))? " onkeypress='{$params['onkeypress']}'"        : '';
        $o .= (isset($params['value']))     ? ' value="' . $params['value'] . '"'            : '';
        $o .= (isset($params['length']))    ? " maxlength='{$params['length']}'"             : '';
        $o .= (isset($params['width']))     ? " style='width:{$params['width']}px;'"         : '';
        $o .= (isset($params['disabled']))  ? " disabled='{$params['disabled']}'"            : '';
        $o .= (isset($params['placeholder']))  ? " placeholder='{$params['placeholder']}'"   : '';
        $o .= (isset($params['accept']))     ? " accept='{$params['accept']}'"               : '';
        $o .= (isset($params['maxlength']))     ? " maxlength='{$params['maxlength']}'"      : '';
        $o .= (isset($params['style']))     ? " style='{$params['style']}'"                  : '';
        $o .= (isset($params['required']))     ? " required='required'"                      : '';
        $o .= (isset($params['autocomplete'])) ? " autocomplete='{$params['autocomplete']}'" : '';
        $o .= (isset($params['autofocus'])) ? " autofocus"                                   : '';
        $o .= " />\n";
        return $o;
    }

    public static function select( $params = array() )
    {
        $o = "<select";
        $o .= (isset($params['id']))        ? " id='{$params['id']}'"                           : '';
        $o .= (isset($params['name']))      ? " name='{$params['name']}'"                       : '';
        $o .= (isset($params['class']))     ? " class='{$params['class']}'"                     : '';
        $o .= (isset($params['onclick']))   ? " onclick='{$params['onclick']}'"                 : '';
        $o .= (isset($params['width']))     ? " style='width:{$params['width']}px;'"            : '';
        $o .= (isset($params['required']))     ? " required='required'"                         : '';
        $o .= (isset($params['disabled']))  ? " disabled='{$params['disabled']}'"               : '';
        $o .= (isset($params['style']))     ? " style='{$params['style']}'"                     : '';
        $o .= ">\n";
        $o .= "<option value=''>Select</option>\n";
        if  (isset( $params['data'] ) && is_array( $params['data'] ) ):
            foreach ( $params['data'] as $k => $v ):
                if ( isset( $params['value'] ) && $params['value'] == $k ):
                    $o .= "<option value='{$k}' selected='selected'>{$v}</option>\n";
                else:
                    $o .= "<option value='{$k}'>{$v}</option>\n";
                endif;
            endforeach;
        endif;
        $o .= "</select>\n";
        return $o;
    }


    public static function checkbox( $params = array() )
    {
        $o = '';
        if ( !empty( $params ) ) {
            $x = 0;
            foreach ( $params as $k => $v ):
                $v['id'] = (isset($v['id']))        ? $v['id']                                          : "cb_id_{$x}_".rand(1000, 9999);
                $o .= "<input type='checkbox'";
                $o .= (isset($v['id']))             ? " id='{$v['id']}'"                                : '';
                $o .= (isset($v['name']))           ? " name='{$v['name']}'"                            : '';
                $o .= (isset($v['value']))          ? " value='{$v['value']}'"                          : '';
                $o .= (isset($v['class']))          ? " class='{$v['class']}'"                          : '';
                $o .= (isset($v['checked']))        ? " checked='checked'"                              : '';
                $o .= (isset($v['disabled']))       ? " disabled='{$v['disabled']}'"                    : '';
                $o .= (isset($params['style']))     ? " style='{$params['style']}'"                     : '';
                $o .= " />\n";
                $o .= (isset($v['label']))          ? "<label for='{$v['id']}'>{$v['label']}</label> "  : '';
                $x++;
            endforeach;
        endif;

        return $o;
    }


    public static function radio($params = array())
    {
        $o = '';
        if ( !empty( $params ) ):
            $x = 0;
            foreach ( $params as $k => $v ):
                $v['id'] = (isset($v['id']))        ? $v['id']                                          : "rd_id_{$x}_".rand(1000, 9999);
                $o .= "<input type='radio'";
                $o .= (isset($v['id']))             ? " id='{$v['id']}'"                                : '';
                $o .= (isset($v['name']))           ? " name='{$v['name']}'"                            : '';
                $o .= (isset($v['value']))          ? " value='{$v['value']}'"                          : '';
                $o .= (isset($v['class']))          ? " class='{$v['class']}'"                          : '';
                $o .= (isset($v['checked']))        ? " checked='checked'"                              : '';
                $o .= (isset($v['disabled']))       ? " disabled='{$v['disabled']}'"                    : '';
                $o .= (isset($params['style']))     ? " style='{$params['style']}'"                     : '';
                $o .= " />\n";
                $o .= (isset($v['label']))          ? "<label for='{$v['id']}'>{$v['label']}</label> "  : '';
                $x++;
            endforeach;
        endif;
        return $o;
    }

    public static function button($params = array())
    {
        $o = "<button type='submit'";
        $o .= (isset($params['id']))        ? " id='{$params['id']}'"                           : '';
        $o .= (isset($params['name']))      ? " name='{$params['name']}'"                       : '';
        $o .= (isset($params['class']))     ? " class='{$params['class']}'"                     : '';
        $o .= (isset($params['onclick']))   ? " onclick='{$params['onclick']}'"                 : '';
        $o .= (isset($params['disabled']))  ? " disabled='{$params['disabled']}'"               : '';
        $o .= (isset($params['style']))     ? " style='{$params['style']}'"                     : '';
        $o .= ">";
        $o .= (isset($params['iclass']))    ? "<i class='fa {$params['iclass']}'></i> "         : '';
        $o .= (isset($params['value']))     ? "{$params['value']}"                              : '';
        $o .= "</button>\n";
        return $o;
    }

    public static function submit($params = array())
    {
        $o = '<input type="submit"';
        $o .= (isset($params['id']))        ? " id='{$params['id']}'"                           : '';
        $o .= (isset($params['name']))      ? " name='{$params['name']}'"                       : '';
        $o .= (isset($params['class']))     ? " class='{$params['class']}'"                     : '';
        $o .= (isset($params['onclick']))   ? " onclick='{$params['onclick']}'"                 : '';
        $o .= (isset($params['value']))     ? " value='{$params['value']}'"                     : '';
        $o .= (isset($params['disabled']))  ? " disabled='{$params['disabled']}'"               : '';
        $o .= (isset($params['style']))     ? " style='{$params['style']}'"                     : '';
        $o .= " />\n";
        return $o;
    }


    public static function hidden($params = array())
    {
        $o = '<input type="hidden"';
        $o .= (isset($params['id']))        ? " id='{$params['id']}'"                           : '';
        $o .= (isset($params['name']))      ? " name='{$params['name']}'"                       : '';
        $o .= (isset($params['class']))     ? " class='{$params['class']}'"                     : '';
        $o .= (isset($params['value']))     ? " value='{$params['value']}'"                     : '';
        $o .= " />\n";
        return $o;
    }
}
