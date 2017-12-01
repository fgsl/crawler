<?php
use Fgsl\Crawler\Filter;
/**
 * crawler - a script to collect data from websites
 * 
 * Syntax:
 * 
 * php crawler.php [source] [pattern] [target]
 *
 * @author    Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @link      https://github.com/fgsl/crawler for the canonical source repository
 * @copyright Copyright (c) 2017 FGSL (http://www.fgsl.eti.br)
 * @license   https://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE
 */

include __DIR__ . '/../vendor/autoload.php';

echo "\n" . str_repeat('=', 80) . "\n";
echo str_pad('FGSL crawler - a script to collect data from websites',80,'=', STR_PAD_BOTH);
echo "\n" . str_repeat('=', 80) . "\n";

if (!isset($argc) || $argc < 4){
	showHelp();
}
$source = $argv[1];
$pattern = $argv[2];
$target = $argv[3];

//default option values
$onlyFirst = false;
$glue = ',';
$showNumberOfMatches = false;
$showMatches = false;
$xml = false;
$json = false;
		
//use user options
$argindex = 4;
while (isset($argv[$argindex])){
	$option = $argv[4];
	if (substr($option,0,1) != '-' ){
		showHelp($argc);
	}
	
	if (strpos($option,'o') !== FALSE){
		$onlyFirst = true;
	}

	if (strpos($option,'n') !== FALSE){
		$showNumberOfMatches = true;
	}
	
	if (strpos($option,'v') !== FALSE){
		$showMatches = true;
	}

	if (substr($option,1,1) == 'g'){
		$glue = substr($option,3);
	}
	
	if (substr($option,1,1) == 'x'){
		$xml = true;
	}

	if (substr($option,1,1) == 'j'){
		$json = true;
	}	
	
	$argindex++;	
}

if (!file_exists($source)){
	$headers = @get_headers($source);
	if(strpos($headers[0],'200') === false) {	
		echo "\n" . str_repeat('=', 80) . "\n";
		echo str_pad("Error: address doesn't exist",80,'=',STR_PAD_BOTH);
		echo "\n" . str_repeat('=', 80) . "\n";
		exit;
	}	
}

$contentSource = file_get_contents($source);

$matched = Filter::getMatches($pattern, $contentSource);

$GLOBALS['result'] = '';
if ($xml){
	$result = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$result .= '<matches>' . "\n";
	array_walk($matched,function($value,$index){
		$GLOBALS['result'] .= "<match>$value</match>\n"; 		
	});
	$result .= '</matches>' . "\n";
} elseif ($json) {
	$result .= '{' . "\n";
	$result .= '"matches":[' . "\n";
	array_walk($matched,function($value,$index){
		$GLOBALS['result'] .= '"' . $value . '",' . "\n";
	});	
	$result .= ']}' . "\n";	
} else {
	$result = implode($glue,$matched);
}

file_put_contents($target, $result);

if ($showNumberOfMatches){
	echo "\n" . str_repeat('=', 80) . "\n";
	echo str_pad('Matches: ' . count($matched),80,'=',STR_PAD_BOTH);
	echo "\n" . str_repeat('=', 80) . "\n";
}

if ($showMatches){
	echo "\n" . str_repeat('=', 80) . "\n";
	echo str_pad("Matches",80,'=',STR_PAD_BOTH);
	echo "\n" . str_repeat('=', 80) . "\n";
	echo $result;	
	echo "\n" . str_repeat('=', 80) . "\n";
}

echo "\n" . str_repeat('=', 80) . "\n";
echo str_pad("Matched content saved in $target",80,'=',STR_PAD_BOTH);
echo "\n" . str_repeat('=', 80) . "\n";



/** 
 * @param integer $argc
 * @param boolean $exit
 */
function showHelp($argc = 0, $exit = true)
{
	echo "\n" . str_repeat('=', 80) . "\n";	
	echo "\nOnly $argc arguments are not enough\n";
	echo "\nSyntax:\n";
	echo "\nphp crawler.php [source] [pattern] [target] [option]\n";
	echo "\nOptions without values can be used together. E.g. -nv=;\n";
	echo "\nOptions with values must be used alone. E.g. -g=;\n";
	echo "-o : search only first match\n";
	echo "-n : show number of matches at console\n";
	echo "-g=[glue] : glue for matched \n";
	echo "-v : show matches at console\n";
	echo "-x : saves in XML format\n";
	echo "-j : saves in JSON format\n";	
	if ($exit){
		exit;
	}	
	echo "\n" . str_repeat('=', 80) . "\n";	
}