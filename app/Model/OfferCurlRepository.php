<?php

namespace app\Model;

use framework\ORM\BackendAppConn;

class OfferCurlRepository
{
	private $raw;

	public function __construct($propertyId, $pictureId)
	{
		$backendAppConn = new BackendAppConn(array('property_id' => $propertyId, 'pic_id' => $pictureId));
		$this->raw      = $backendAppConn->get();
	}

	public function findPictures()
	{
		$parser = new Parser($this->raw);
		return $parser->pictures();
	}

}


