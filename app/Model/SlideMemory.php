<?php

namespace app\Model;

class SlideMemory
{
	public static function slideMemory($pictures, $pictureId)
	{
		$prevId = $nextId = $cache = null;
		$status = 'virgin';
		foreach ($pictures as $picture) {
			switch ($status) {
				case 'virgin':
					if ($picture['id'] == $pictureId) {
						$status = 'focus';
						$prevId = $cache;

						$focusedPicture = $picture;
					}
					break;
				case 'focus':
					if ($picture['id'] != $pictureId) {
						$status = 'after';
						$nextId = $picture['id'];
					}
					break;
			}
			$cache = $picture['id'];
		}
		return compact('prevId', 'nextId', 'focusedPicture');
	}
}
