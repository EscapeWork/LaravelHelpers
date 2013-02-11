<?php namespace EscapeWork\LaravelHelpers;

use Illuminate\Database\Eloquent\Model as Model;

class Eloquent extends Model
{
    # regras de validações
    public static $validationRules = array();

    # mensagens das validações
    public static $validationMessages = array();

    # mensagens das validações
    public static $messages;

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

}