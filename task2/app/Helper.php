<?php

class Helper
{

	public static function isValidInput($inputEntity)
	{
		if ($inputEntity->value < 100 || $inputEntity->value > 100000) {
			return false;
		}
		if ($inputEntity->taxPersent < 1 || $inputEntity->taxPersent > 100) {
			return false;
		}
		if ($inputEntity->partCount < 1 || $inputEntity->partCount > 12) {
			return false;
		}
		return true;
	}

	public static function calculatePercent($value, $percent) 
	{
		return ceil($value * ($percent))/100; 
	}

}