<?php

namespace App\Utils;

use Illuminate\Support\Str;

final class StringFormatter
{
    public static function removeAcutes(String $string)
    {
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string,
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $string
        );

        return $string;
    }

    public static function arrayKeysToSnakeCase(array $input)
    {
        $output = [];

        foreach ($input as $key => $value) {
            $output[Str::snake($key)] = $value;
        }

        return $output;
    }

    public static function arrayValuesToSnakeCase(array $input)
    {
        return collect($input)->map(function ($value) {
            return Str::snake($value);
        })->toArray();
    }
    public static function hideCharacters(String $string, int $startVisibleChars, int $endVisibleChars)
    { 
        if (strlen($string) < $startVisibleChars + $endVisibleChars){
            return $string;
        } 
        (!empty($string)) ? $return = substr($string, 0, $startVisibleChars) . str_repeat("*", strlen($string) - $startVisibleChars - $endVisibleChars)  . substr($string, - $endVisibleChars, $endVisibleChars) : $return = null;
        return $return;
    }
}
