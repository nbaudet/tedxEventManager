<?php
require_once('../tedx-config.php');
require_once(APP_DIR .'/core/services/functionnals/FSLocation.class.php');

var_dump(FSLocation::getLocation("L'Usine"));
var_dump(FSLocation::getLocations());
var_dump(FSLocation::addLocation('Un nom', 'Une adresse', 'Une ville', 'Un pays'));

?>