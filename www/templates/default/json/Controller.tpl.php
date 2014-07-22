<?php
function convertEventToJsonArray($eventInstance)
{
    $startu     = strtotime($eventInstance->eventdatetime->starttime);
    $endu       = strtotime($eventInstance->eventdatetime->endtime);
    $location   = $eventInstance->eventdatetime->getLocation();
    $eventTypes = $eventInstance->event->getEventTypes();
    $webcasts   = $eventInstance->event->getWebcasts();
    $documents  = $eventInstance->event->getDocuments();
    $contacts   = $eventInstance->event->getPublicContacts();
    $data       = array();
    
    
    $data['EventID']       = $eventInstance->event->id;
    $data['EventTitle']    = $eventInstance->event->title;
    $data['EventSubtitle'] = $eventInstance->event->subtitle;
    $data['DateTime'] = array(
        'StartDate' => date('Y-m-d', $startu),
        'StartTime' => date('H:i:s', $startu),
        'EndDate'   => date('Y-m-d', $endu),
        'EndTime'   => date('H:i:s', $endu),
    );
    $data['EventStatus']           = 'Happening As Scheduled';
    $data['Classification']        = 'Public';
    $data['Languages']['Language'] = 'en-US';
    $data['EventTransparency']     = $eventInstance->event->transparency;
    $data['Description']           = htmlspecialchars($eventInstance->event->description);
    $data['ShortDescription']      = htmlspecialchars($eventInstance->event->shortdescription);
    $data['Refreshments']          = htmlspecialchars($eventInstance->event->refreshments);
    
    $data['Locations'] = array();
    if ($location) {
        $data['Locations'][0] = array(
            'LocationID'    => $location->id,
            'LocationName'  => htmlspecialchars($location->name),
            'LocationTypes' => array('LocationType' => $location->type),
            'Address' => array(
                'Room'                 => htmlspecialchars($eventInstance->eventdatetime->room),
                'BuildingName'         => htmlspecialchars($location->name),
                'CityName'             => htmlspecialchars($location->city),
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
                    'URL'   => htmlspecialchars($location->webpageurl),
                )
            ),
            'MapLinks' => array(
                0 => htmlspecialchars($location->mapurl),
            ),
            'LocationHours'        => htmlspecialchars($location->hours),
            'Directions'           => htmlspecialchars($location->directions),
            'AdditionalPublicInfo' => htmlspecialchars($location->additionalpublicinfo),
        );
    }
    
    if ($eventTypes->count()) {
        $data['EventTypes'] = array();
        foreach ($eventTypes as $eventHasType) {
            $type = $eventHasType->getType();
            if ($type) {
                $data['EventTypes'][] = array(
                    'EventTypeID'          => $type->id,
                    'EventTypeName'        => htmlspecialchars($type->name),
                    'EventTypeDescription' => htmlspecialchars($type->description),
                );
            }
        }
    }
    
    $data['WebPages'] = array();
    $data['WebPages'][] = array(
        'Title' => 'Event Instance URL',
        'URL'   => htmlspecialchars($eventInstance->getURL()),
    );

   if ($eventInstance->event->webpageurl) {
       $data['WebPages'][] = array(
           'Title' => 'Event webpage',
           'URL'   => htmlspecialchars($eventInstance->event->webpageurl),
       );
   }
    
    if ($webcasts->count()) {
        $data['Webcasts'] = array();
        foreach ($webcasts as $webcast) {
            $webcast_data = array();
            $webcast_data['Title']         = htmlspecialchars($webcast->title);
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
    
    if (isset($eventInstance->event->imagedata)) {
        $data['Images'][0] = array(
            'Title'       => 'Image',
            'Description' => 'image for event ' . $eventInstance->event->id,
            'URL'         => \UNL\UCBCN\Frontend\Controller::$url . '?image&amp;id=' . $eventInstance->event->id,
        );
    }
    
    if ($documents->count()) {
        $data['Documents'] = array();
        foreach ($documents as $document) {
            $data['Documents'][] = array(
                'Title' => htmlspecialchars($document->name),
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
                    'FullName' => htmlspecialchars($contact->name),
                ),
                'ProfessionalAffiliations' => array(
                    0 => array(
                        'JobTitles' => array(
                            0=>htmlspecialchars($contact->jobtitle)
                        ),
                        'OrganizationName' => htmlspecialchars($contact->organization),
                        'OrganizationWebPages' => array(
                            0 => array(
                                'Title' => htmlspecialchars($contact->name),
                                'URL'   => $contact->webpageurl,
                            ),
                        )
                    ),
                ),
                'Phones' => array(
                    0 => array(
                        'PhoneNumber' => htmlspecialchars($contact->phone),
                    ),
                ),
                'EmailAddresses' => array(
                    0 => $contact->emailaddress
                ),
                'Addresses' => array(
                    0 => array(
                        'StreetName'           => htmlspecialchars($contact->addressline1),
                        'AdditionalStreetName' => htmlspecialchars($contact->addressline2),
                        'Room'                 => htmlspecialchars($contact->room),
                        'CityName'             => htmlspecialchars($contact->city),
                        'PostalZone'           => htmlspecialchars($contact->zip),
                        'CountrySubentityCode' => htmlspecialchars($contact->State),
                        'Country' => array(
                            'IdentificationCode' => 'US',
                            'Name' => 'United States',
                        ),
                    ),
                ),
                'WebPages' => array(
                    0 => array(
                        'Title' => htmlspecialchars($contact->name),
                        'URL'   => $contact->webpageurl,
                    ),
                ),
            );
        }
    }

    $data['PublicEventContacts'] = array(
        0 => array(
            'ContactName' => array(
                'FullName' => htmlspecialchars($eventInstance->event->listingcontactname),
            ),
            'Phones' => array(
                0 => array(
                    'PhoneNumber' => htmlspecialchars($eventInstance->event->listingcontactphone),
                ),
            ),
            'EmailAddresses' => array(
                0 => $eventInstance->event->listingcontactemail,
            ),
        ),
    );

    if (!empty($eventInstance->event->privatecomment)) {
        $data['PrivateComments'] = array(
            0 => htmlspecialchars($eventInstance->event->privatecomment),
        ); 
    }
    
    return $data;
}

echo $savvy->render($context->output);
