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
 * This builder class creates customized test bag objects.
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Seminars_Tests_Unit_Fixtures_BagBuilder_BrokenTesting extends Tx_Seminars_BagBuilder_Abstract
{
    /**
     * @var string class name of the bag class that will be built
     */
    protected $bagClassName = Tx_Seminars_Tests_Unit_Fixtures_Bag_Testing::class;
}
