<?php

require '../autoload.php';

use framework\Utility\MaybeExt;
use framework\Utility\Util;
use framework\Meta;
use framework\AlgebraicDataTypes\Maybe;
use framework\AlgebraicDataTypes\Either;
use framework\AlgebraicDataTypes\Either2Or1;

function statusMsg($status) {return $status ? 'OK' : 'Wrong';}
function printStatus($status) {echo statusMsg($status) . "\n";}

$allStatus = true;

echo "Inspected functionalities:\n";

echo ' - framework\Utility\MaybeExt::array_mapMaybe_access_keys: ';
$r = MaybeExt::array_mapMaybe_access_keys(function($k, $v) {return Maybe::just($k + $v);}, [10,20,30]);
$status = $r === [10, 21, 32];
printStatus($status);
$allStatus = $allStatus && $status;

echo ' - framework\AlgebraicDataTypes\Either: ';
$leftDiv0 = Either::left('Division by zero');
$right5   = Either::right(5);
function reportEither($eitherErrorLabelOrNumResult)
{
	return $eitherErrorLabelOrNumResult->either(
		function ($errorLabel) {return "Problem: $errorLabel";},
		function ($numResult)  {return "The value is: $numResult";}
	);
}
$status = reportEither($right5) == 'The value is: 5' && reportEither($leftDiv0) == 'Problem: Division by zero';
printStatus($status);
$allStatus = $allStatus && $status;

echo ' - framework\AlgebraicDataTypes\Either2Or1: ';
$leftDiv0 = Either2Or1::left2(13, 3);
$right5   = Either2Or1::right1(2);
function division($a, $b)
{
	$q = (int) ($a / $b);
	$r = $a % $b;
	return $r ? Either2Or1::left2($q, $r) : Either2Or1::right1($q);
}
function divMsg($e)
{
	return $e->either2Or1(
		function ($q, $r) {return "Problem: no divisibility, q = $q, r = $r";},
		function ($q)     {return "The value is: $q";}
	);
}

$status = divMsg(division(100, 2)) == "The value is: 50" && divMsg(division(36, 24)) == "Problem: no divisibility, q = 1, r = 12";
printStatus($status);
$allStatus = $allStatus && $status;

echo ' - framework\Utility\Util: ';
$status = Util::triage(0, 0, ['a'], 0) == [['focus', 'a']] && Util::triage(2, 5, ['a'], 0) == [['focus', 'a']] && Util::triage(2, 5, ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o'], 5) == [['notdisplayed-left', 'a'], ['notdisplayed-left', 'b'], ['notdisplayed-left', 'c'], ['left', 'd'], ['left', 'e'], ['focus', 'f'], ['right', 'g'], ['right', 'h'], ['right', 'i'], ['right', 'j'], ['right', 'k'], ['notdisplayed-right', 'l'], ['notdisplayed-right', 'm'], ['notdisplayed-right', 'n'], ['notdisplayed-right', 'o']];
printStatus($status);
$allStatus = $allStatus && $status;

/**
 * There is no way to implemant `safeExtract`
 * @see https://stackoverflow.com/questions/2251386/can-we-implement-a-php-extract-function-in-php-with-out-using-zend-api
 *
 * echo ' - framework\Meta::safeExtract: ';
 * $status0 = !isset($two) && !isset($three) &&!isset($four);
 * Meta::safeExtract(['two', 'four'], ['two' => 2, 'three' => 3]);
 * $status = $status0 && $two === 2 && !isset($three) && !isset($four);
 * printStatus($status);
 * $allStatus = $allStatus && $status;
 */

echo "-------> Overall status: " . statusMsg($allStatus) . "\n";
