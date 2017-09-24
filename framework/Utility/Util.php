<?php

namespace framework\Utility;

class Util
{
	const class54 = __CLASS__;

	public static function eq($a, $b) {return $a == $b;}

	public static function triage($leftN, $rightN, $arr, $index)
	{
		$n   = count($arr);
		$res = array();
		if ($index >= $leftN) {
			for ($i = 0; $i < $index - $leftN; $i++) {
				$res[$i] = array('notdisplayed-left', $arr[$i]);
			}
			for ($i = $index - $leftN; $i < $index; $i++) {
				$res[$i] = array('left', $arr[$i]);
			}
		} else { // index < leftN
			for ($i = 0; $i < $index; $i++) {
				$res[$i] = array('left', $arr[$i]);
			}
		}
		$res[$index] = array('focus', $arr[$i]);
		if ($index + $rightN < $n) {
			for ($i = $index + 1; $i <= $index + $rightN; $i++) {
				$res[$i] = array('right', $arr[$i]);
			}
			for ($i = $index + $rightN + 1; $i < $n; $i++) {
				$res[$i] = array('notdisplayed-right', $arr[$i]);
			}
		} else { // index + rightN >= n
			for ($i = $index + 1; $i < $n; $i++) {
				$res[$i] = array('right', $arr[$i]);
			}
		}
		return $res;
	}

}
