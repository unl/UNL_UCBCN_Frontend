<?php
namespace UNL\UCBCN\Frontend;

use UNL\UCBCN\Event\Occurrence;
use UNL\UCBCN\Event\RecurringDate;

class EventInstance implements RoutableInterface
{
    /**
     * The event date & time record
     *
     * @var \UNL\UCBCN\Event\Occurrence
     */
    public $eventdatetime;

    /**
     * The event details
     *
     * @var \UNL\UCBCN\Event
     */
    public $event;

    /**
     * @var RecurringDate
     */
    public $recurringdate;

    /**
     * Calendar \UNL\UCBCN\Frontend\Calendar Object
     *
     * @var \UNL\UCBCN\Frontend\Calendar
     */
    public $calendar;
    
    public $options;

    function __construct($options = array())
    {
        if (!isset($options['id'])) {
            throw new InvalidArgumentException('No event specified', 404);
        }
        
        if (!isset($options['calendar'])) {
            throw new InvalidArgumentException('A calendar must be set', 500);
        }
        
        $this->calendar = $options['calendar'];
        
        $this->eventdatetime = Occurrence::getById($options['id']);

        if (false === $this->eventdatetime) {
            throw new UnexpectedValueException('No event with that id exists', 404);
        }
        
        //Find the requested date, and ensure format
        $requestedDate = date('Y-m-d', strtotime($this->eventdatetime->starttime));
        if (isset($options['y'], $options['m'], $options['d'])) {
            $requestedDate = date('Y-m-d', strtotime($options['y'] . '-' . $options['m'] . '-' . $options['d']));
        }
        
        //Set the recurring date
        if (isset($options['recurringdate_id'])) {
            //Set the recurring date by the id
            $this->recurringdate = RecurringDate::getByID($options['recurringdate_id']);
        } else if ($requestedDate != date('Y-m-d', strtotime($this->eventdatetime->starttime))) {
            //Try to find the recurring date by the eventdatetime.id and Y/m/d
            $this->recurringdate = RecurringDate::getByAnyField(
                '\\UNL\\UCBCN\\Event\\RecurringDate',
                'recurringdate',
                $requestedDate,
                'event_id = ' . (int)$this->eventdatetime->event_id
            );
        }

        $this->event = $this->eventdatetime->getEvent();
        $this->options = $options;
    }

    /**
     * Get an event instance
     *
     * @param int $id Primary Key for eventdatetime table
     *
     * @return \UNL\UCBCN\Frontend\EventInstance
     */
    public static function getById($id)
    {
        return new self(array('id'=>$id));
    }

    /**
     * @return string - The absolute url for the event instance
     */
    public function getURL()
    {
        return $this->calendar->getURL() . date('Y/m/d/', strtotime($this->getStartTime())) . $this->eventdatetime->id . '/';
    }
    
    public function getImageURL()
    {
        if (isset($this->event->imageurl)) {
            return $this->event->imageurl;
        } elseif (isset($this->event->imagedata)) {
            return Controller::$url . 'images/' . $this->event->id;
        }
        
        return false;
    }

    /**
     * Determines if this is an ongoing event.
     *
     * An 'ongoing' event is defined as an event that spans more than one day.
     *
     * @return bool
     */
    public function isOngoing()
    {
        if (empty($this->eventdatetime->endtime)) {
            return false;
        }
        
        $start = date('m-d-Y', strtotime($this->eventdatetime->starttime));
        $end   = date('m-d-Y', strtotime($this->eventdatetime->endtime));

        //It is not an ongoing event if it starts and ends on the same day.
        if ($start == $end) {
            return false;
        }

        return true;
    }

    /**
     * Determines if this event is currently in progress.
     * 
     * @return bool
     */
    public function isInProgress()
    {
        $currentTime = time();
        
        if (strtotime($this->eventdatetime->starttime) > $currentTime) {
            //It has not started yet.
            return false;
        }

        if (strtotime($this->eventdatetime->endtime) < $currentTime) {
            //It already finished.
            return false;
        }

        return false;
    }

    /**
     * Determines if this event is an all day event.
     *
     * @return bool
     */
    public function isAllDay()
    {
        //It must start at midnight to be an all day event
        if (strpos($this->eventdatetime->starttime, '00:00:00') === false) {
            return false;
        }

        //It must end at midnight, or not have an end date.
        if (!empty($this->eventdatetime->endtime) &&
            strpos($this->eventdatetime->endtime, '00:00:00') === false) {
            return false;
        }

        return true;
    }

