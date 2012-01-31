<?php
/**
 * User: matteo
 * Date: 31/01/12
 * Time: 14.37
 *
 * Just for fun...
 */

namespace Cypress\CompassElephantBundle\Tests\Collection;

use Cypress\CompassElephantBundle\Collection\CompassProjectCollection,
    CompassElephant\CompassBinary;

class CompassProjectCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {

        $binary = new CompassBinary();
        $projects = array(
            'test' => array(
                'path' => $this->getTempPathName(),
                'staleness_checker' => 'finder',
                'config_file' => 'config.rb',
                'auto_init' => true
            ),
            'test' => array(
                'path' => $this->getTempPathName(),
                'staleness_checker' => 'finder',
                'config_file' => 'config.rb',
                'auto_init' => true
            )
        );
        $coll = new CompassProjectCollection($binary, $projects);

        $this->assertCount(1, $coll);
    }

    private function getTempPathName()
    {
        $tempDir = realpath(sys_get_temp_dir()).'compass_elephant_'.md5(uniqid(rand(),1));
        $tempName = tempnam($tempDir, 'compass_elephant');
        return $tempName;
    }
}
