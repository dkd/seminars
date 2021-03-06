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
 * This class represents a mapper for events.
 *
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Seminars_Mapper_Event extends Tx_Oelib_DataMapper
{
    /**
     * @var string the name of the database table for this mapper
     */
    protected $tableName = 'tx_seminars_seminars';

    /**
     * @var string the model class name for this mapper, must not be empty
     */
    protected $modelClassName = Tx_Seminars_Model_Event::class;

    /**
     * @var string[] the (possible) relations of the created models in the format DB column name => mapper name
     */
    protected $relations = [
        'topic' => Tx_Seminars_Mapper_Event::class,
        'categories' => Tx_Seminars_Mapper_Category::class,
        'event_type' => Tx_Seminars_Mapper_EventType::class,
        'timeslots' => Tx_Seminars_Mapper_TimeSlot::class,
        'place' => Tx_Seminars_Mapper_Place::class,
        'lodgings' => Tx_Seminars_Mapper_Lodging::class,
        'foods' => Tx_Seminars_Mapper_Food::class,
        'speakers' => Tx_Seminars_Mapper_Speaker::class,
        'partners' => Tx_Seminars_Mapper_Speaker::class,
        'tutors' => Tx_Seminars_Mapper_Speaker::class,
        'leaders' => Tx_Seminars_Mapper_Speaker::class,
        'payment_methods' => Tx_Seminars_Mapper_PaymentMethod::class,
        'organizers' => Tx_Seminars_Mapper_Organizer::class,
        'organizing_partners' => Tx_Seminars_Mapper_Organizer::class,
        'target_groups' => Tx_Seminars_Mapper_TargetGroup::class,
        'owner_feuser' => Tx_Oelib_Mapper_FrontEndUser::class,
        'vips' => Tx_Oelib_Mapper_FrontEndUser::class,
        'checkboxes' => Tx_Seminars_Mapper_Checkbox::class,
        'requirements' => Tx_Seminars_Mapper_Event::class,
        'dependencies' => Tx_Seminars_Mapper_Event::class,
        'registrations' => Tx_Seminars_Mapper_Registration::class,
    ];

    /**
     * Retrieves an event model with the publication hash provided.
     *
     * @param string $publicationHash
     *        the publication hash to find the event for, must not be empty
     *
     * @return Tx_Seminars_Model_Event the event with the publication hash
     *                                 provided, will be NULL if no event could
     *                                 be found
     */
    public function findByPublicationHash($publicationHash)
    {
        if ($publicationHash == '') {
            throw new InvalidArgumentException('The given publication hash was empty.', 1333292411);
        }

        try {
            /** @var Tx_Seminars_Model_Event $result */
            $result = $this->findSingleByWhereClause(['publication_hash' => $publicationHash]);
        } catch (Tx_Oelib_Exception_NotFound $exception) {
            $result = null;
        }

        return $result;
    }

    /**
     * Retrieves all events that have a begin date of at least $minimum up to
     * $maximum.
     *
     * These boundaries are inclusive, i.e., events with a begin date of
     * exactly $minimum or $maximum will also be retrieved.
     *
     * @param int $minimum
     *        minimum begin date as a UNIX timestamp, must be >= 0
     * @param int $maximum
     *        maximum begin date as a UNIX timestamp, must be >= $minimum
     *
     * @return Tx_Oelib_List the found Tx_Seminars_Model_Event models, will be
     *                       empty if there are no matches
     */
    public function findAllByBeginDate($minimum, $maximum)
    {
        if ($minimum < 0) {
            throw new InvalidArgumentException('$minimum must be >= 0.');
        }
        if ($maximum <= 0) {
            throw new InvalidArgumentException('$maximum must be > 0.');
        }
        if ($minimum > $maximum) {
            throw new InvalidArgumentException('$minimum must be <= $maximum.');
        }

        return $this->findByWhereClause(
            'begin_date BETWEEN ' . $minimum . ' AND ' . $maximum
        );
    }

    /**
     * Returns the next upcoming event.
     *
     * @return Tx_Seminars_Model_Event the next upcoming event
     *
     * @throws Tx_Oelib_Exception_NotFound
     */
    public function findNextUpcoming()
    {
        $whereClause = $this->getUniversalWhereClause() . ' AND cancelled <> ' . Tx_Seminars_Model_Event::STATUS_CANCELED .
            ' AND object_type <> ' . Tx_Seminars_Model_Event::TYPE_TOPIC . ' AND begin_date > ' . $GLOBALS['SIM_ACCESS_TIME'];

        try {
            $row = Tx_Oelib_Db::selectSingle(
                $this->columns,
                $this->tableName,
                $whereClause,
                '',
                'begin_date ASC'
            );
        } catch (Tx_Oelib_Exception_EmptyQueryResult $exception) {
            throw new Tx_Oelib_Exception_NotFound();
        }

        return $this->getModel($row);
    }

    /**
     * Finds events that have the status "planned" and that have the automatic status change enabled.
     *
     * @return Tx_Oelib_List the Tx_Oelib_List<Tx_Seminars_Model_Event>
     */
    public function findForAutomaticStatusChange()
    {
        $whereClause = 'cancelled = ' . Tx_Seminars_Model_Event::STATUS_PLANNED . ' AND automatic_confirmation_cancelation = 1';

        return $this->findByWhereClause($whereClause);
    }
}
