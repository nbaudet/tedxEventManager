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
        
        
        $login = $tedx_manager->login('admin', 'admin');
        
        $args = array(
            'name' => 'Médiateur rencontres post-event',
            'event' => FSEvent::getEvent(1)->getContent(),
            'organizer' => FSOrganizer::getOrganizer(2)->getContent()
        );
        
        $message = FSRole::getRole($args);
        
        
        
        
        echo "<hr> Mon message final";
        var_dump($message);
        ?>
    </body>
</html>
