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

    /**
     * Formatando o slug
     */
    public static function formatSlug( $var, $removerPonto = true, $enc = 'UTF-8' )
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
        
        $var = str_replace($especiais, '', $var);
        $var = preg_replace($acentos, array_keys($acentos), htmlentities($var, ENT_NOQUOTES, $enc));
        $var = trim( $var );
        $var = str_replace(' ', '-', $var);
        $var = str_replace('---', '-', str_replace(' ', '-', $var));
        $var = str_replace('_', '-', str_replace('--', '-', $var));
        $var = mb_strtolower($var, $enc);
        $var = preg_replace($acentos, array_keys($acentos), $var);

        return $var;
    }
}