<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Test case.
 *
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Seminars_Tests_Unit_BackEnd_ModuleTest extends Tx_Phpunit_TestCase
{
    /**
     * @var Tx_Seminars_BackEnd_Module
     */
    private $fixture;

    protected function setUp()
    {
        Tx_Oelib_ConfigurationProxy::getInstance('seminars')->setAsBoolean('enableConfigCheck', false);

        $this->fixture = new Tx_Seminars_BackEnd_Module();
    }

    ////////////////////////////////////////////////
    // Tests for getting and setting the page data
    ////////////////////////////////////////////////

    public function testGetPageDataInitiallyReturnsEmptyArray()
    {
        self::assertEquals(
            [],
            $this->fixture->getPageData()
        );
    }

    public function testGetPageDataReturnsCompleteDataSetViaSetPageData()
    {
        $this->fixture->setPageData(['foo' => 'bar']);

        self::assertEquals(
            ['foo' => 'bar'],
            $this->fixture->getPageData()
        );
    }
}
