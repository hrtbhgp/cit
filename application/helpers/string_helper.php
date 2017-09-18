<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function getValueInsideString(
    $value,
    $init,
    $end)
{
    $beginFind = explode($init, $value, 2)[1];
    $endFind = explode($end, $beginFind, 2)[0];
    return preg_replace('/'. preg_quote($end, '/') .'$/', '', $endFind);
}