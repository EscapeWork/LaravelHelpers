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
    $value   = explode(':', $value);
    $hora    = $value[0];
    $minutos = $value[1];

    return (float)($hora + ($minutos /60));
}


/**
 * Formatando um valor real para ser tempo
 * @param   float $value
 * @return  string           
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function real_to_time($value)
{
    $hora = intval($value);
    $minuto = $value - $hora;

    return ($hora < 10 ? '0' + $hora : $hora) . ':' . ($minuto * 60);
}
