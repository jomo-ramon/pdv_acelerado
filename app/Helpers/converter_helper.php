<?php


function convert_date_to_br(string $date){
    $format = explode("/", $date);
    $result = "{$format[2]}-{$format[1]}-{$format[0]}";
    return $result;
}