<?php

class Catchpoint_Monitors
{

    public function Monitors ($monitorId)
    {
        $monitors = array(
                0 => 'IE Browser',
                2 => 'Object',
                3 => 'Emulated',
                8 => 'Ping (ICMP)',
                9 => 'Tracert (ICMP)',
                10 => 'DNS Traversal',
                11 => 'Ping (TCP)',
                12 => 'DNS Experience',
                13 => 'DNS Direct',
                14 => 'Tracert (UDP)',
                15 => 'Port (TCP)',
                16 => 'FTP',
                18 => 'Chrome Browser',
                19 => 'Playback',
                20 => 'Playback Mobile',
                21 => 'SMTP', 
                22 => 'Port (UDP)',
                23 => 'Ping (UDP)',
                24 => 'Streaming',
                25 => 'API',
                26 => 'Mobile',
                27 => 'SFTP',
                28 => 'SSH',
                29 => 'Tracert (TCP)'
        );
        return $monitors[$monitorId];
    }
}