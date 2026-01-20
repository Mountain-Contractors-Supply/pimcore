<?php

declare(strict_types=1);

namespace App\Website\Tool;

use InvalidArgumentException;

class Text
{
    public static function replaceInvalidKeyCharacters(string $string, string $replace = ' & '): string
    {
        return (string)preg_replace('/(\s*\/\s*)+/', $replace, $string);
    }

    /**
     * @throws InvalidArgumentException If the phone number cannot be formatted
     */
    public static function formatPhone(string $phone): string
    {
        $digits = (string)preg_replace('/\D/', '', $phone);

        if (strlen($digits) < 10) {
            throw new InvalidArgumentException('Phone number must contain at least 10 digits');
        }

        $digits = substr($digits, 0, 10);

        return sprintf(
            '(%s) %s-%s',
            substr($digits, 0, 3),
            substr($digits, 3, 3),
            substr($digits, 6, 4)
        );
    }

    public static function cutStringRespectingWhitespace(string $string, int $length): string
    {
        if ($length < strlen($string)) {
            $text = substr($string, 0, $length);

            if (false !== ($length = strrpos($text, ' '))) {
                $text = substr($text, 0, $length);
            }
            $string = $text.'...';
        }

        return $string;
    }

    public static function toUrl(string $text): string
    {
        //$text = \Pimcore\Tool\Transliteration::toASCII($text);

        $search = ['?', '\'', '"', '/', '-', '+', '.', ',', ';', '(', ')', ' ', '&', 'ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü', 'ß', 'É', 'é', 'È', 'è', 'Ê', 'ê', 'E', 'e', 'Ë', 'ë',
            'À', 'à', 'Á', 'á', 'Å', 'å', 'a', 'Â', 'â', 'Ã', 'ã', 'ª', 'Æ', 'æ', 'C', 'c', 'Ç', 'ç', 'C', 'c', 'Í', 'í', 'Ì', 'ì', 'Î', 'î', 'Ï', 'ï',
            'Ó', 'ó', 'Ò', 'ò', 'Ô', 'ô', 'º', 'Õ', 'õ', 'Œ', 'O', 'o', 'Ø', 'ø', 'Ú', 'ú', 'Ù', 'ù', 'Û', 'û', 'U', 'u', 'U', 'u', 'Š', 'š', 'S', 's',
            'Ž', 'ž', 'Z', 'z', 'Z', 'z', 'L', 'l', 'N', 'n', 'Ñ', 'ñ', '¡', '¿',  'Ÿ', 'ÿ', '_', ':', '®', '™', '%'];
        $replace = ['', '-', '', '-', '-', '', '', '-', '-', '', '', '-', '', 'ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e',
            'A', 'a', 'A', 'a', 'A', 'a', 'a', 'A', 'a', 'A', 'a', 'a', 'AE', 'ae', 'C', 'c', 'C', 'c', 'C', 'c', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i',
            'O', 'o', 'O', 'o', 'O', 'o', 'o', 'O', 'o', 'OE', 'O', 'o', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'S', 's', 'S', 's',
            'Z', 'z', 'Z', 'z', 'Z', 'z', 'L', 'l', 'N', 'n', 'N', 'n', '', '', 'Y', 'y', '-', '-', '', '', ''];

        return urlencode(trim((string)preg_replace('/-+/', '-', strtolower(str_replace($search, $replace, $text))), '-'));
    }
}
