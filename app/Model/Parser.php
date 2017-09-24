<?php

namespace app\Model;

class Parser
{
	const REGEX_BR        = '!\s*<\s*[bB][rR]\s*/?\s*>\s*!';
	const REGEX_LINKEDIMG = '!<a [^>]*href="[^"]*pic_id=([^"]*)"[^>]*>[^<>]*<img [^>]*src="([^"]*)"[^>]*>[^<>]*</a>!';

	private $raw;
	public function __construct($raw) {$this->raw = $raw;}

	public function pictures()
	{
		$htmlLines = preg_split(self::REGEX_BR, $this->raw);
		$imgs = array();
		foreach ($htmlLines as $pictureRowLine) {
			preg_replace_callback(
				self::REGEX_LINKEDIMG,
				function ($matches) use (&$imgs) {
					$imgs[] = array(
						'id'  => $matches[1],
						'src' => $matches[2]
					);
					return '';
				},
				$pictureRowLine
			);
		}
		return $imgs;
	}
}
