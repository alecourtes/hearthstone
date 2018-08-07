<?php

namespace App\Utils;

class Stringifier
{
    public function __construct()
    {
    }

    public function toLower($string)
    {
        $key = $string;
        $string = trim($string);

        if (count($string) > 0) {

            $string = str_replace('œ', 'oe', $string);
            $string = str_replace('™', '', $string);
            $string = str_replace('∗', '*', $string);
            $output = strtr($string, 'ÄÂÀÁÅÃÉÈËÊÒÓÔÕÖØÌÍÎÏÙÚÛÜÝÑÇÞÝÆŒÐØ', 'äâàáåãéèëêòóôõöøìíîïùúûüýñçþÿæœðø');
            $output = str_replace('â', 'a', $output);
            $output = trim(strtolower(utf8_decode($output)));

            return utf8_encode($output);
        }

        return false;
    }

    public function slug($string)
    {
        $string = trim($string);
        $slug = mb_strtolower(static::removeDiacritics(static::nbsp2bsp($string)));
        $slug = preg_replace("/[^a-zA-Z0-9 ]/", " ", $slug);
        $slug = str_replace(" ", "_", $slug);
        $slug = str_replace("-", "_", $slug);
        $slug = str_replace("--", "_", $slug);

        return $slug;
    }

    public function removeDiacritics($text)
    {
        $text = str_replace('œ', 'oe', $text);

        return strtr(
            utf8_decode($text),
            utf8_decode(
                'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ'
            ),
            'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn'
        );
    }

    public function nbsp2bsp($unicode, $taco = true)
    {
        $bug = array(
            "&#38;#60;",
            "&#38;#62;",
            "&#160;",
            "&#38;",
            "&#60;",
            "&#62;",
            "&#224;",
            "&#233;",
            "&#39;",
            "&#176;",
            "&#216;",
            "&#232;",
            "&#234;",
            "&#238;",
            "&#231;",
            "&#244;",
            "&#201;",
            "&#251;",
            "&#178;"
        );
        $fix = array("<", '>', " ", "&", "<;", ">", "à", "é", "'", "°", "Ø", "è", "ê", "î", "ç", "ô", "É", "û", "²");

        $new = str_replace($bug, $fix, $unicode);
        $new = str_replace(utf8_encode(html_entity_decode('&#160;')), ' ', $new);

        if ($taco) {
            $taco = array("&", "<", ">");
            $tacofix = array("&#38;", "#60;", "#62;");
            $new = str_replace($taco, $tacofix, $new);
        }

        return $new;
    }
}