<?php
require_once('../tedx-config.php');
require_once(APP_DIR .'/core/services/functionnals/FSLocation.class.php');
require_once(APP_DIR .'/core/services/functionnals/FSParticipant.class.php');

var_dump(FSLocation::getLocation("L'Usine"));

var_dump(FSLocation::getLocations());
$argsLocation= array(
            'Name'         => 'OOOOOOOOOOo',
            'Address'   => 'Une Adresse',
            'City'   => 'Une ville',
            'Country'   => 'Un pays',
            'Direction' => 'Une Direction'
            /*'Direction'*/
        );
var_dump(FSLocation::addLocation($argsLocation));

var_dump(FSParticipant::getParticipant(5));
var_dump(FSParticipant::getParticipants());
var_dump(FSParticipant::addParticipant(8));
?>