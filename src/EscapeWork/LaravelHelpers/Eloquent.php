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
    public static function HTMLOptions( $id, $field = 'title' )
    {
        $all  = static::all();
        $html = '';

        foreach( $all as $item )
        {
            $html .= '<option value="'.$item->id.'">'.$item->$field.'</option>';
        }

        return $html;
    }
}