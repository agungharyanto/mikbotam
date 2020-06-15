<?php
//=====================================================START====================//

/*
 *  Base Code   : BangAchil
 *  Email       : kesumaerlangga@gmail.com
 *  Telegram    : @bangachil
 *
 *  Name        : Mikrotik bot telegram - php
 *  Function    : Mikortik api
 *  Manufacture : November 2018
 *  Last Edited : 26 Desember 2018
 *
 *  Please do not change this code
 *  All damage caused by editing we will not be responsible please think carefully,
 *
 */

//=====================================================START SCRIPT====================//

      include 'system.conn.php';
		include 'system.byte.php';
		include '../Api/routeros_api.class.php';
	
		
  
  
function connects(){
	global $settings;
	$mikrotik_ip 		=$settings["IP_router"];
	$mikrotik_username=$settings["Username_router"];
	$mikrotik_password=decrypturl($settings["Pass_router"]);
	$mikrotik_port 	=$settings["Port"];
	$API = new routeros_api();
	return ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password, $mikrotik_port));
}

function disablehotspotuser($userhotspotid) {
        if ($this->connects()) {
            $this->write('/ip/hotspot/user/set', false);
            $this->write('=.id='.$userhotspotid, false);
            $this->write('=disabled=yes');
            return $this->read();
        }
        return false;
    }
function enablehotspotuser($userhotspotid) {
        if ($this->connects()) {
            $this->write('/ip/hotspot/user/set', false);
            $this->write('=.id='.$userhotspotid, false);
            $this->write('=disabled=no');
            return $this->read();
        }
        return false;
    }
function deletehotspotuser($userhotspotid) {
        if ($this->connects()) {
            $this->write('/ip/hotspot/user/set', false);
            $this->write('=.id='.$userhotspotid, false);
            $this->write('=disabled=no');
            return $this->read();
        }
        return false;
    }  
