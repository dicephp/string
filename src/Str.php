<?php

namespace Dice\Types;

/**
 * Str: A near-natural Ruby-like String Implementation
 *
 * @property-read string activeString Returns the active string of the object
 * @property-read string activeText Same as 'activeString'
 * @property-read string originalString The original string with which the object was created
 */
class Str implements ICast
{
    /**
     * @var String Original text with which the class was created
     */
    protected $originalText;

    /**
     * @var String Active value, used for chaining
     */
    protected $activeText;

    /**
     * Encoding of the string. Assume that it is UTF-8
     * @var string
     */
    protected $encoding = 'UTF-8';

    /**
     * Str constructor.
     * @param String $origText Original text with which the object is to be constructed
     */
    public function __construct($origText)
    {
        $this->originalText = $origText;
        $this->activeText = $origText;
    }

    /**
     * Static form of constructor
     * @param String $origText
     * @return Str
     */
    public static function create($origText)
    {
        $str = new Str($origText);
        return $str;
    }

    /**
     * String representation of the object
     * @return String returns the active text
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return int Length of the string
     */
    public function length()
    {
        return strlen($this->activeText);
    }

    /**
     * Runs `ltrim()` on the string
     * @return $this
     */
    public function ltrim()
    {
        $this->activeText = ltrim($this->activeText);
        return $this;
    }

    /**
     * Runs `rtrim()` on the string
     * @return $this
     */
    public function rtrim()
    {
        $this->activeText = rtrim($this->activeText);
        return $this;
    }

    /**
     * Runs `trim()` on the string
     * @return $this
     */
    public function trim()
    {
        $this->activeText = trim($this->activeText);
        return $this;
    }

    /**
     * Alias of `trim()` without the optional character_mask argument
     * @return Str
     */
    public function strip()
    {
        // This is only a wrapper method
        return $this->trim();
    }

    /**
     * Returns lines in the string (split by "\n")
     * @return array Lines in the string
     */
    public function lines()
    {
        return explode("\n", $this->activeText);
    }

    /**
     * Resets the active text to the original text which was used when creating this String object
     * @return $this
     */
    public function reset()
    {
        $this->activeText = $this->originalText;
        return $this;
    }

    /**
     * Converts all characters in to lower case
     * @return $this
     */
    public function downCase()
    {
        $this->activeText = strtolower($this->activeText);
        return $this;
    }

    /**
     * Converts all characters in to upper case
     * @return $this
     */
    public function upCase()
    {
        $this->activeText = strtoupper($this->activeText);
        return $this;
    }

    /**
     * Swaps the case of alphabetic characters
     * @return $this
     */
    public function toggleCase()
    {
        $strAsArray = str_split($this->activeText);
        $outputArray = [];
        foreach ($strAsArray as $char) {
            if (ctype_lower($char)) {
                $outputArray[] = strtoupper($char);
            } elseif (ctype_upper($char)) {
                $outputArray[] = strtolower($char);
            } else {
                $outputArray[] = $char;
            }
        }

        $this->activeText = implode('', $outputArray);
        return $this;
    }

    /**
     * Returns the entire string as an array of individual characters
     * @return array
     */
    public function chars()
    {
        return str_split($this->activeText);
    }

    /**
     * Alias of `explode()`
     * @param $delimiter
     * @return array
     */
    public function split($delimiter)
    {
        return $this->explode($delimiter);
    }

    /**
     * Splits the string into array of strings by delimiter
     * @param String $delimiter Delimiter against which array creation happens
     * @return array
     */
    public function explode($delimiter)
    {
        return explode((string)$delimiter, $this->activeText);
    }

    /**
     * Appends another string to the existing one
     * @param String $stringToAppend
     * @return Str
     */
    public function append($stringToAppend)
    {
        $this->activeText .= $stringToAppend;
        return $this;
    }

    /**
     * Prepends another string to the existing one
     * @param String $stringToPrepend
     * @return Str
     */
    public function prepend($stringToPrepend)
    {
        $this->activeText = (String)$stringToPrepend . $this->activeText;
        return $this;
    }

    /**
     * Returns substring using the substr method
     * @param int $start
     * @param int $length
     * @return bool|string
     */
    public function substr(int $start, int $length = null)
    {
        return substr($this->activeText, $start, $length);
    }

