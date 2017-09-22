<?php

namespace app\Model;

use framework\ORM\Statement;

class OfferRepository
{
	const OFFER = '
		SELECT
			`a`.`id`      AS `advisor_id`,
			`a`.`name`    AS `advisor_name`,
			`f`.`id`      AS `flat_id`,
			`f`.`address` AS `flat_address`,
			`o`.`id`      AS `offer_id`,
			`o`.`date`    AS `due_date`,
			`o`.`email`   AS `sent_email`
		FROM `offer` AS `o`
			JOIN `flat`    AS `f` ON `f`.`id` = `o`.`flat_id`
			JOIN `advisor` AS `a` ON `a`.`id` = `o`.`advisor_id`
		WHERE `o`.`id` = :offerId
	';

	const PICTURES = '
		SELECT
			`p`.`id`      AS `id`,
			`p`.`src`     AS `src`
		FROM `offer` AS `o`
			JOIN `flat`    AS `f` ON `f`.`id`      = `o`.`flat_id`
			JOIN `picture` AS `p` ON `p`.`flat_id` = `f`.`id`
		WHERE `o`.`id` = :offerId
	';


	private $offerId;       // independent property
	private $identifyOffer; // dependent, derived  property, cache-like, must be updated
	private function update() {$this->identifyOffer = [':offerId' => [$this->offerId, \PDO::PARAM_INT]];}

	public function __construct($offerId)
	{
		$this->offerId = $offerId;
		$this->update();
	}

	public function findOffer()
	{
		$offerStatement = new Statement(self::OFFER, $this->identifyOffer);
		return $offerStatement->queryOneOrAll(true);
	}

	public function findPictures()
	{
		$picsStatement = new Statement(self::PICTURES, $this->identifyOffer);
		return $picsStatement->queryOneOrAll(false);
	}

}