    /**
     * Get the start time for this event instance
     * 
     * Takes into account current recurring date, if present.
     * This should always be used instead of directly accessing $this->eventdatetime->starttime
     * 
     * @return string
     */
    public function getStartTime()
    {
        $time = $this->eventdatetime->starttime;
        
        if ($this->recurringdate) {
            $time = $this->recurringdate->recurringdate . ' ' . substr($time, 11);
        }

        return $time;
    }
    
    /**
     * Get the end time for this event instance
     * 
     * Takes into account the current recurring date, if present.
     * This should always be used instead of directly accessing $this->eventdatetime->endtime
     */
    public function getEndTime()
    {
        $time = $this->eventdatetime->endtime;
        
        if (empty($time)) {
            return $time;
        }

        if ($this->recurringdate) {
            $diff = strtotime($this->eventdatetime->endtime) - strtotime($this->eventdatetime->starttime);
            
            $time = date('Y-m-d H:i:s', strtotime($this->getStartTime()) + $diff);
        }
        
        return $time;
    }
    
    public function getShortDescription($maxChars = 250)
    {
        // normalize line endings
        $fullDescription = str_replace("\r\n", "\n", $this->event->description);
        
        // break on paragraphs
        $fullDescription = explode("\n", $fullDescription, 2);
        
        if (mb_strlen($fullDescription[0]) > $maxChars) {
            // find the maximum number of characters that do not break a word
            preg_match("/.{1,$maxChars}(?:\\b|$)/s", $fullDescription[0], $matches);
            return $matches[0] . ' …';
        }
        
        return $fullDescription[0];
    }
    
