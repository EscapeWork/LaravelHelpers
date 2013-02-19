<?php namespace EscapeWork\LaravelHelpers;

use Illuminate\Database\Eloquent\Model as Model;
use \Validator;

class Eloquent extends Model
{
    # regras de validações
    public static $validationRules = array();

    # mensagens das validações
    public static $validationMessages = array();

    # mensagens das validações
    public static $messages = array();

    /**
     * Método de valicação
     */
    public static function validate( $fields )
    {
        $validation = Validator::make( $fields, static::$validationRules, static::$validationMessages );

        if( $validation->fails() )
        {
            static::$messages = $validation->messages()->getMessages();
            
            return false;
        }

        return true;
    }

    /**
     * putting data in a Object and returning it
     *
     * @static
     * @param  array  $data 
     * @return Object
     */
    public static function getDataFromArray(array $data)
    {
        $class = get_called_class();

        $object = new $class;

        foreach( $data as $attribute => $value )
        {
            $object->$attribute = $value;
        }

        return $object;
    }

    /**
     * Gerando um HTML Select com TODAS as opções
     *
     * @access  public 
     * @param   $id    int [com o ID atual]
     * @return  string [HTML Select]
     */
    public static function HTMLOptions( $id = null, $field = 'title' )
    {
        $all  = static::all();
        $html = '';

        foreach( $all as $item )
        {
            $html .= '<option value="'.$item->id.'" '.( $id == $item->id ? 'selected="selected"' : null ).'>'.$item->$field.'</option>';
        }

        return $html;
    }

    public function formatSlug( $update = false, $title = 'title', $slug = 'slug' )
    {
        $count       = 0;
        $this->$slug = static::formatString( $this->$title );

        while( !is_null( $object = static::where($slug, '=', $this->$slug)->first() ) )
        {
            $count++;

            $this->$slug = static::formatString( $this->$title . '-' . $count );
        }
    }

    /**
     * Formatando o slug
     */
    public static function formatString( $string, $enc = 'UTF-8' )
    {
        $acentos = array(
            'a' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
            'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
            'c' => '/&Ccedil;/',
            'c' => '/&ccedil;/',
            'e' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
            'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
            'i' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
            'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
            'n' => '/&Ntilde;/',
            'n' => '/&ntilde;/',
            'o' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
            'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
            'u' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
            'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
            'y' => '/&Yacute;|&Yuml;/',
            'y' => '/&yacute;|&yuml;/'
        );

        $especiais = array('/', '\\', '|', '*', ':', '[', ']', '{', '}', "'", '"', ',', '%', '@', '&', '(', ')', '¬', '#', '!', '?', 'ª', 'º', '¨', '°', '.');
        
        $string = str_replace($especiais, '', $string);
        $string = preg_replace($acentos, array_keys($acentos), htmlentities($string, ENT_NOQUOTES, $enc));
        $string = trim( $string );
        $string = str_replace(' ', '-', $string);
        $string = str_replace('---', '-', str_replace(' ', '-', $string));
        $string = str_replace('_', '-', str_replace('--', '-', $string));
        $string = mb_strtolower($string, $enc);
        $string = preg_replace($acentos, array_keys($acentos), $string);

        return $string;
    }
}