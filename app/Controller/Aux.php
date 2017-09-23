<?php

namespace app\Controller;

class Aux
{
	public static function orderNum($pictures, $pictureId)
	{
		$n = count($pictures);
		for ($i = 0; $i < $n; $i++) {
			if ($pictures[$i]['id'] == $pictureId) return $i;
		}
		return null;
	}
}
