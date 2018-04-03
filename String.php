<?php

/**
* Str: A near-natural Ruby-like String Implementation
*/
class Str
{
	/**
	 * @var String Original text with which the class was created
	 */
	protected $originalText;

	protected $activeText;

    /**
     * Str constructor.
     * @param String $origText Original text with which the object is to be constructed
     */
	public function __construct(String $origText)
	{
		$this->originalText = $origText;
		$this->activeText = $origText;
	}

    /**
     * String representation of the object
     * @return String returns the active text
     */
	public function __toString()
	{
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
     * @param String $character_mask Argument to `ltrim()`
     * @return $this
     */
	public function ltrim(String $character_mask = "\t\n\r\0\x0B")
	{
		$this->activeText = ltrim($this->activeText, $character_mask);
		return $this;
	}

    /**
     * Runs `rtrim()` on the string
     * @param String $character_mask Argument to `rtrim()`
     * @return $this
     */
	public function rtrim(String $character_mask = "\t\n\r\0\x0B")
	{
		$this->activeText = rtrim($this->activeText, $character_mask);
		return $this;
	}

    /**
     * Runs `trim()` on the string
     * @param String $character_mask Argument to `trim()`
     * @return $this
     */
	public function trim(String $character_mask = "\t\n\r\0\x0B")
	{
		$this->activeText = trim($this->activeText, $character_mask);
		return $this;
	}

    /**
     * Alias of `trim()` without the optional character_mask argument
     * @return Str
     */
	public function strip() {
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
	public function downcase() 
	{
		$this->activeText = strtolower($this->activeText);
		return $this;
	}

    /**
     * Converts all characters in to upper case
     * @return $this
     */
	public function upcase() 
	{
		$this->activeText = strtoupper($this->activeText);
		return $this;
	}

    /**
     * Swaps the case of alphabetic characters
     * @return $this
     */
	public function togglecase()
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
    public function explode($delimiter) {
	    return explode((String)$delimiter, $this->activeText);
    }

}

$obj = new Str(" Vaibhav Kaushal ");
echo "\nlength: " . $obj->length();
echo "\nstring cast: '" . $obj . "'";
echo "\ntrim: '" . $obj->trim() . "'";;
echo "\nlength after trimming: " . $obj->length();
echo "\nbefore reset: '" . $obj . "'";
echo "\ncalling reset: '" . $obj->reset() . "'";
echo "\ntrimming again: '" . $obj->trim() . "'";
echo "\ntoggle case: '" . $obj->togglecase() . "'";
echo "\ntoggle case again: '" . $obj->togglecase() . "'";
echo "\ndowncasing: '" . $obj->downcase() . "'";
echo "\nupcasing: '" . $obj->upcase() . "'";
echo "\ncalling reset: '" . $obj->reset() . "'";
echo "\ncalling chain (trim-upcase-togglecase): '" . $obj->trim()->upcase()->togglecase() . "'";

echo "\n";
