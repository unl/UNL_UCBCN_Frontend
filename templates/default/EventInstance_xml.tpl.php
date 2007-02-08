	<Event>
        <EventID><?php echo $this->event->id; ?></EventID>
        <EventTitle><?php echo $this->event->title; ?></EventTitle>
        <EventSubtitle><?php echo $this->event->subtitle; ?></EventSubtitle>
        <?php 
        $startu = strtotime($this->eventdatetime->starttime);
		$endu = strtotime($this->eventdatetime->endtime);
		?>
        <DateTime>
            <StartDate><?php echo date('Y-m-d', $startu); ?></StartDate>
            <StartTime><?php echo date('H:m:s', $startu); ?>Z</StartTime>
            <EndDate><?php echo date('Y-m-d', $endu); ?></EndDate>
            <EndTime><?php echo date('H:m:s', $endu); ?>Z</EndTime>
        </DateTime>
        <Locations>
        	<?php
        	$loc = $this->eventdatetime->getLink('location_id');
			if (!PEAR::isError($loc)) : ?>
            <Location>
                <LocationID><?php echo $loc->id; ?></LocationID>
                <LocationName><?php echo $loc->name; ?></LocationName>
                <LocationTypes>
                    <LocationType><?php echo $loc->type; ?></LocationType>
                </LocationTypes>
                <Address>
                    <AddressID>32</AddressID>
                    <Room><?php echo $loc->room; ?></Room>

                    <StreetName>Hearst</StreetName>
                    <AdditionalStreetName>Another Name</AdditionalStreetName>
                    <BuildingName>Boalt Hall</BuildingName>
                    <BuildingNumber>222</BuildingNumber>
                    <Department>Law School</Department>

                    <CityName><?php echo $loc->city; ?></CityName>
                    <PostalZone><?php echo $loc->zip; ?></PostalZone>
                    <CountrySubentity>Nebraska</CountrySubentity>
                    <CountrySubentityCode><?php echo $loc->state; ?></CountrySubentityCode>
                    <Region>Midwest</Region>

                    <TimezoneOffset>-6:00</TimezoneOffset>
                    <Country>
                        <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>
                        <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                    </Country>
                    <?php if (false) : ?>
                    <LocationCoordinate>
                        <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>

                        <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>
                        <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>
                        <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>
                        <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                        <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                        <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>

                    </LocationCoordinate>
                    <?php endif; ?>
                </Address>
                <Phones>
                    <Phone>
                        <PhoneNumber><?php echo $loc->phone; ?></PhoneNumber>
                    </Phone>
                </Phones>

                <WebPages>
                    <WebPage>
                        <Title>Location Web Page</Title>
                        <URL><?php echo $loc->webpageurl; ?></URL>
                    </WebPage>
                </WebPages>
                <MapLinks>
                    <MapLink><?php echo $loc->mapurl; ?></MapLink>
                </MapLinks>

                <LocationHours><?php echo $loc->hours; ?></LocationHours>
                <Directions><?php echo $loc->directions; ?></Directions>
                <AdditionalPublicInfo><?php echo $loc->additionalpublicinfo; ?></AdditionalPublicInfo>
            </Location>
            <?php endif; ?>
        </Locations>
        <?php
        $etype = UNL_UCBCN::factory('event_has_eventtype');
        $etype->event_id = $this->event->id;
        if ($etype->find()) : ?>
        <EventTypes>
        	<?php while ($etype->fetch()) : 
        		$type = $etype->getLink('eventtype_id');
	        	if (!PEAR::isError($type)) : ?>
	            <EventType>
	                <EventTypeID><?php echo $type->id; ?></EventTypeID>
	                <EventTypeName><?php echo $type->name; ?></EventTypeName>
	                <EventTypeDescription><?php echo $type->description; ?></EventTypeDescription>
	            </EventType>
	            <?php 
            	endif;
            endwhile; ?>
        </EventTypes>
        <?php endif; ?>
        <Languages>
            <Language>en-US</Language>
        </Languages>
        <EventTransparency><?php echo $this->event->transparency; ?></EventTransparency>

        <Description><?php echo $this->event->description; ?></Description>
        <ShortDescription><?php echo $this->event->description; ?></ShortDescription>
        <Refreshments><?php echo $this->event->refreshments; ?></Refreshments>
        <?php if (!empty($this->event->webpageurl)): ?>
        <WebPages>
            <WebPage>
                <Title>Event webpage</Title>
                <URL><?php echo $this->event->webpageurl; ?></URL>
            </WebPage>
        </WebPages>
        <?php endif; ?>
        <?php
        $webcast = UNL_UCBCN::factory('webcast');
        $webcast->event_id = $this->event->id;
        if ($webcast->find()): ?>
        <Webcasts>
        	<?php while ($webcast->fetch()) : ?>
            <Webcast>
                <Title><?php echo $webcast->title; ?></Title>
                <WebcastStatus><?php echo $webcast->status; ?></WebcastStatus>
                <DateAvailable><?php echo date('Y-m-d',strtotime($webcast->dateavailable)); ?></DateAvailable>
                <PlayerType><?php echo $webcast->playertype; ?></PlayerType>
                <Bandwidth><?php echo $webcast->bandwidth; ?></Bandwidth>
                <?php
                $webcastlink = UNL_UCBCN::factory('webcastlink');
                $webcastlink->webcast_id = $webcast->id;
                if ($webcastlink->find()) : ?>
                <WebcastURLs>
                	<?php while ($webcastlink->fetch()) : ?>
                    <WebcastURL>
                        <URL><?php echo $webcastlink->url; ?></URL>
                        <SequenceNumber><?php echo $webcastlink->sequencenumber; ?></SequenceNumber>
                    </WebcastURL>
                    <?php endwhile; ?>
                </WebcastURLs>
                <?php endif; ?>
                <WebcastAdditionalInfo><?php echo $webcast->additionalinfo; ?></WebcastAdditionalInfo>
            </Webcast>
            <?php endwhile; ?>
        </Webcasts>
        <?php endif; ?>
        <?php if (isset($this->event->imagedata)) : ?>
        <Images>
            <Image>
                <Title>Image</Title>
                <Description>image for event <?php echo $this->event->id; ?></Description>
                <URL><?php echo UNL_UCBCN_Frontend::formatURL(array()); ?>?image&amp;id=<?php echo $this->event->id; ?></URL>
            </Image>
        </Images>
        <?php endif; ?>
        <?php
        $document = UNL_UCBCN::factory('document');
        $document->event_id = $this->event->id;
        if ($document->find()) : ?>
        <Documents>
        	<?php while ($document->fetch()) : ?>
            <Document>
                <Title><?php echo $document->name; ?></Title>
                <URL><?php echo $document->url; ?></URL>
            </Document>
            <?php endwhile; ?>
        </Documents>
        <?php endif; ?>
        <?php if (false) : ?>
        <Participants>
            <Participant>
                <ParticipantID>55</ParticipantID>

                <Name>
                    <PersonalNameTitle>Mr.</PersonalNameTitle>
                    <FullName>James Earl Johnson Jones</FullName>
                    <FirstName>James</FirstName>
                    <MiddleNames>
                        <MiddleName>Earl</MiddleName>
                    </MiddleNames>
                    <LastName>Jones</LastName>
                    <PersonalNameSuffix>Jr.</PersonalNameSuffix>
                </Name>
                <ContactInfo>
                    <ContactName>
                        <PersonalNameTitle>Ms.</PersonalNameTitle>

                        <FullName>Kelly June Carter Cash</FullName>
                        <FirstName>Kelly</FirstName>
                        <MiddleNames>
                            <MiddleName>June</MiddleName>
                        </MiddleNames>
                        <LastName>Cash</LastName>

                        <PersonalNameSuffix>III</PersonalNameSuffix>
                    </ContactName>
                    <ProfessionalAffiliations>
                        <ProfessionalAffiliation>
                            <JobTitles>
                                <JobTitle>Producer</JobTitle>
                            </JobTitles>
                            <OrganizationName>IBM</OrganizationName>
                            <OrganizationWebPages>
                                <WebPage>
                                    <Title>IBM</Title>

                                    <URL>http://www.ibm.com</URL>
                                </WebPage>
                            </OrganizationWebPages>

                        </ProfessionalAffiliation>
                    </ProfessionalAffiliations>
                    <Phones>
                        <Phone>
                            <PhoneNumber>510-555-1235</PhoneNumber>
                            <PhoneNumberExtension>6</PhoneNumberExtension>
                            <PhoneNumberType>Work</PhoneNumberType>

                        </Phone>
                    </Phones>

                    <EmailAddresses>
                        <EmailAddress>james@jones.com</EmailAddress>
                    </EmailAddresses>
                    <Addresses>
                        <Address>
                            <AddressID>32</AddressID>

                            <Postbox>2195</Postbox>
                            <Floor>2nd</Floor>
                            <Room>202</Room>
                            <StreetName>Hearst</StreetName>
                            <AdditionalStreetName>Another Name</AdditionalStreetName>
                            <BuildingName>Boalt Hall</BuildingName>

                            <BuildingNumber>222</BuildingNumber>
                            <InhouseMail>R2205</InhouseMail>
                            <Department>Law School</Department>
                            <CityName>Berkeley</CityName>
                            <PostalZone>94720</PostalZone>
                            <CountrySubentity>California</CountrySubentity>

                            <CountrySubentityCode>CA</CountrySubentityCode>
                            <Region>West Coast</Region>
                            <District>Probably won't use this</District>
                            <TimezoneOffset>-7:00</TimezoneOffset>
                            <Country>
                                <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>

                                <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                            </Country>
                            <LocationCoordinate>
                                <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>
                                <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>
                                <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>
                                <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>

                                <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                                <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                                <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>
                            </LocationCoordinate>
                        </Address>
                    </Addresses>
                    <WebPages>
                        <WebPage>
                            <Title>Kelly's personal page</Title>
                            <URL>http://www.kelly.com</URL>
                        </WebPage>
                    </WebPages>
                    <PreferredContactMethod>Email</PreferredContactMethod>
                </ContactInfo>
                <ParticipantTypes>
                    <ParticipantType>Speaker - Featured</ParticipantType>
                </ParticipantTypes>
                <ProfessionalAffiliations>
                    <ProfessionalAffiliation>
                        <JobTitles>
                            <JobTitle>Actor</JobTitle>
                        </JobTitles>
                        <OrganizationName>Actor's Guild of America</OrganizationName>

                        <OrganizationWebPages>
                            <WebPage>
                                <Title>Actor's Guild of America - James Earl Jones</Title>
                                <URL>http://www.aga.com/jamesearljones</URL>
                            </WebPage>
                        </OrganizationWebPages>
                    </ProfessionalAffiliation>
                </ProfessionalAffiliations>
                <Images>

                    <Image>
                        <Title>James Earl Jones</Title>
                        <Description>James Earl Jones at the Oscars</Description>
                        <URL>http://www.jamesearl.com/oscar.jpg</URL>
                        <Height>500px</Height>
                        <Width>1000px</Width>

                        <FileSize>500KB</FileSize>
                    </Image>
                </Images>
                <WebPages>
                    <WebPage>
                        <Title>James Earl Jones' personal page</Title>
                        <URL>http://www.jamesearl.com</URL>
                    </WebPage>
                </WebPages>

                <Description>James Earl Jones has been a respected actor for many years. His first film was...</Description>
                <ParticipantParentID>55</ParticipantParentID>
            </Participant>
        </Participants>
        <Performers>
            <Performer>
                <PerformerID>502</PerformerID>

                <Name>
                    <PersonalNameTitle>Mr.</PersonalNameTitle>
                    <FullName>Johnny Harold Edward Cash, III</FullName>
                    <FirstName>Johnny</FirstName>
                    <MiddleNames>
                        <MiddleName>Harold</MiddleName>

                    </MiddleNames>
                    <LastName>Cash</LastName>
                    <PersonalNameSuffix>III</PersonalNameSuffix>
                </Name>
                <ContactInfo>
                    <ContactName>
                        <PersonalNameTitle>Ms.</PersonalNameTitle>

                        <FullName>Kelly June Carter Cash</FullName>
                        <FirstName>Kelly</FirstName>
                        <MiddleNames>
                            <MiddleName>June</MiddleName>
                        </MiddleNames>
                        <LastName>Cash</LastName>

                        <PersonalNameSuffix>III</PersonalNameSuffix>
                    </ContactName>
                    <ProfessionalAffiliations>
                        <ProfessionalAffiliation>
                            <JobTitles>

                                <JobTitle>Writer</JobTitle>
                            </JobTitles>
                            <OrganizationName>IBM</OrganizationName>
                            <OrganizationWebPages>
                                <WebPage>
                                    <Title>IBM</Title>

                                    <URL>http://www.ibm.com</URL>
                                </WebPage>
                            </OrganizationWebPages>

                        </ProfessionalAffiliation>
                    </ProfessionalAffiliations>
                    <Phones>
                        <Phone>
                            <PhoneNumber>510-555-1235</PhoneNumber>
                            <PhoneNumberExtension>6</PhoneNumberExtension>
                            <PhoneNumberType>Work</PhoneNumberType>

                        </Phone>
                    </Phones>

                    <EmailAddresses>
                        <EmailAddress>james@jones.com</EmailAddress>
                    </EmailAddresses>
                    <Addresses>
                        <Address>
                            <AddressID>32</AddressID>

                            <Postbox>2195</Postbox>
                            <Floor>2nd</Floor>
                            <Room>202</Room>
                            <StreetName>Hearst</StreetName>
                            <AdditionalStreetName>Another Name</AdditionalStreetName>
                            <BuildingName>Boalt Hall</BuildingName>

                            <BuildingNumber>222</BuildingNumber>
                            <InhouseMail>R2205</InhouseMail>
                            <Department>Law School</Department>
                            <CityName>Berkeley</CityName>
                            <PostalZone>94720</PostalZone>
                            <CountrySubentity>California</CountrySubentity>

                            <CountrySubentityCode>CA</CountrySubentityCode>
                            <Region>West Coast</Region>
                            <District>Probably won't use this</District>
                            <TimezoneOffset>-7:00</TimezoneOffset>
                            <Country>
                                <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>

                                <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                            </Country>
                            <LocationCoordinate>
                                <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>
                                <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>
                                <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>
                                <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>

                                <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                                <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                                <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>
                            </LocationCoordinate>
                        </Address>
                    </Addresses>
                    <WebPages>

                        <WebPage>
                            <Title>Kelly's personal page</Title>
                            <URL>http://www.kelly.com</URL>
                        </WebPage>
                    </WebPages>
                    <PreferredContactMethod>Email</PreferredContactMethod>
                </ContactInfo>
                <PerformerTypes>
                    <PerformerType>Speaker</PerformerType>
                </PerformerTypes>
                <ProfessionalAffiliations>
                    <ProfessionalAffiliation>
                        <JobTitles>
                            <JobTitle>Singer</JobTitle>
                        </JobTitles>
                        <OrganizationName>My Company</OrganizationName>

                        <OrganizationWebPages>
                            <WebPage>
                                <Title>Johnny Cash - the website</Title>
                                <URL>http://www.johnnycash.com</URL>
                            </WebPage>
                        </OrganizationWebPages>
                    </ProfessionalAffiliation>
                </ProfessionalAffiliations>
                <Images>

                    <Image>
                        <Title>Trees</Title>
                        <Description>Trees at UC Berkeley</Description>
                        <URL>http://www.berkeley.com/trees.jpg</URL>
                        <Height>100px</Height>
                        <Width>500px</Width>

                        <FileSize>500KB</FileSize>
                    </Image>
                </Images>
                <WebPages>
                    <WebPage>
                        <Title>Johnny Cash - My songs</Title>

                        <URL>http://www.cashsongs.com</URL>
                    </WebPage>
                </WebPages>

                <Description>Johnny started singing when he was very young...</Description>
                <PerformerParentID>55</PerformerParentID>
            </Performer>
        </Performers>
        <?php endif; ?>
        <Sponsors>
            <Sponsor>
                <SponsorID>505</SponsorID>

                <Name>
                    <OrganizationName>Haas School of Business</OrganizationName>
                </Name>
                <ProfessionalAffiliations>
                    <ProfessionalAffiliation>
                        <JobTitles>
                            <JobTitle>None</JobTitle>
                        </JobTitles>
                        <OrganizationName>None</OrganizationName>
                        <OrganizationWebPages>
                            <WebPage>
                                <Title>None</Title>

                                <URL>None</URL>
                            </WebPage>
                        </OrganizationWebPages>

                    </ProfessionalAffiliation>
                </ProfessionalAffiliations>
                <ContactInfo>
                    <ContactName>
                        <PersonalNameTitle>Ms.</PersonalNameTitle>
                        <FullName>Kelly June Carter Cash</FullName>
                        <FirstName>Kelly</FirstName>

                        <MiddleNames>
                            <MiddleName>June</MiddleName>
                        </MiddleNames>
                        <LastName>Cash</LastName>
                        <PersonalNameSuffix>III</PersonalNameSuffix>
                    </ContactName>

                    <ProfessionalAffiliations>
                        <ProfessionalAffiliation>
                            <JobTitles>
                                <JobTitle>Manager</JobTitle>
                            </JobTitles>
                            <OrganizationName>James Earl Jones, Inc.</OrganizationName>

                            <OrganizationWebPages>
                                <WebPage>
                                    <Title>James Earl Jones</Title>
                                    <URL>http://www.jamesearl.com</URL>
                                </WebPage>
                            </OrganizationWebPages>
                        </ProfessionalAffiliation>
                    </ProfessionalAffiliations>
                    <Phones>

                        <Phone>
                            <PhoneNumber>510-555-1235</PhoneNumber>
                            <PhoneNumberExtension>6</PhoneNumberExtension>
                            <PhoneNumberType>Work</PhoneNumberType>
                        </Phone>
                        <Phone>
                            <PhoneNumber>510-555-1235</PhoneNumber>

                            <PhoneNumberExtension>6</PhoneNumberExtension>
                            <PhoneNumberType>Work</PhoneNumberType>
                        </Phone>
                    </Phones>
                    <EmailAddresses>
                        <EmailAddress>james@jones.com</EmailAddress>
                    </EmailAddresses>
                    <Addresses>
                        <Address>
                            <AddressID>32</AddressID>
                            <Postbox>2195</Postbox>
                            <Floor>2nd</Floor>
                            <Room>202</Room>

                            <StreetName>Hearst</StreetName>
                            <AdditionalStreetName>Another Name</AdditionalStreetName>
                            <BuildingName>Boalt Hall</BuildingName>
                            <BuildingNumber>222</BuildingNumber>
                            <InhouseMail>R2205</InhouseMail>
                            <Department>Law School</Department>

                            <CityName>Berkeley</CityName>
                            <PostalZone>94720</PostalZone>
                            <CountrySubentity>California</CountrySubentity>
                            <CountrySubentityCode>CA</CountrySubentityCode>
                            <Region>West Coast</Region>
                            <District>Probably won't use this</District>

                            <TimezoneOffset>-7:00</TimezoneOffset>
                            <Country>
                                <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>
                                <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                            </Country>
                            <LocationCoordinate>
                                <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>

                                <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>
                                <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>
                                <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>
                                <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                                <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                                <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>

                            </LocationCoordinate>
                        </Address>
                    </Addresses>
                    <WebPages>
                        <WebPage>
                            <Title>Kelly's personal page</Title>
                            <URL>http://www.kelly.com</URL>
                        </WebPage>
                    </WebPages>
                    <PreferredContactMethod>Email</PreferredContactMethod>
                </ContactInfo>

                <SponsorTypes>
                    <SponsorType>Primary</SponsorType>
                </SponsorTypes>
                <Images>
                    <Image>
                        <Title>Trees</Title>

                        <Description>Trees at UC Berkeley</Description>
                        <URL>http://www.berkeley.com/trees.jpg</URL>
                        <Height>100px</Height>
                        <Width>500px</Width>
                        <FileSize>500KB</FileSize>
                    </Image>
                </Images>
                <WebPages>
                    <WebPage>
                        <Title>Haas School of Business</Title>
                        <URL>http://www.haas.berkeley.edu</URL>

                    </WebPage>
                </WebPages>
                <Description>Haas is UC Berkeley's esteemed business school.</Description>

                <SponsorParentID>50</SponsorParentID>
            </Sponsor>
        </Sponsors>
        <EventOwners>
            <EventOwner>
                <EventOwnerID>306</EventOwnerID>

                    <Name>
                        <OrganizationName>Haas School of Business</OrganizationName>
                    </Name>
                    <ProfessionalAffiliations>
                        <ProfessionalAffiliation>
                            <JobTitles>
                                <JobTitle>None</JobTitle>
                            </JobTitles>
                            <OrganizationName>None</OrganizationName>
                            <OrganizationWebPages>
                                <WebPage>
                                    <Title>None</Title>

                                    <URL>None</URL>
                                </WebPage>
                            </OrganizationWebPages>

                        </ProfessionalAffiliation>
                    </ProfessionalAffiliations>
                    <ContactInfo>
                        <ContactName>
                            <PersonalNameTitle>Ms.</PersonalNameTitle>
                            <FullName>Kelly June Carter Cash</FullName>
                            <FirstName>Kelly</FirstName>

                            <MiddleNames>
                                <MiddleName>June</MiddleName>
                            </MiddleNames>
                            <LastName>Cash</LastName>
                            <PersonalNameSuffix>III</PersonalNameSuffix>
                        </ContactName>

                        <ProfessionalAffiliations>
                            <ProfessionalAffiliation>
                                <JobTitles>
                                    <JobTitle>Manager</JobTitle>
                                    <JobTitle>Owner</JobTitle>
                                </JobTitles>
                                <OrganizationName>James Earl Jones, Inc.</OrganizationName>

                                <OrganizationWebPages>
                                    <WebPage>
                                        <Title>James Earl Jones</Title>
                                        <URL>http://www.jamesearl.com</URL>
                                    </WebPage>
                                    <WebPage>
                                        <Title>James Earl Jones</Title>

                                        <URL>http://www.jamesearl.com</URL>
                                    </WebPage>
                                </OrganizationWebPages>
                            </ProfessionalAffiliation>
                        </ProfessionalAffiliations>
                        <Phones>

                            <Phone>
                                <PhoneNumber>510-555-1235</PhoneNumber>
                                <PhoneNumberExtension>6</PhoneNumberExtension>
                                <PhoneNumberType>Work</PhoneNumberType>
                            </Phone>
                        </Phones>
                        <EmailAddresses>
                            <EmailAddress>james@jones.com</EmailAddress>
                        </EmailAddresses>
                        <Addresses>
                            <Address>
                                <AddressID>32</AddressID>
                                <Postbox>2195</Postbox>
                                <Floor>2nd</Floor>
                                <Room>202</Room>

                                <StreetName>Hearst</StreetName>
                                <AdditionalStreetName>Another Name</AdditionalStreetName>
                                <BuildingName>Boalt Hall</BuildingName>
                                <BuildingNumber>222</BuildingNumber>
                                <InhouseMail>R2205</InhouseMail>
                                <Department>Law School</Department>

                                <CityName>Berkeley</CityName>
                                <PostalZone>94720</PostalZone>
                                <CountrySubentity>California</CountrySubentity>
                                <CountrySubentityCode>CA</CountrySubentityCode>
                                <Region>West Coast</Region>
                                <District>Probably won't use this</District>

                                <TimezoneOffset>-7:00</TimezoneOffset>
                                <Country>
                                    <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>
                                    <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                                </Country>
                                <LocationCoordinate>
                                    <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>

                                    <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>
                                    <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>
                                    <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>
                                    <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                                    <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                                    <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>

                                </LocationCoordinate>
                            </Address>
                        </Addresses>
                        <WebPages>
                            <WebPage>
                                <Title>Kelly's personal page</Title>
                                <URL>http://www.kelly.com</URL>
                            </WebPage>
                        </WebPages>
                        <PreferredContactMethod>Email</PreferredContactMethod>
                    </ContactInfo>

                    <EventOwnerTypes>
                        <EventOwnerType>Primary</EventOwnerType>
                    </EventOwnerTypes>
                    <Images>
                        <Image>
                            <Title>Trees</Title>

                            <Description>Trees at UC Berkeley</Description>
                            <URL>http://www.berkeley.com/trees.jpg</URL>
                            <Height>100px</Height>
                            <Width>500px</Width>
                            <FileSize>500KB</FileSize>
                        </Image>
                    </Images>
                    <WebPages>
                        <WebPage>
                            <Title>Haas School of Business</Title>
                            <URL>http://www.haas.berkeley.edu</URL>

                        </WebPage>
                    </WebPages>
                    <Description>Haas is UC Berkeley's esteemed business school.</Description>

                <EventOwnerParentID></EventOwnerParentID>
            </EventOwner>
        </EventOwners>
        <PublicEventContacts>
            <PublicEventContact>
                <PublicEventContactID>502</PublicEventContactID>

                <ContactName>
                    <PersonalNameTitle>Mr.</PersonalNameTitle>
                    <FullName>Joe Donald Norman Namath</FullName>
                    <FirstName>Joe</FirstName>
                    <MiddleNames>
                        <MiddleName>Donald</MiddleName>
                    </MiddleNames>
                    <LastName>Namath</LastName>
                    <PersonalNameSuffix>Jr.</PersonalNameSuffix>
                </ContactName>
                <ProfessionalAffiliations>
                    <ProfessionalAffiliation>

                        <JobTitles>
                            <JobTitle>Football Player</JobTitle>
                            <JobTitle>Television Anchor</JobTitle>
                        </JobTitles>
                        <OrganizationName>NBC</OrganizationName>
                        <OrganizationWebPages>
                            <WebPage>

                                <Title>NBS</Title>
                                <URL>http://www.nbc.cm</URL>
                            </WebPage>

                        </OrganizationWebPages>
                    </ProfessionalAffiliation>
                </ProfessionalAffiliations>
                <Phones>
                    <Phone>
                        <PhoneNumber>510-555-1235</PhoneNumber>
                        <PhoneNumberExtension>888</PhoneNumberExtension>
                        <PhoneNumberType>Home</PhoneNumberType>

                    </Phone>
                </Phones>

                <EmailAddresses>
                    <EmailAddress>joe@namath.com</EmailAddress>
                </EmailAddresses>
                <Addresses>
                    <Address>
                        <AddressID>32</AddressID>

                        <Postbox>2195</Postbox>
                        <Floor>2nd</Floor>
                        <Room>202</Room>
                        <StreetName>Hearst</StreetName>
                        <AdditionalStreetName>Another Name</AdditionalStreetName>
                        <BuildingName>Boalt Hall</BuildingName>

                        <BuildingNumber>222</BuildingNumber>
                        <InhouseMail>R2205</InhouseMail>
                        <Department>Law School</Department>
                        <CityName>Berkeley</CityName>
                        <PostalZone>94720</PostalZone>
                        <CountrySubentity>California</CountrySubentity>

                        <CountrySubentityCode>CA</CountrySubentityCode>
                        <Region>West Coast</Region>
                        <District>Probably won't use this</District>
                        <TimezoneOffset>-7:00</TimezoneOffset>
                        <Country>
                            <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>

                            <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                        </Country>
                        <LocationCoordinate>
                            <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>
                            <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>
                            <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>
                            <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>

                            <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                            <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                            <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>
                        </LocationCoordinate>
                    </Address>
                </Addresses>
                <WebPages>
                    <WebPage>
                        <Title>Joe's page</Title>
                        <URL>http://www.joe.com</URL>
                    </WebPage>
                </WebPages>
                <PreferredContactMethod>Address</PreferredContactMethod>
                <PublicEventContactTypes>
                    <PublicEventContactType>Type 1</PublicEventContactType>
                </PublicEventContactTypes>

                <PublicEventContactParentID>555</PublicEventContactParentID>
            </PublicEventContact>
        </PublicEventContacts>
        <EventListingContacts>

            <EventListingContact>
                <EventListingContactID>305</EventListingContactID>
                <ContactName>
                    <PersonalNameTitle>Mr.</PersonalNameTitle>
                    <FullName>Joe Donald Norman Namath</FullName>
                    <FirstName>Joe</FirstName>
                    <MiddleNames>
                        <MiddleName>Norman</MiddleName>
                    </MiddleNames>
                    <LastName>Namath</LastName>
                    <PersonalNameSuffix>Jr.</PersonalNameSuffix>
                </ContactName>
                <ProfessionalAffiliations>
                    <ProfessionalAffiliation>
                        <JobTitles>
                            <JobTitle>Football Player</JobTitle>
                        </JobTitles>

                        <OrganizationName>NBC</OrganizationName>
                        <OrganizationWebPages>
                            <WebPage>
                                <Title>NBS</Title>
                                <URL>http://www.nbc.cm</URL>
                            </WebPage>
                        </OrganizationWebPages>
                    </ProfessionalAffiliation>
                </ProfessionalAffiliations>
                <Phones>
                    <Phone>
                        <PhoneNumber>510-555-1235</PhoneNumber>
                        <PhoneNumberExtension>888</PhoneNumberExtension>
                        <PhoneNumberType>Home</PhoneNumberType>
                    </Phone>
                </Phones>
                <EmailAddresses>
                    <EmailAddress>joe@namath.com</EmailAddress>
                </EmailAddresses>

                <Addresses>
                    <Address>
                        <AddressID>32</AddressID>
                        <Postbox>2195</Postbox>
                        <Floor>2nd</Floor>
                        <Room>202</Room>
                        <StreetName>Hearst</StreetName>

                        <AdditionalStreetName>Another Name</AdditionalStreetName>
                        <BuildingName>Boalt Hall</BuildingName>
                        <BuildingNumber>222</BuildingNumber>
                        <InhouseMail>R2205</InhouseMail>
                        <Department>Law School</Department>
                        <CityName>Berkeley</CityName>

                        <PostalZone>94720</PostalZone>
                        <CountrySubentity>California</CountrySubentity>
                        <CountrySubentityCode>CA</CountrySubentityCode>
                        <Region>West Coast</Region>
                        <District>Probably won't use this</District>
                        <TimezoneOffset>-7:00</TimezoneOffset>

                        <Country>
                            <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>
                            <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                        </Country>
                        <LocationCoordinate>
                            <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>
                            <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>

                            <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>
                            <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>
                            <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                            <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                            <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>
                        </LocationCoordinate>

                    </Address>
                </Addresses>
                <WebPages>
                    <WebPage>
                        <Title>Joe's page</Title>
                        <URL>http://www.joe.com</URL>
                    </WebPage>
                </WebPages>
                <PreferredContactMethod>Address</PreferredContactMethod>
                <EventListingContactTypes>
                    <EventListingContactType>Type 1</EventListingContactType>
                </EventListingContactTypes>
                <EventListingContactParentID>55</EventListingContactParentID>
            </EventListingContact>
        </EventListingContacts>
        <EventStatus>HappeningAsScheduled</EventStatus>
        <Classification>Public</Classification>

        <ChangeManagement>
            <DateCreated>2006-10-10</DateCreated>
            <DatesModified>
                <DateModified>2006-10-11</DateModified>
                <DateModified>2006-10-12</DateModified>
            </DatesModified>
            <LastModified>2006-10-12</LastModified>

            <SequenceNumber>3</SequenceNumber>
        </ChangeManagement>
        <EntryConditions>
            <TargetAudiences>
                <TargetAudience>Friends of the University</TargetAudience>
                <TargetAudience>Faculty</TargetAudience>
            </TargetAudiences>

            <OpenToAudiences>
                <OpenToAudience>Students - Graduate</OpenToAudience>
            </OpenToAudiences>
            <AttendanceRestrictions>
                <AttendanceRestriction>Bring ID</AttendanceRestriction>
            </AttendanceRestrictions>
            <AdmissionInfoGroups>
                <AdmissionInfoGroup>
                    <AdmissionInfoGroupTypes>
                        <AdmissionInfoGroupType>Tickets</AdmissionInfoGroupType>
                        <AdmissionInfoGroupType>Another Type</AdmissionInfoGroupType>
                    </AdmissionInfoGroupTypes>
                    <AdmissionInfoGroupObligation>Required</AdmissionInfoGroupObligation>

                    <AdmissionInfoGroupCharges>
                        <AdmissionInfoGroupCharge>
                            <Currency>$</Currency>
                            <Amount>50</Amount>
                            <Description>Students</Description>
                        </AdmissionInfoGroupCharge>
                        <AdmissionInfoGroupCharge>

                            <Currency>$</Currency>
                            <Amount>100</Amount>
                            <Description>Staff</Description>
                        </AdmissionInfoGroupCharge>
                    </AdmissionInfoGroupCharges>
                    <AdmissionInfoGroupContacts>
                        <AdmissionInfoGroupContact>

                            <AdmissionInfoGroupContactID>502</AdmissionInfoGroupContactID>
                            <ContactName>
                                <PersonalNameTitle>Mr.</PersonalNameTitle>
                                <FullName>Joe Donald Norman Namath</FullName>
                                <FirstName>Joe</FirstName>
                                <MiddleNames>
                                    <MiddleName>Donald</MiddleName>
                                </MiddleNames>
                                <LastName>Namath</LastName>
                                <PersonalNameSuffix>Jr.</PersonalNameSuffix>
                            </ContactName>
                            <ProfessionalAffiliations>
                                <ProfessionalAffiliation>

                                    <JobTitles>
                                        <JobTitle>Football Player</JobTitle>
                                    </JobTitles>
                                    <OrganizationName>NBC</OrganizationName>
                                    <OrganizationWebPages>
                                        <WebPage>
                                            <Title>NBS</Title>
                                            <URL>http://www.nbc.cm</URL>
                                        </WebPage>
                                    </OrganizationWebPages>
                                </ProfessionalAffiliation>
                            </ProfessionalAffiliations>
                            <Phones>
                                <Phone>
                                    <PhoneNumber>510-555-1235</PhoneNumber>
                                    <PhoneNumberExtension>888</PhoneNumberExtension>
                                    <PhoneNumberType>Home</PhoneNumberType>
                                </Phone>
                            </Phones>
                            <EmailAddresses>
                                <EmailAddress>joe@namath.com</EmailAddress>
                            </EmailAddresses>
                            <Addresses>
                                <Address>

                                    <AddressID>32</AddressID>
                                    <Postbox>2195</Postbox>
                                    <Floor>2nd</Floor>
                                    <Room>202</Room>
                                    <StreetName>Hearst</StreetName>
                                    <AdditionalStreetName>Another Name</AdditionalStreetName>

                                    <BuildingName>Boalt Hall</BuildingName>
                                    <BuildingNumber>222</BuildingNumber>
                                    <InhouseMail>R2205</InhouseMail>
                                    <Department>Law School</Department>
                                    <CityName>Berkeley</CityName>
                                    <PostalZone>94720</PostalZone>

                                    <CountrySubentity>California</CountrySubentity>
                                    <CountrySubentityCode>CA</CountrySubentityCode>
                                    <Region>West Coast</Region>
                                    <District>Probably won't use this</District>
                                    <TimezoneOffset>-7:00</TimezoneOffset>
                                    <Country>

                                        <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>
                                        <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                                    </Country>
                                    <LocationCoordinate>
                                        <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>
                                        <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>
                                        <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>

                                        <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>
                                        <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                                        <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                                        <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>
                                    </LocationCoordinate>
                                </Address>
                            </Addresses>

                            <WebPages>
                                <WebPage>
                                    <Title>Joe's page</Title>
                                    <URL>http://www.joe.com</URL>
                                </WebPage>
                            </WebPages>
                            <PreferredContactMethod>Address</PreferredContactMethod>
                            <AdmissionInfoGroupContactTypes>
                                <AdmissionInfoGroupContactType>Type 1</AdmissionInfoGroupContactType>
                            </AdmissionInfoGroupContactTypes>
                            <AdmissionInfoGroupContactParentID>556</AdmissionInfoGroupContactParentID>
                        </AdmissionInfoGroupContact>
                        <AdmissionInfoGroupContact>
                            <AdmissionInfoGroupContactID>502</AdmissionInfoGroupContactID>
                            <ContactName>
                                <PersonalNameTitle>Mr.</PersonalNameTitle>

                                <FullName>Joe Donald Norman Namath</FullName>
                                <FirstName>Joe</FirstName>
                                <MiddleNames>
                                    <MiddleName>Donald</MiddleName>
                                </MiddleNames>
                                <LastName>Namath</LastName>

                                <PersonalNameSuffix>Jr.</PersonalNameSuffix>
                            </ContactName>
                            <ProfessionalAffiliations>
                                <ProfessionalAffiliation>
                                    <JobTitles>
                                        <JobTitle>Football Player</JobTitle>
                                    </JobTitles>
                                    <OrganizationName>NBC</OrganizationName>
                                    <OrganizationWebPages>
                                        <WebPage>
                                            <Title>NBS</Title>
                                            <URL>http://www.nbc.cm</URL>
                                        </WebPage>
                                    </OrganizationWebPages>
                                </ProfessionalAffiliation>
                            </ProfessionalAffiliations>
                            <Phones>
                                <Phone>
                                    <PhoneNumber>510-555-1235</PhoneNumber>
                                    <PhoneNumberExtension>888</PhoneNumberExtension>
                                    <PhoneNumberType>Home</PhoneNumberType>

                                </Phone>
                            </Phones>

                            <EmailAddresses>
                                <EmailAddress>joe@namath.com</EmailAddress>
                            </EmailAddresses>
                            <Addresses>
                                <Address>
                                    <AddressID>32</AddressID>

                                    <Postbox>2195</Postbox>
                                    <Floor>2nd</Floor>
                                    <Room>202</Room>
                                    <StreetName>Hearst</StreetName>
                                    <AdditionalStreetName>Another Name</AdditionalStreetName>
                                    <BuildingName>Boalt Hall</BuildingName>

                                    <BuildingNumber>222</BuildingNumber>
                                    <InhouseMail>R2205</InhouseMail>
                                    <Department>Law School</Department>
                                    <CityName>Berkeley</CityName>
                                    <PostalZone>94720</PostalZone>
                                    <CountrySubentity>California</CountrySubentity>

                                    <CountrySubentityCode>CA</CountrySubentityCode>
                                    <Region>West Coast</Region>
                                    <District>Probably won't use this</District>
                                    <TimezoneOffset>-7:00</TimezoneOffset>
                                    <Country>
                                        <IdentificationCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="ISO3166-1" codeListAgencyID="6" codeListAgencyName="United Nations Economic Commission for Europe" codeListName="Country" codeListVersionID="0.3" languageID="en" codeListURI="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1-semic.txt" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:CountryIdentificationCode-1.0">US</IdentificationCode>

                                        <Name xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0">United States</Name>
                                    </Country>
                                    <LocationCoordinate>
                                        <CoordinateSystemCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0">Code System</CoordinateSystemCode>
                                        <LatitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">5</LatitudeDegreesMeasure>
                                        <LatitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">10</LatitudeMinutesMeasure>
                                        <LatitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Latitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Latitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LatitudeDirectionCode-1.0">North</LatitudeDirectionCode>

                                        <LongitudeDegreesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">15</LongitudeDegreesMeasure>
                                        <LongitudeMinutesMeasure xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-1.0" measureUnitCode="normalizedString">20</LongitudeMinutesMeasure>
                                        <LongitudeDirectionCode xmlns="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-1.0" codeListID="Longitude Direction" codeListAgencyID="UBL" codeListAgencyName="OASIS Universal Business Language" codeListName="Longitude Direction" codeListVersionID="1.0" languageID="en" codeListSchemeURI="urn:oasis:names:specification:ubl:schema:xsd:LongitudeDirectionCode-1.0">East</LongitudeDirectionCode>
                                    </LocationCoordinate>
                                </Address>
                            </Addresses>
                            <WebPages>

                                <WebPage>
                                    <Title>Joe's page</Title>
                                    <URL>http://www.joe.com</URL>
                                </WebPage>
                                <WebPage>
                                    <Title>Norman's page</Title>
                                    <URL>http://www.norman.com</URL>

                                </WebPage>
                            </WebPages>
                            <PreferredContactMethod>Address</PreferredContactMethod>
                            <AdmissionInfoGroupContactTypes>
                                <AdmissionInfoGroupContactType>Type 1</AdmissionInfoGroupContactType>
                            </AdmissionInfoGroupContactTypes>

                            <AdmissionInfoGroupContactParentID>556</AdmissionInfoGroupContactParentID>
                        </AdmissionInfoGroupContact>
                    </AdmissionInfoGroupContacts>
                    <DateAvailable>2006-10-12</DateAvailable>
                    <Deadline>2006-11-30</Deadline>
                    <AdmissionInfoGroupStatus>Available Now</AdmissionInfoGroupStatus>
                    <AdmissionInfoGroupAdditionalInfo>This is the additional info.</AdmissionInfoGroupAdditionalInfo>

                </AdmissionInfoGroup>
            </AdmissionInfoGroups>
            <AccessibilityInfo>Sign language interpreter available upon request</AccessibilityInfo>
        </EntryConditions>
        <RelatedEvents>
            <RelatedEvent>
                <EventID>55</EventID>
                <RelationType>Child</RelationType>
            </RelatedEvent>
        </RelatedEvents>
        <FeaturedEventTypes>
            <FeaturedEventType>Homepage</FeaturedEventType>
        </FeaturedEventTypes>
        <EventPromotions>
            <EventPromotion>
                <Description>Article on why you should come to this event</Description>
                <URL>http://www.newyorktimes.com/article</URL>
            </EventPromotion>
        </EventPromotions>
        <?php if (!empty($this->event->privatecomment)): ?>
        <PrivateComments>
            <PrivateComment><?php echo $this->event->privatecomment; ?></PrivateComment>
        </PrivateComments>
        <?php endif; ?>
        <Keywords>
            <Keyword>Administration</Keyword>
        </Keywords>
        <Extension>
            <NewElement>Content</NewElement>
        </Extension>
    </Event>