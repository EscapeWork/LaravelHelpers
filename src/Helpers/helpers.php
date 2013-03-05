<?php
/**
 * Funções para otimizar códigos no Laravel
 */

/**
 * Escrevendo valor de $value em um var_dump e terminando a execução
 * @param  mixed $value valor a ser dumpado
 * @return void
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    die;
}

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
    if( $timestamp === null )
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
    if( $datetime === null )
    {
        return null;
    }

    return (new DateTime($datetime))->format($format);
}



/**
 * Formatando uma string de tempo para real
 * @param  string $value
 * @return real           
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function time_to_real($value)
{
    if( $value === null )
    {
        return null;
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
    if( $value === null )
    {
        return null;
    }

    $hora = intval($value);
    $hora = $hora < 10 ? '0' . $hora : $hora;

    $minuto = round(($value - $hora) * 60);
    $minuto = $minuto < 10 ? '0' . $minuto : $minuto;

    return $hora . ':' . $minuto;
}