    public function toJSONData()
    {
        $startu     = strtotime($this->getStartTime());
        $endu       = strtotime($this->getEndTime());
        $location   = $this->eventdatetime->getLocation();
        $eventTypes = $this->event->getEventTypes();
        $webcasts   = $this->event->getWebcasts();
        $documents  = $this->event->getDocuments();
        $contacts   = $this->event->getPublicContacts();
        $data       = array();


        $data['EventID']       = $this->event->id;
        $data['EventTitle']    = $this->event->title;
        $data['EventSubtitle'] = $this->event->subtitle;
        $data['DateTime'] = array(
            'Start' => date('c', $startu),
            'End'   => date('c', $endu),
        );
        $data['EventStatus']           = 'Happening As Scheduled';
        $data['Classification']        = 'Public';
        $data['Languages']['Language'] = 'en-US';
        $data['EventTransparency']     = $this->event->transparency;
        $data['Description']           = $this->event->description;
        $data['ShortDescription']      = $this->event->shortdescription;
        $data['Refreshments']          = $this->event->refreshments;

        $data['Locations'] = array();
        if ($location) {
            $data['Locations'][0] = array(
                'LocationID'    => $location->id,
                'LocationName'  => $location->name,
                'LocationTypes' => array('LocationType' => $location->type),
                'Address' => array(
                    'Room'                 => $this->eventdatetime->room,
                    'BuildingName'         => $location->name,
                    'CityName'             => $location->city,
                    'PostalZone'           => $location->zip,
                    'CountrySubentityCode' => $location->state,
                    'Country' => array(
                        'IdentificationCode' => 'US',
                        'Name'               => 'United States',
                    ),
                ),
                'Phones' => array(
                    0 => array(
                        'PhoneNumber' => $location->phone,
                    )
                ),
                'WebPages' => array(
                    0 => array(
                        'Title' => 'Location Web Page',
                        'URL'   => $location->webpageurl,
                    )
                ),
                'MapLinks' => array(
                    0 => $location->mapurl,
                ),
                'LocationHours'        => $location->hours,
                'Directions'           => $location->directions,
                'AdditionalPublicInfo' => $location->additionalpublicinfo,
            );
        }

        if ($eventTypes->count()) {
            $data['EventTypes'] = array();
            foreach ($eventTypes as $eventHasType) {
                $type = $eventHasType->getType();
                if ($type) {
                    $data['EventTypes'][] = array(
                        'EventTypeID'          => $type->id,
                        'EventTypeName'        => $type->name,
                        'EventTypeDescription' => $type->description,
                    );
                }
            }
        }

        $data['WebPages'] = array();
        $data['WebPages'][] = array(
            'Title' => 'Event Instance URL',
            'URL'   => $this->getURL(),
        );

        if ($this->event->webpageurl) {
            $data['WebPages'][] = array(
                'Title' => 'Event webpage',
                'URL'   => $this->event->webpageurl,
            );
        }

        if ($webcasts->count()) {
            $data['Webcasts'] = array();
            foreach ($webcasts as $webcast) {
                $webcast_data = array();
                $webcast_data['Title']         = $webcast->title;
                $webcast_data['WebcastStatus'] = $webcast->status;
                $webcast_data['DateAvailable'] = date('Y-m-d',strtotime($webcast->dateavailable));
                $webcast_data['PlayerType']    = $webcast->playertype;
                $webcast_data['Bandwidth']     = $webcast->bandwidth;

                $webcastLinks = $webcast->getLinks();
                if ($webcastLinks->count()) {
                    $webcast_data['WebcastURLs'] = array();
                    foreach ($webcastLinks as $webcastLink) {
                        $linkURL = array(
                            'URL'            => $webcastLink->url,
                            'SequenceNumber' => $webcastLink->sequencenumber,
                        );
                        $webcast_data['WebcastURLs'][] = $linkURL;
                    }
                }
                $data['Webcasts'][] = $webcast_data;
            }
        }

        if (isset($this->event->imagedata)) {
            $data['Images'][0] = array(
                'Title'       => 'Image',
                'Description' => 'image for event ' . $this->event->id,
                'URL'         => \UNL\UCBCN\Frontend\Controller::$url . '?image&amp;id=' . $this->event->id,
            );
        }

        if ($documents->count()) {
            $data['Documents'] = array();
            foreach ($documents as $document) {
                $data['Documents'][] = array(
                    'Title' => $document->name,
                    'URL'   => $document->url,
                );
            }
        }

        if ($contacts->count()) {
            $data['PublicEventContacts'] = array();
            foreach ($contacts as $contact) {
                $data['PublicEventContacts'][] = array(
                    'PublicEventContactID' => $contact->id,
                    'ContactName' => array(
                        'FullName' => $contact->name,
                    ),
                    'ProfessionalAffiliations' => array(
                        0 => array(
                            'JobTitles' => array(
                                0 => $contact->jobtitle,
                            ),
                            'OrganizationName' => $contact->organization,
                            'OrganizationWebPages' => array(
                                0 => array(
                                    'Title' => $contact->name,
                                    'URL'   => $contact->webpageurl,
                                ),
                            )
                        ),
                    ),
                    'Phones' => array(
                        0 => array(
                            'PhoneNumber' => $contact->phone,
                        ),
                    ),
                    'EmailAddresses' => array(
                        0 => $contact->emailaddress
                    ),
                    'Addresses' => array(
                        0 => array(
                            'StreetName'           => $contact->addressline1,
                            'AdditionalStreetName' => $contact->addressline2,
                            'Room'                 => $contact->room,
                            'CityName'             => $contact->city,
                            'PostalZone'           => $contact->zip,
                            'CountrySubentityCode' => $contact->State,
                            'Country' => array(
                                'IdentificationCode' => 'US',
                                'Name' => 'United States',
                            ),
                        ),
                    ),
                    'WebPages' => array(
                        0 => array(
                            'Title' => $contact->name,
                            'URL'   => $contact->webpageurl,
                        ),
                    ),
                );
            }
        }

        $data['PublicEventContacts'] = array(
            0 => array(
                'ContactName' => array(
                    'FullName' => $this->event->listingcontactname,
                ),
                'Phones' => array(
                    0 => array(
                        'PhoneNumber' => $this->event->listingcontactphone,
                    ),
                ),
                'EmailAddresses' => array(
                    0 => $this->event->listingcontactemail,
                ),
            ),
        );

        if (!empty($this->event->privatecomment)) {
            $data['PrivateComments'] = array(
                0 => $this->event->privatecomment,
            );
        }

        return $data;
	}

    public function getMonthWidget()
    {
        return new MonthWidget($this->options);
    }
}
