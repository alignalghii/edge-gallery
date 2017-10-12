<?php

namespace app\Controller;

use framework\Controller;
use app\Model\OfferCurlRepository;
use app\Model\SlideMemory;
use framework\Utility\Util;
use app\Config;

class BackendAppController extends Controller
{
	/** `::class54`: no need for it since PHP 5.5, use `::class` instead */
	const class54 = __CLASS__;

	public function xshowJs($propertyId, $pictureId)
	{
		$commonViewModel = ['title' => 'CentralHome gallery', 'mater' => Config::MATER];
		$repo = new OfferCurlRepository($propertyId, $pictureId);
		$pictures = $repo->findPictures();
		$focusExists = !empty($pictures);
		list($viewFileName, $specificViewModel) = $focusExists
		                                        ? ['xshow-js', $this->normalViewModel($propertyId, $pictureId, $pictures)]
		                                        : ['error',    $this->errorViewModel ($propertyId, $pictureId)];
		$viewModel = $commonViewModel + $specificViewModel;
		$this->render("BackendApp/$viewFileName", $viewModel, 'xedge-js');
	}

	public function xshowJs_querystring($propertyId, $pictureId)
	{
		$this->xshowJs($propertyId, $pictureId);
	}

	private function normalViewModel($propertyId, $pictureId, $pictures)
	{
		$orderNum = Aux::orderNum($pictures, $pictureId);
		$triagedPictures = Util::triage(5, 5, $pictures, $orderNum);  /** @TODO remove redundancy */
		$triageCfg       = array('left' => 5, 'right' => 5); /** @TODO remove redundancy */

		$focusOrderNum = $this->focusOrderNum($triagedPictures);

		$slideMemory = SlideMemory::slideMemory($pictures, $pictureId); // $prevId, $nextId, $focusedPicture
		$focus = $pictureId;
		return compact('pictures', 'focus', 'focusOrderNum', 'propertyId', 'pictureId', 'triagedPictures', 'triageCfg') + $slideMemory;
	}

	private function errorViewModel($propertyId, $pictureId)
	{
		return [];
	}

	private function focusOrderNum($triagedPictures)
	{
		$labelOf = function ($triagedPicture) {return $triagedPicture[0];};
		$labels = array_map($labelOf, $triagedPictures); 
		return array_search('focus', $labels);
	}
}
