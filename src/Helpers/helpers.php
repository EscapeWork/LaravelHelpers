<?php
/**
 * Funções para otimizar códigos no Laravel
 */

/**
 * Retornando timestamp a partir do formato em $formatFrom
 * @param  string $timestamp  timestamp não formatado
 * @param  string $formatFrom formato do timestamp em $timestamp. Default 'd/m/Y H:i'
 * @param  string $formatFor  formato de saída do timestamp. Default 'Y-m-d H:i'
 *
 * @return timestamp  formato timestamp aceito no banco
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function to_timestamp($timestamp = null, $formatFrom = 'd/m/Y H:i', $formatFor = 'Y-m-d H:i')
{
    if ($timestamp == null or empty($timestamp)) {
        return null;
    }

    $dateTime = DateTime::createFromFormat($formatFrom, $timestamp);
    if (! $dateTime) {
        return null;
    }

    return $dateTime->format($formatFor);
}


/**
 * Formatando um timestamp para formato em $format
 * @param  timestamp $datetime
 * @param  string $format   formato da string de retorno
 *
 * @return string           string formatado
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function to_char($datetime, $formatFrom = 'Y-m-d H:i', $formatFor = 'd/m/Y H:i')
{
    if ($datetime == null or empty($datetime)) {
        return null;
    }

    if (! $dateTime = DateTime::createFromFormat($formatFrom, $datetime)) {
        return null;
    }

    return $dateTime->format($formatFor);

}



/**
 * Formatando uma string de tempo para real
 * @param  string $value
 * @return real
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function time_to_real($value = null)
{
    if (is_null($value)) {
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
function real_to_time($value = null)
{
    if (is_null($value)) {
        return null;
    }

    $hora = intval($value);
    $hora = $hora < 10 ? '0' . $hora : $hora;

    $minuto = round(($value - $hora) * 60);
    $minuto = $minuto < 10 ? '0' . $minuto : $minuto;

    return $hora . ':' . $minuto;
}


/**
 * Formatando um valor formatado para um valor `real`/`float`
 * @param   string $char valor não float
 * @param   string $dec_point string separadora de decimal
 * @param   string $thousands_sep string separadora de milhares
 *
 * @return  float
 * @author  Eduardo Kasper <eduardo@escape.ppg.br>
 */
function char_to_real($char, $dec_point = ',', $thousands_sep = '.')
{
    if ($char == null or empty($char)) {
        return null;
    }

    $char = str_replace($thousands_sep, null, $char);
    $char = str_replace($dec_point, '.', $char);

    return (float) $char;
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
function truncate($value, $limit, $start = 0)
{
    $size = strlen($value);

    return rtrim(mb_substr($value, $start, $limit, 'UTF-8')) . ($size > $limit ? '...' : null);
}
