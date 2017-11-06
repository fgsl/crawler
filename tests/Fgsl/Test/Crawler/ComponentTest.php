<?php
/**
 * Fgsl Crawler - a component for finding and replacing text patterns
 *
 * @author    Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @link      https://github.com/fgsl/mail for the canonical source repository
 * @copyright Copyright (c) 2017 FGSL (http://www.fgsl.eti.br)
 * @license   https://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE
*/
namespace Fgsl\Test\Crawler;

use Fgsl\Crawler\Filter;
/**
 * 
 * @package    Fgsl
 * @subpackage Test
 */
class ComponentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test class existence
     */
    public function testFilterClass()
    {        
        $this->assertTrue(class_exists(Filter::class));
    }


}