<?php

namespace app\Controller;

use framework\Utility\Util;

class NewController extends CommonController
{
	/** `::class54`: no need for it since PHP 5.5, use `::class` instead */
	const class54 = __CLASS__;

	public function index()
	{
		$this->redirect('http://www.centralhome.hu/');
	}

	public function show2($offerId, $pictureId)
	{
		$viewModel = $this->showCommon($offerId, $pictureId, "Plain gallery for offer #$offerId focusing #$pictureId");
		$this->render('New/show2', $viewModel, 'edge');
	}

	public function show2Js($offerId, $pictureId)
	{
		$viewModel = $this->showCommon($offerId, $pictureId, "JavaScripted gallery for offer #$offerId focusing #$pictureId");
		$pictures = $viewModel['pictures'];
		$orderNum = Aux::orderNum($pictures, $pictureId);

		$viewModel['triagedPictures'] = Util::triage(5, 5, $pictures, $orderNum);
		$viewModel['triageCfg'] = array('left' => 5, 'right' => 5); /** @TODO remove redundancy */

		$this->render('New/show2-js', $viewModel, 'edge-js');
	}

}
