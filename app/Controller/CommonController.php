<?php

namespace app\Controller;

use framework\Controller;
use app\Model\OfferRepository;

class CommonController extends Controller
{

	protected function showCommon($offerId, $pictureId, $title)
	{
		$offerRepo = new OfferRepository($offerId);
		$offer    = $offerRepo->findOffer();
		$pictures = $offerRepo->findPictures();
		$focus    = $pictureId;

		$slideMemory = $this->slideMemory($pictures, $pictureId); // $prevId, $nextId, $focusedPicture
		return compact('title', 'offer', 'pictures', 'focus', 'offerId', 'pictureId') + $slideMemory;
	}

	private function slideMemory($pictures, $pictureId)
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
