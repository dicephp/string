<?php

/**
* Str: A near-natural Ruby-like String Implementation
*/
class Str
{
	/*
	 * @var String Original text with which the class was created
	 */
	protected $originalText;

	protected $activeText;

	
	public function __construct(String $origText)
	{
		$this->originalText = $origText;
		$this->activeText = $origText;
	}

	public function __tostring() 
	{
		return $this->activeText;
	}

	public function length() 
	{
		return strlen($this->activeText);
	}

	public function ltrim($character_mask)
	{
		$this->activeText = ltrim(this->activeText, $character_mask);
		return $this;
	}

	public function rtrim($character_mask)
	{
		$this->activeText = rtrim(this->activeText, $character_mask);
		return $this;
	}

	public function trim()
	{
		$this->activeText = trim($this->activeText);
		return $this;
	}

	public function strip() {
		// This is only a wrapper method
		return $this->trim();
	}

	public function lines()
	{
		return explode("\n", $this->activeText);
	}

	public function reset()
	{
		$this->activeText = $this->originalText;
		return $this;
	}

	public function downcase() 
	{
		$this->activeText = strtolower($this->activeText);
		return $this;
	}

	public function upcase() 
	{
		$this->activeText = strtoupper($this->activeText);
		return $this;
	}

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

	public function chars()
	{
		return str_split($this->activeText);
	}

	public function 

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
