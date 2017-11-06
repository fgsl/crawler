<?php
/**
 * Fgsl Filter - a component for finding and replace text patterns
 *
 * @author    Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @link      https://github.com/fgsl/crawler for the canonical source repository
 * @copyright Copyright (c) 2017 FGSL (http://www.fgsl.eti.br)
 * @license   https://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE
 */
namespace Fgsl\Crawler;

class Filter
{
	/**
	 * 
	 * @param string $pattern valid regular expression
	 * @param string $subject
	 * @param boolean $onlyFirst
	 * @return array | integer
	 */
	public function getMatches($pattern, $subject, $onlyFirst = false)
	{
		if ($onlyFirst){
			$result = preg_match($pattern, $subject, $matches);
		} else {
			$result = preg_match_all($pattern, $subject, $matches);
		}
		
		return $matches;
	}
	
	/**
	 * 
	 * @param string $pattern valid regular expression
	 * @param string $subject
	 * @param string $replacement
	 * @return array | string
	 */
	public function replaceMatches($pattern, $subject, $replacement)
	{
		return preg_replace($pattern, $replacement, $subject);
	}
}