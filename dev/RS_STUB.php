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
        
        $speaker = $tedx_manager->getSpeaker(6)->getContent();
        $event = $tedx_manager->getEvent(15)->getContent();

        $arrayTalkToSet = array(
            'eventNo'            => 15,
            'speakerPersonNo'    => 6,
            'videoTitle'         => 'Video title of the year',
            'videoDescription'   => "This video is about a crazy cat fighting with an orange",
            'videoURL'           => "www.youtube.com/",
            'isArchived'         => 0
        );

        $aTalkToSet = new Talk($arrayTalkToSet);
        var_dump($aTalkToSet);

        var_dump(FSTalk::setTalk($aTalkToSet));
        
        echo "<hr> Mon message final";
        ?> 
    </body>
</html>
