	<Event>
        <EventID><?php echo $context->event->id; ?></EventID>
        <EventTitle><?php echo htmlspecialchars($context->event->title); ?></EventTitle>
        <EventSubtitle><?php echo htmlspecialchars($context->event->subtitle); ?></EventSubtitle>
        <?php 
        $startu = strtotime($context->getStartTime());
		$endu = strtotime($context->getEndTime());
		?>
        <DateTime>
            <StartDate><?php echo date('Y-m-d', $startu); ?></StartDate>
            <StartTime><?php echo date('H:i:s', $startu); ?>Z</StartTime>
            <?php if (isset($context->eventdatetime->endtime)
                    && !empty($context->eventdatetime->endtime)
                    && ($endu > $startu)) : ?>
            <EndDate><?php echo date('Y-m-d', $endu); ?></EndDate>
            <EndTime><?php echo date('H:i:s', $endu); ?>Z</EndTime>
            <?php endif; ?>
        </DateTime>
        <Locations>
        	<?php
			if ($context->eventdatetime->location_id) :
                $loc = $context->eventdatetime->getLocation();
			?>
            <Location>
                <LocationID><?php echo $loc->id; ?></LocationID>
                <LocationName><?php echo htmlspecialchars($loc->name); ?></LocationName>
                <LocationTypes>
                    <LocationType><?php echo $loc->type; ?></LocationType>
                </LocationTypes>
                <Address>
                    <Room><?php echo htmlspecialchars($context->eventdatetime->room); ?></Room>
                    <BuildingName><?php echo htmlspecialchars($loc->name); ?></BuildingName>
                    <CityName><?php echo htmlspecialchars($loc->city); ?></CityName>
                    <PostalZone><?php echo $loc->zip; ?></PostalZone>
                    <CountrySubentityCode><?php echo $loc->state; ?></CountrySubentityCode>
                    <Country>
                        <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>
                        <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                    </Country>
                </Address>
                <Phones>
                    <Phone>
                        <PhoneNumber><?php echo $loc->phone; ?></PhoneNumber>
                    </Phone>
                </Phones>

                <WebPages>
                    <WebPage>
                        <Title>Location Web Page</Title>
                        <URL><?php echo htmlspecialchars($loc->webpageurl); ?></URL>
                    </WebPage>
                </WebPages>
                <MapLinks>
                    <MapLink><?php echo htmlspecialchars($loc->mapurl); ?></MapLink>
                </MapLinks>

                <LocationHours><?php echo htmlspecialchars($loc->hours); ?></LocationHours>
                <Directions><?php echo htmlspecialchars($loc->directions); ?></Directions>
                <AdditionalPublicInfo><?php echo htmlspecialchars($loc->additionalpublicinfo); ?></AdditionalPublicInfo>
            </Location>
            <?php endif; ?>
        </Locations>
        <?php
        $eventTypes = $context->event->getEventTypes();
        if ($eventTypes->count()) : ?>
        <EventTypes>
        	<?php foreach ($eventTypes as $eventHasType) : 
        		$type = $eventHasType->getType();
	        	if ($type) : ?>
	            <EventType>
	                <EventTypeID><?php echo $type->id; ?></EventTypeID>
	                <EventTypeName><?php echo htmlspecialchars($type->name); ?></EventTypeName>
	                <EventTypeDescription><?php echo htmlspecialchars($type->description); ?></EventTypeDescription>
	            </EventType>
	            <?php 
            	endif;
            endforeach; ?>
        </EventTypes>
        <?php endif; ?>
        <Languages>
            <Language>en-US</Language>
        </Languages>
        <EventTransparency><?php echo $context->event->transparency; ?></EventTransparency>

        <Description><?php echo htmlspecialchars($context->event->description); ?></Description>
        <ShortDescription><?php echo htmlspecialchars($context->event->shortdescription); ?></ShortDescription>
        <Refreshments><?php echo htmlspecialchars($context->event->refreshments); ?></Refreshments>
        <WebPages>
            <WebPage>
                <Title>Event Instance URL</Title>
                <URL><?php echo htmlspecialchars($context->getURL()); ?></URL>
            </WebPage>
            <?php if (!empty($context->event->webpageurl)): ?>
            <WebPage>
                <Title>Event webpage</Title>
                <URL><?php echo htmlspecialchars($context->event->webpageurl); ?></URL>
            </WebPage>
            <?php endif; ?>
        </WebPages>
        <?php
        $webcasts = $context->event->getWebcasts();
        if ($webcasts->count()): ?>
        <Webcasts>
        	<?php foreach ($webcasts as $webcast) : ?>
            <Webcast>
                <Title><?php echo htmlspecialchars($webcast->title); ?></Title>
                <WebcastStatus><?php echo $webcast->status; ?></WebcastStatus>
                <DateAvailable><?php echo date('Y-m-d',strtotime($webcast->dateavailable)); ?></DateAvailable>
                <PlayerType><?php echo $webcast->playertype; ?></PlayerType>
                <Bandwidth><?php echo $webcast->bandwidth; ?></Bandwidth>
                <?php
                $webcastLinks = $webcast->getLinks();
                if ($webcastLinks->count()) : ?>
                <WebcastURLs>
                	<?php foreach ($webcastLinks as $webcastlink) : ?>
                    <WebcastURL>
                        <URL><?php echo $webcastLink->url; ?></URL>
                        <SequenceNumber><?php echo $webcastLink->sequencenumber; ?></SequenceNumber>
                    </WebcastURL>
                    <?php endforeach; ?>
                </WebcastURLs>
                <?php endif; ?>
                <WebcastAdditionalInfo><?php echo htmlspecialchars($webcast->additionalinfo); ?></WebcastAdditionalInfo>
            </Webcast>
            <?php endforeach; ?>
        </Webcasts>
        <?php endif; ?>
        <?php if (isset($context->event->imagedata)) : ?>
        <Images>
            <Image>
                <Title>Image</Title>
                <Description>image for event <?php echo $context->event->id; ?></Description>
                <URL><?php echo \UNL\UCBCN\Frontend\Controller::$url; ?>?image&amp;id=<?php echo $context->event->id; ?></URL>
            </Image>
        </Images>
        <?php endif; ?>
        <?php
        $documents = $context->event->getDocuments();
        if ($documents->count()) : ?>
        <Documents>
        	<?php foreach ($documents as $document) : ?>
            <Document>
                <Title><?php echo htmlspecialchars($document->name); ?></Title>
                <URL><?php echo $document->url; ?></URL>
            </Document>
            <?php endforeach; ?>
        </Documents>
        <?php endif; ?>
        <?php
        $contacts = $context->event->getPublicContacts();
        if ($contacts->count()) : ?>
        <PublicEventContacts>
        	<?php foreach ($contacts as $contact) : ?>
            <PublicEventContact>
                <PublicEventContactID><?php echo $contact->id; ?></PublicEventContactID>

                <ContactName>
                    <FullName><?php echo htmlspecialchars($contact->name); ?></FullName>
                </ContactName>
                <ProfessionalAffiliations>
                    <ProfessionalAffiliation>

                        <JobTitles>
                            <JobTitle><?php echo htmlspecialchars($contact->jobtitle); ?></JobTitle>
                        </JobTitles>
                        <OrganizationName><?php echo htmlspecialchars($contact->organization); ?></OrganizationName>
                        <OrganizationWebPages>
                            <WebPage>

                                <Title><?php echo htmlspecialchars($contact->name); ?></Title>
                                <URL><?php echo $contact->webpageurl; ?></URL>
                            </WebPage>

                        </OrganizationWebPages>
                    </ProfessionalAffiliation>
                </ProfessionalAffiliations>
                <Phones>
                    <Phone>
                        <PhoneNumber><?php echo htmlspecialchars($contact->phone); ?></PhoneNumber>
                    </Phone>
                </Phones>

                <EmailAddresses>
                    <EmailAddress><?php echo $contact->emailaddress; ?></EmailAddress>
                </EmailAddresses>
                <Addresses>
                    <Address>
                        <StreetName><?php echo htmlspecialchars($contact->addressline1); ?></StreetName>
                        <AdditionalStreetName><?php echo htmlspecialchars($contact->addressline2); ?></AdditionalStreetName>
                        <Room><?php echo htmlspecialchars($contact->room); ?></Room>
                        <CityName><?php echo htmlspecialchars($contact->city); ?></CityName>
                        <PostalZone><?php echo $contact->zip; ?></PostalZone>
                        <CountrySubentityCode><?php echo htmlspecialchars($contact->State); ?></CountrySubentityCode>
                        <Country>
                            <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>

                            <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                        </Country>
                    </Address>
                </Addresses>
                <WebPages>
                    <WebPage>
                        <Title><?php echo htmlspecialchars($contact->name); ?></Title>
                        <URL><?php echo $contact->webpageurl; ?></URL>
                    </WebPage>
                </WebPages>
            </PublicEventContact>
            <?php endforeach; ?>
        </PublicEventContacts>
        <?php endif; ?>
        <EventListingContacts>

            <EventListingContact>
                <ContactName>
                    <FullName><?php echo htmlspecialchars($context->event->listingcontactname); ?></FullName>
                </ContactName>
                <Phones>
                    <Phone>
                        <PhoneNumber><?php echo htmlspecialchars($context->event->listingcontactphone); ?></PhoneNumber>
                    </Phone>
                </Phones>
                <EmailAddresses>
                    <EmailAddress><?php echo $context->event->listingcontactemail; ?></EmailAddress>
                </EmailAddresses>
            </EventListingContact>
        </EventListingContacts>
        <EventStatus>Happening As Scheduled</EventStatus>
        <Classification>Public</Classification>
        <?php if (!empty($context->event->privatecomment)): ?>
        <PrivateComments>
            <PrivateComment><?php echo htmlspecialchars($context->event->privatecomment); ?></PrivateComment>
        </PrivateComments>
        <?php endif; ?>
    </Event>
