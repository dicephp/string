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
        if (empty($this->activeText)) {
            return '';
        }
        return $this->activeText;
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

    public function getAsSlug()
    {
    }

    public function removeAccents()
    {
    }

    /**
     * Check whether a string is utf 8 or not
     *
     * @return string
     */
    public function isUtf8()
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
					)*$%xs', $this->activeText);
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
}

