<?php
/**
 * Funções para otimizar códigos no Laravel
 */


/**
 * Escrevendo valor de $value em um var_dump
 * @param  mixed $value valor a ser dumpado
 * @return void
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function d($value)
{
    echo "<pre>";
    var_dump($value);
}

/**
 * Retornando timestamp a partir do formato em $formatFrom
 * @param  string $timestamp  timestamp não formatado
 * @param  string $formatFrom formato do timestamp em $timestamp. Default 'd/m/Y H:i'
 * @return timestamp  formato timestamp aceito no banco
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function to_timestamp($timestamp, $formatFrom = 'd/m/Y H:i')
{
    if( $timestamp === null or $timestamp == null )
    {
        return null;
    }

    return DateTime::createFromFormat($formatFrom, $timestamp)->format('Y-m-d H:i');
}


/**
 * Formatando um timestamp para formato em $format
 * @param  timestamp $datetime 
 * @param  string $format   formato da string de retorno
 * @return string           string formatado
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function to_char($datetime, $format = 'd/m/Y H:i')
{
    if( $datetime === null or $datetime == null )
    {
        return null;
    }

    $dateTime = new DateTime($datetime);
    return $dateTime->format($format);
}



/**
 * Formatando uma string de tempo para real
 * @param  string $value
 * @return real           
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function time_to_real($value)
{
    if( $value === null or $value == null )
    {
        return null;
    }

    if (strpos($value, ':') === false) {
        return $value; 
    }

    $value   = explode(':', $value);
    $hora    = $value[0];
    $minutos = $value[1];

    return round($hora + $minutos / 60, 2);
}


/**
 * Formatando um valor real para ser tempo
 * @param   float $value
 * @return  string           
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function real_to_time($value)
{
    if( $value === null or $value == null )
    {
        return null;
    }

    $hora = intval($value);
    $hora = $hora < 10 ? '0' . $hora : $hora;

    $minuto = round(($value - $hora) * 60);
    $minuto = $minuto < 10 ? '0' . $minuto : $minuto;

    return $hora . ':' . $minuto;
}

/**
 * Formating and array keys by a specific field
 *
 * @param   array  $items
 * @param   string $key [default=id]
 * @return  array
 */
function formatArrayKeysByField($items = array(), $field = 'id')
{
    $newArray = array();

    foreach ($items as $item) {
        $newArray[$item[$field]] = $item;
    }

    return $newArray;
}


/**
 * Truncating string
 *
 * @param   string $value
 * @param   int    $limit number to truncate
 * @return  string
 */
function truncate($value, $limit)
{
    return rtrim(substr($value, 0, $limit)) . "...";
}