    /**
     * Tells whether or not the string is empty
     * @param bool $trimStringFirst perform a trim on the string first
     * @return bool
     */
    public function isEmpty($trimStringFirst = false)
    {
        $text = $this->activeText;
        if ($trimStringFirst) {
            $text = trim($text);
        }

        if ($text == '') {
            return true;
        }
        return false;
    }

    /**
     * Returns if String contains a given substring
     * @param String $needle
     * @return bool
     */
    public function contains($needle)
    {
        if (strpos($this->activeText, (String)$needle) !== false) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether a given string starts with another (sub)string
     *
     * @param string $needle string to search
     *
     * @return bool
     */
    public function startsWith($needle)
    {
        // If the length of needle is greater than the length of this string, then return false
        if (strlen($needle) > strlen($this->activeText)) {
            // To suppress the error in strpos function below
            return false;
        }
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($this->activeText, $needle, -strlen($this->activeText)) !== false;
    }

    /**
     * Checks whether a given string ends with another (sub)string
     *
     * @param string $needle String to search
     *
     * @return bool
     */
    public function endsWith($needle)
    {
        // If the length of needle is greater than the length of this string, then return false
        if (strlen($needle) > strlen($this->activeText)) {
            // To suppress the error in strpos function below
            return false;
        }
        // search forward starting from end minus needle length characters
        return $needle === "" || strpos($this->activeText, $needle,
                strlen($this->activeText) - strlen($needle)) !== false;
    }

    /**
     * Compares and tells if this string is equal in length and content
     * @param $stringToCompare String which is to be compared
     * @return bool
     */
    public function isEqualTo($stringToCompare)
    {
        if ($this->activeText === (String)$stringToCompare) {
            return true;
        }
        return false;
    }

    /**
     * Reverses the string and stores it
     * @return Str
     */
    public function reverse()
    {
        $this->activeText = strrev($this->activeText);
        return $this;
    }

    /**
     * Justifies string to left with optional padding (default is space) to its right
     * @param int $finalLength Final length of the string needed after justification
     * @param string $strPadding Repeating padding string to be applied to the right (default = ' ')
     * @return Str
     */
    public function lJust($finalLength, $strPadding = ' ')
    {
        // If the final length is not more than the existing length, do nothing
        if ((int)$finalLength <= 0 || $this->length() >= $finalLength) {
            return $this;
        }

        // Calculate the difference between requested length and current length
        // and then iterate padding string just enough number of times, with the last one
        // optionally being a substring (from the beginning) of the Padding string
        $lenDiff = $finalLength - $this->length();

        while ($lenDiff > strlen($strPadding)) {
            $this->activeText .= $strPadding;
            $lenDiff = $finalLength - $this->length();
        }

        $this->activeText = $this->activeText . (substr($strPadding, 0, ($finalLength - strlen($this->activeText))));
        return $this;
    }

    /**
     * Justifies string to left with optional padding (default is space) to its right
     * @param int $finalLength Final length of the string needed after justification
     * @param string $strPadding Repeating padding string to be applied to the left (default = ' ')
     * @return Str
     */
    public function rJust($finalLength, $strPadding = ' ')
    {
        // If the final length is not more than the existing length, do nothing
        if ((int)$finalLength <= 0 || $this->length() >= $finalLength) {
            return $this;
        }

        // Calculate the difference between requested length and current length
        // and then iterate padding string just enough number of times, with the last one
        // optionally being a substring (from the beginning) of the Padding string
        $lenDiff = $finalLength - $this->length();

        $strToAdd = '';

        while ($lenDiff > strlen($strPadding)) {
            $strToAdd = $strPadding . $strToAdd;
            $lenDiff = $finalLength - ($this->length() + strlen($strToAdd));
        }

        $this->activeText = $strToAdd . (substr($strPadding, 0,
                ($finalLength - (strlen($this->activeText) + strlen($strToAdd))))) . $this->activeText;

        return $this;
    }

    /**
     * Returns the first character of the string
     * @return string
     */
    public function getFirstCharacter()
    {
        if ($this->length() > 0) {
            return $this->chars()[0];
        }

        return '';
    }

    /**
     * Returns the last character of the string
     * @return string
     */
    public function getLastCharacter()
    {
        $len = $this->length();
        if ($len > 0) {
            return $this->chars()[$len - 1];
        }

        return '';
    }

    public function partition()
    {
    }

    public function slice()
    {
    }

    public function squeeze()
    {
    }

    /**
     * Truncates the string to a given length, adding elipses (if needed).
     *
     * @param int $maxLength Maximum length to which the string should be cut.
     * @param bool $addEllipsis Should the truncation system add the ellipsis to the string?
     * @return Str the full string or the truncated string with ellipsis
     */
    public function truncate($maxLength, $addEllipsis = true)
    {
        $applicableLength = $maxLength;
        $ellipsis = '';
        if ($addEllipsis) {
            $applicableLength = $maxLength - 3;
            $ellipsis = '...';
        }

        if (mb_strlen($this->activeText, 'UTF-8') > $applicableLength) {
            $this->activeText = mb_substr($this->activeText, 0, $applicableLength, 'UTF-8') . $ellipsis;
        }

        return $this;
    }

    /**
     * Wraps the string with another string
     *
     * @param string $wrapString String which is to be added to the beginning of the string
     * @param null $wrapStringEnd String which is to be added to the end of the string
     *                              If this is set to null, the wrapString will be used instead!
     *
     * @return Str Returns the string after wrapping
     */
    public function wrapWith($wrapString = '"', $wrapStringEnd = null)
    {
        if ($wrapStringEnd == null) {
            $wrapStringEnd = $wrapString;
        }

        $this->activeText = $wrapString . $this->activeText . $wrapStringEnd;
        return $this;
    }

    public function xmlEscape()
    {
    }

    public function getLongestCommonSubsequenceWith($otherString)
    {
    }

    /**
     * Tells whether the string is in any of the strings in the supplied array of strings
     * @param string[]|Str[] $stringArray List of strings to check against
     * @param bool $case_insensitive_comparison Should the comparison be case insensitive?
     * @return bool
     */
    public function includedIn(array $stringArray, bool $case_insensitive_comparison = false)
    {
        $active_text = $this->activeText;

        if ($case_insensitive_comparison) {
            $active_text = strtolower($active_text);
        }

        foreach ($stringArray as $single_string) {
            // First convert to string representation
            $single_string = (string)$single_string;
            if ($case_insensitive_comparison) {
                $single_string = strtolower($single_string);
            }

            if ($active_text === $single_string) {
                return true;
            }
        }

        return false;
    }

    /**
     * Base 64 Encoding with optional URL Safe encoding
     *
     * @param bool $urlSafe Should we remove non URL Safe characters?
     * @return Str
     */
    public function base64Encode($urlSafe = false)
    {
        $s = base64_encode($this->activeText);

        if ($urlSafe) {
            $s = str_replace('+', '-', $s);
            $s = str_replace('/', '_', $s);
            $s = str_replace('=', '', $s);
        }

        $this->activeText = $s;

        return $this;
    }

    /**
     * Base 64 Decoding with optional URL Safe decoding
     *
     * @param bool $urlSafe Should we remove non URL Safe characters with correct base64 ones?
     * @return Str
     */
    public function base64Decode($urlSafe = false)
    {
        $s = $this->activeText;

        if ($urlSafe) {
            $s = str_replace('_', '/', $s);
            $s = str_replace('-', '+', $s);
        }

        $this->activeText = base64_decode($s);

        return $this;
    }


    /**
     * Converts the string to slugged version
     *
     * @param int $intMaxLength Max length of the resulting slug (default: 65000). Since slugs are normally used in web URLs, we limit it to 65000 by default, leaving space for other stuff (domain name, protocol name, path and hash). If you want to get the entire string, use (\mb_strlen($strString)) as the parameter value when calling the method
     *
     * @return Str
     */
    public function toSlug($intMaxLength = 65000)
    {
        // Slugs are normally used in
        $strString = $this->activeText;

        // If the string is going to be of zero length, we return empty string
        // NOTE: We run 'trim' because slugs are trimmed anyway
        if (\mb_strlen(trim($strString), $this->encoding) == 0) {
            $this->activeText = '';
        }

        $strString = strip_tags($strString);
        $strString = preg_replace('/%([a-fA-F0-9][a-fA-F0-9])/', '--$1--', $strString); // Preserve escaped octets
        $strString = str_replace('%', '', $strString); // Remove percent signs that are not part of an octet
        $strString = preg_replace('/--([a-fA-F0-9][a-fA-F0-9])--/', '%$1', $strString);  // Restore octets
        $strString = static::RemoveAccents($strString);
        $strString = mb_convert_case($strString, MB_CASE_LOWER, "UTF-8");
        $strString = preg_replace('/&.+?;/', '', $strString); // Kill entities
        $strString = str_replace('.', '-', $strString);
        $strString = str_replace('::', '-', $strString);
        $strString = preg_replace('/\s+/', '-', $strString); // Remove excess spaces in a string
        $strString = preg_replace('|[\p{Ps}\p{Pe}\p{Pi}\p{Pf}\p{Po}\p{S}\p{Z}\p{C}\p{No}]+|u', '',
            $strString); // Remove separator, control, formatting, surrogate, open/close quotes
        $strString = preg_replace('/-+/', '-', $strString); // Remove excess hyphens
        $strString = trim($strString, '-');
        $strString = mb_substr($strString, 0, $intMaxLength, $this->encoding);
        $strString = rtrim($strString, '-'); // When the end of the text remains the hyphen, it is removed.

        $this->activeText = $strString;
        return $this;
    }

    /**
     * Remove accents from a string
     *
     * @param string $strString string
     * @return string
     */
    protected static function removeAccents($strString)
    {
        if (!preg_match('/[\x80-\xff]/', $strString))
            return $strString;
        if (self::IsUtf8($strString)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
                chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
                chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
                chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
                chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
                chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
                chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
                chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
                chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
                chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
                chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
                chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
                chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
                chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
                chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
                chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
                chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
                chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
                chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
                chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
                chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
                chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
                chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
                chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
                chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
                chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
                chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
                chr(195) . chr(191) => 'y',
                // Decompositions for Latin Extended-A
                chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
                chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
                chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
                chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
                chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
                chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
                chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
                chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
                chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
                chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
                chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
                chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
                chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
                chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
                chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
                chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
                chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
                chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
                chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
                chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
                chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
                chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
                chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
                chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
                chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
                chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
                chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
                chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
                chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
                chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
                chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
                chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
                chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
                chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
                chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
                chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
                chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
                chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
                chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
                chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
                chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
                chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
                chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
                chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
                chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
                chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
                chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
                chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
                chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
                chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
                chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
                chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
                chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
                chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
                chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
                chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
                chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
                chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
                chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
                chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
                chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
                chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
                chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
                chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's',
                // Euro Sign
                chr(226) . chr(130) . chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194) . chr(163) => '');
            $strString = strtr($strString, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158)
                . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194)
                . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202)
                . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210)
                . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218)
                . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227)
                . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235)
                . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243)
                . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251)
                . chr(252) . chr(253) . chr(255);
            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
            $strString = strtr($strString, $chars['in'], $chars['out']);
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $strString = str_replace($double_chars['in'], $double_chars['out'], $strString);
        }
        return $strString;
    }

    /**
     * Check whether a string is utf 8 or not
     *
     * @param null|string $strInput
     * @return string
     */
    public static function isUtf8($strInput = null)
    {
        return preg_match('%^(?:
					[\x09\x0A\x0D\x20-\x7E]             # ASCII
					| [\xC2-\xDF][\x80-\xBF]            # non-overlong 2-byte
					|  \xE0[\xA0-\xBF][\x80-\xBF]       # excluding overlongs
					| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
					|  \xED[\x80-\x9F][\x80-\xBF]       # excluding surrogates
					|  \xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
					| [\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
					|  \xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
					)*$%xs', $strInput);
    }

    /**
     * Magic method for retrieving original or active string
     * @param $name
     * @return String
     * @throws \Exception
     */
    public function __get($name)
    {
        switch ($name) {
            case 'originalString':
                return $this->originalText;
            case 'activeString':
            case 'activeText':
                return $this->activeText;
            default:
                throw new \Exception('Invalid property requested', 1);
        }
    }

    /**
     * Convert the string to a scalar integer value
     * @return integer
     */
    public function toInt()
    {
        return (int)$this->activeText;
    }

    /**
     * Convert the string to a scalar float value
     * @return float
     */
    public function toFloat()
    {
        return (float)$this->activeText;
    }

    /**
     * Puts the string in an array and returns the array
     * @return array
     */
    public function toArray()
    {
        return [$this->activeText];
    }

    /**
     * Convert the value to a scalar string value
     * @return string
     */
    public function toString()
    {
        if (empty($this->activeText)) {
            return '';
        }
        return $this->activeText;
    }
}

