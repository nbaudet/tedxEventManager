<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Register Visitor And To an Event</title>
    </head>
    <body>
    <?php

    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */
    require_once('../tedx-config.php');
    
    $argsRegisterVisitor = array(
               'name'         => 'Cage',
               'firstname'    => 'Nicolas',
               'dateOfBirth'  => '1976-09-26',
               'address'      => 'Bolliwood 1234',
               'city'         => 'Genève',
               'country'      => 'Suisse',
               'phoneNumber'  => '+41792369901',
               'email'        => 'nico.cage@wiki.org',
               'description'  => 'Acteur, répétiteur',
               'idmember'     => 'nicolas',
               'password'     => 'cage',
            );
    $message1 = $tedx_manager->registerVisitor($argsRegisterVisitor);
    var_dump($message1);
    $donnee1 = $message1->getContent();
    $aPerson = $donnee1['anAddedPerson'];
    $anEvent = FSEvent::getEvent(2)->getContent();
    
    $argsRegisterToAnEvent = array(
        'person' => $aPerson, // object Person
        'event' => $anEvent, // object Event
        'type' => 'Organizer', // String
        'typedescription' => 'I am an Actor' // String
    ); 
    $message2 = $tedx_manager->registerToAnEvent($argsRegisterToAnEvent);
    
    var_dump($message2);
    ?>
    </body>
</html>
