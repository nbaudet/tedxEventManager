<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Montest</title>
    </head>
    <body>
        <?php
        /*
         * To change this template, choose Tools | Templates
         * and open the template in the editor.
         */
        require_once('../tedx-config.php');
        require_once('../core/services/applicatives/ASFree.class.php');
        require_once('../core/services/applicatives/ASVisitor.class.php');
        require_once('../core/services/applicatives/ASOrganizer.class.php');
        require_once('../core/services/applicatives/ASAdmin.class.php');
        require_once('../core/model/Person.class.php ');
        require_once('../core/model/Event.class.php ');
        require_once('../core/model/Participant.class.php ');
        require_once('../core/model/Message.class.php ');
        require_once('../core/services/functionnals/FSEvent.class.php');
        require_once('../core/services/functionnals/FSKeyword.class.php');
        require_once('../core/services/functionnals/FSSlot.class.php');
        require_once('../core/services/functionnals/FSRegistration.class.php');
        require_once('../core/services/functionnals/FSParticipant.class.php');
        

        $argsPerson = array(
          'name'         => 'Jacques',
          'firstname'    => 'Jean',
          'dateOfBirth'  => '1987-03-16',
          'address'      => 'Chemin de la gare 24',
          'city'         => 'Lausanne',
          'country'      => 'Suisse',
          'phoneNumber'  => '+41756999888',
          'email'        => 'jeanjacques@heig.ch',
          'description'  => 'Doyen de COMEM+',
          'idmember'     => 'jean',
          'password'     => 'jacques'
          );
        
        $message = ASAdmin::registerOrganizer($argsPerson);
        echo "<hr> Mon message final";
        var_dump($message);
        ?>
    </body>
</html>
