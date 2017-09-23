<?php

namespace app\Controller;

use framework\Controller;
use app\Model\OfferRepository;
use app\Model\SlideMemory;

class CommonController extends Controller
{

	protected function showCommon($offerId, $pictureId, $title)
	{
		$offerRepo = new OfferRepository($offerId);
		$offer    = $offerRepo->findOffer();
		$pictures = $offerRepo->findPictures();
		$focus    = $pictureId;

		$slideMemory = SlideMemory::slideMemory($pictures, $pictureId); // $prevId, $nextId, $focusedPicture
		return compact('title', 'offer', 'pictures', 'focus', 'offerId', 'pictureId') + $slideMemory;
	}
}
