<?php

namespace app\Controller;

use framework\Controller;
use app\Model\OfferCurlRepository;
use app\Model\SlideMemory;
use framework\Utility\Util;

class BackendAppController extends Controller
{
	/** `::class54`: no need for it since PHP 5.5, use `::class` instead */
	const class54 = __CLASS__;

	public function xshowJs($propertyId, $pictureId)
	{
		$repo = new OfferCurlRepository($propertyId, $pictureId);
		$pictures = $repo->findPictures();
		$orderNum = Aux::orderNum($pictures, $pictureId);
		$triagedPictures = Util::triage(5, 5, $pictures, $orderNum);  /** @TODO remove redundancy */
		$triageCfg       = ['left' => 5, 'right' => 5]; /** @TODO remove redundancy */

		$slideMemory = SlideMemory::slideMemory($pictures, $pictureId); // $prevId, $nextId, $focusedPicture
		$focus = $pictureId;
		$title = 'Gallery';
		$viewModel = compact('title', 'pictures', 'focus', 'propertyId', 'pictureId', 'triagedPictures', 'triageCfg') + $slideMemory;
		$this->render('BackendApp/xshow-js', $viewModel, 'edge-js');
	}
}
