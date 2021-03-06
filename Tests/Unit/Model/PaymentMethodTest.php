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
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Seminars_Tests_Unit_Model_PaymentMethodTest extends Tx_Phpunit_TestCase
{
    /**
     * @var Tx_Seminars_Model_PaymentMethod
     */
    private $fixture;

    protected function setUp()
    {
        $this->fixture = new Tx_Seminars_Model_PaymentMethod();
    }

    /**
     * @test
     */
    public function setTitleWithEmptyTitleThrowsException()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'The parameter $title must not be empty.'
        );

        $this->fixture->setTitle('');
    }

    /**
     * @test
     */
    public function setTitleSetsTitle()
    {
        $this->fixture->setTitle('Cash');

        self::assertEquals(
            'Cash',
            $this->fixture->getTitle()
        );
    }

    /**
     * @test
     */
    public function getTitleWithNonEmptyTitleReturnsTitle()
    {
        $this->fixture->setData(['title' => 'Cash']);

        self::assertEquals(
            'Cash',
            $this->fixture->getTitle()
        );
    }

    /////////////////////////////////////
    // Tests regarding the description.
    /////////////////////////////////////

    /**
     * @test
     */
    public function getDescriptionWithoutDescriptionReturnsAnEmptyString()
    {
        $this->fixture->setData([]);

        self::assertEquals(
            '',
            $this->fixture->getDescription()
        );
    }

    /**
     * @test
     */
    public function getDescriptionWithDescriptionReturnsDescription()
    {
        $this->fixture->setData(['description' => 'Just plain cash, baby!']);

        self::assertEquals(
            'Just plain cash, baby!',
            $this->fixture->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionSetsDescription()
    {
        $this->fixture->setDescription('Just plain cash, baby!');

        self::assertEquals(
            'Just plain cash, baby!',
            $this->fixture->getDescription()
        );
    }

    /**
     * @test
     */
    public function hasDescriptionWithoutDescriptionReturnsFalse()
    {
        $this->fixture->setData([]);

        self::assertFalse(
            $this->fixture->hasDescription()
        );
    }

    /**
     * @test
     */
    public function hasDescriptionWithDescriptionReturnsTrue()
    {
        $this->fixture->setDescription('Just plain cash, baby!');

        self::assertTrue(
            $this->fixture->hasDescription()
        );
    }
}
