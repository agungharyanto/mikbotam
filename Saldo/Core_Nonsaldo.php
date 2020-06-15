
                                			
						
<?php
//=====================================================START====================//

/*
s
NONSADLO 

*/

//=====================================================START SCRIPT====================//  
date_default_timezone_set('Asia/Jakarta');
include 'src/FrameBot.php';
require_once '../config/system.conn.php';
$mkbot = new FrameBot($token, $usernamebot);
require_once '../config/system.byte.php';
require_once '../Api/routeros_api.class.php';
//Any commands akan di cegah dengan ini jika  perlu silahakan dihapus /* dan  */
/*
$mkbot->cmd('*', 'Maaf commands tidak tersedia');
*/

$mkbot->cmd('/start|/Start', function () {
        include ('../config/system.conn.php');
    $info         = bot::message();
    $ids          = $info['chat']['id'];
    $msgid        = $info['message_id'];
    $nametelegram = $info['from']['username'];
    $idtelegram   = $info['from']['id'];
    Bot::sendChatAction('typing');

    if (has($idtelegram) == false) {
        Bot::sendChatAction('typing');
        $text = "";
        $text = 'Selamat datang di..(custom text)....';
        $options = [
            'parse_mode' => 'html'
        ];
        return Bot::sendMessage($text, $options);
    } else {
        $text = "";
        $text = "Hai @$nametelegram ada yang bisa kami bantu?\n/help untuk informasi bantuan ";
    }

    $options = [
        'parse_mode' => 'html'
    ];

    return Bot::sendMessage($text, $options);
});

$mkbot->cmd('/cekid|/Cekid', function ($jumlah) {
         include ('../config/system.conn.php');
    $info   = bot::message();
    $id     = $info['chat']['id'];
    $iduser = $info['from']['id'];
    $msgid  = $info['message_id'];
    $name   = $info['from']['username'];
    $id     = $info['from']['id'];

    if (has($id) == false) {
        $text = "<code>    Informasi ID Anda</code>\n";
        $text .= "<code>========================</code>\n";
        $text .= "<code>  ID User  :</code> <code>$id</code>\n";
        $text .= "<code>  Username :</code> @$name\n";
        $text .= "<code>  Status   : - </code>\n";
        $text .= "<code>========================</code>\n";
    } else {
        $text = "<code>    Informasi ID Anda</code>\n";
        $text .= "<code>========================</code>\n";
        $text .= "<code>  ID User  : </code> <code>$id</code>\n";
        $text .= "<code>  Username : </code> @$name\n";
        $text .= "<code>  Status   : Terdaftar </code>\n";
        $text .= "<code>========================</code>\n";
    }

    $options = [
        'parse_mode' => 'html'
    ];
    return Bot::sendMessage($text, $options);
});
$mkbot->cmd('/resource|/Resource', function () {

    $info         = bot::message();
    $msgid        = $info['message_id'];
    $nametelegram = $info['from']['username'];
    $idtelegram   = $info['from']['id'];
    Bot::sendChatAction('typing');

    include ('../config/system.conn.php');
    if ($idtelegram == $id_own) {
        $API = new routeros_api();
        if ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password, $mikrotik_port)) {
            $jambu   = $API->comm("/system/health/print");
            $dhealth = $jambu['0'];
            $ARRAY   = $API->comm("/system/resource/print");
            $jeruk   = $ARRAY['0'];
            $memperc = ($jeruk['free-memory'] / $jeruk['total-memory']);
            $hddperc = ($jeruk['free-hdd-space'] / $jeruk['total-hdd-space']);
            $mem     = ($memperc * 100);
            $hdd     = ($hddperc * 100);
            $sehat         = $dhealth['temperature'];
            $platform      = $jeruk['platform'];
            $board         = $jeruk['board-name'];
            $version       = $jeruk['version'];
            $architecture  = $jeruk['architecture-name'];
            $cpu           = $jeruk['cpu'];
            $cpuload       = $jeruk['cpu-load'];
            $uptime        = $jeruk['uptime'];
            $cpufreq       = $jeruk['cpu-frequency'];
            $cpucount      = $jeruk['cpu-count'];
            $memory        = formatBytes($jeruk['total-memory']);
            $fremem        = formatBytes($jeruk['free-memory']);
            $mempersen     = number_format($mem, 3);
            $hdd           = formatBytes($jeruk['total-hdd-space']);
            $frehdd        = formatBytes($jeruk['free-hdd-space']);
            $hddpersen     = number_format($hdd, 3);
            $sector        = $jeruk['write-sect-total'];
            $setelahreboot = $jeruk['write-sect-since-reboot'];
            $kerusakan     = $jeruk['bad-blocks'];
            $text .= "";
            $text .= "📡<b> Resource</b>  $sehat C\n";
            $text .= "<code>Boardname: $board</code>\n";
            $text .= "<code>Platform : $platform</code>\n";
            $text .= "<code>Uptime is: ".formatDTM($uptime)."</code>\n";
            $text .= "<code>Cpu Load : $cpuload%</code>\n";
            $text .= "<code>Cpu type : $cpu</code>\n";
            $text .= "<code>Cpu Hz   : $cpufreq Mhz/$cpucount core</code>\n==========================\n";
            $text .= "<code>Free memory and memory \n$memory-$fremem/$mempersen %</code>\n==========================\n";
            $text .= "<code>Free disk and disk      \n$hdd-$frehdd/$hddpersen %</code>\n==========================\n";
            $text .= "<code>Since reboot, bad blocks \n$sector-$setelahreboot/$kerusakan%</code>\n==========================\n";
        }

      
    } else {
        $text = "Maaf..! Aksess Hanya untuk Adminstator";
 
    }
      $options = ['parse_mode' => 'html', ];
        Bot::sendMessage($text, $options);
});
$mkbot->cmd('Hotspot|hotspot|/hotspot|/Hotspot|!Hotspot', function ($user, $telo) {

    $info         = bot::message();
    $msgid        = $info['message_id'];
    $nametelegram = $info['from']['username'];
    $idtelegram   = $info['from']['id'];
    Bot::sendChatAction('typing');

    include ('../config/system.conn.php');
    if ($idtelegram == $id_own) {
        $API = new routeros_api();
        if ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password, $mikrotik_port)) {
            if ($user == 'aktif') {
                if ($telo != "") {
                    $pepaya = $API->comm("/ip/hotspot/active/print", ["?server" => "" . $telo . ""]);
                    $anggur = count($pepaya);
                    $apel   = $API->comm("/ip/hotspot/active/print", ["count-only" => "", "?server" => "" . $telo . ""]);
                } else {
                    $pepaya = $API->comm("/ip/hotspot/active/print");
                    $anggur = count($pepaya);
                    $apel   = $API->comm("/ip/hotspot/active/print", ["count-only" => "", ]);
                }
                $text .= "User Aktif $apel item\n\n";
                for ($i = 0; $i < $anggur; $i++) {
                    $mangga    = $pepaya[$i];
                    $id        = $mangga['.id'];
                    $server    = $mangga['server'];
                    $user      = $mangga['user'];
                    $address   = $mangga['address'];
                    $mac       = $mangga['mac-address'];
                    $uptime    = $mangga['uptime'];
                    $usesstime = $mangga['session-time-left'];
                    $bytesi    = formatBytes($mangga['bytes-in'], 2);
                    $byteso    = formatBytes($mangga['bytes-out'], 2);
                    $loginby   = $mangga['login-by'];
                    $comment   = $mangga['comment'];
                    $text .= "";
                    $text .= "👤 User aktif\n";
                    $text .= "┠ ID :$id\n";
                    $text .= "┠ User  : $user\n";
                    $text .= "┠ IP    : $address\n";
                    $text .= "┠ Uptime : $uptime\n";
                    $text .= "┠ Byte IN      : $bytesi\n";
                    $text .= "┠ Byte OUT   : $byteso\n";
                    $text .= "┠ Sesion  : $usesstime\n";
                    $text .= "┗ Login    : $loginby\n \n";
                    $text .= "/see_$server\n \n";
                }

                $arr2       = str_split($text, 4000);
                $amount_gen = count($arr2);
                for ($i = 0; $i < $amount_gen; $i++) {
                    $texta = $arr2[$i];
                    Bot::sendMessage($texta);
                }
            } elseif ($user == 'user') {
                $ARRAY = $API->comm("/ip/hotspot/user/print");
                $num   = count($ARRAY);
                $text  = "Total $num User\n\n";
                for ($i = 0; $i < $num; $i++) {
                    $no     = $i;
                    $data   = $ARRAY[$i]['.id'];
                    $dataid = str_replace('*', 'id', $data);
                    $server = $ARRAY[$i]['server'];
                    $name   = $ARRAY[$i]['name'];
                    $data3  = $ARRAY[$i]['password'];
                    $data4  = $ARRAY[$i]['mac-address'];
                    $data5  = $ARRAY[$i]['profile'];
                    $data6  = $ARRAY[$i]['limit-uptime'];
                    $text .= "";
                    $text .= "👥  ($dataid)\n";
                    $text .= "┣Nama : $name\n";
                    $text .= "┣password : $data3 \n";
                    $text .= "┣mac : $data4\n";
                    $text .= "┣Profil : $data5\n\n";
                    $text .= "┗RemoveNow User /rEm0v$dataid\n\n";
                }
                $arr2       = str_split($text, 4000);
                $amount_gen = count($arr2);
                for ($i = 0; $i < $amount_gen; $i++) {
                    $texta = $arr2[$i];

                    Bot::sendMessage($texta);
                }
            } else {
                $text .= "";
                $text = "User list or aktif\n";
                $text .= "Filter by server\n";
                $serverhot = $API->comm('/ip/hotspot/print');
                foreach ($serverhot as $index => $jambu) {
                    $sapubasah      = str_replace('-', '0', $jambu['name']);
                    $sapubasahbasah = str_replace(' ', '11', $sapubasah);

                    $text .= "/see_" . $sapubasahbasah . "\n";
                }

                $keyboard    = [['Hotspot user', 'Hotspot aktif'], ['!Menu', 'Help'], ['!Hide'], ];
                $replyMarkup = ['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true];
                $options     = [
                    'reply' => true,
                    'reply_markup' => json_encode($replyMarkup),
                ];
                Bot::sendMessage($text, $options);
            }
        } else {
            $text    = "Tidak dapat Terhubung dengan Mikrotik Coba Kembali";
            $options = [
                'reply' => true,
            ];
            Bot::sendMessage($text, $options);
        }
    } else {
        $denid = "Maaf..! Aksess Hanya untuk Administator";
        Bot::sendMessage($denid);
    }
});
$mkbot->cmd('?hs|!User|?user|!user|?', function ($name) {

    $info         = bot::message();
    $msgid        = $info['message_id'];
    $nametelegram = $info['from']['username'];
    $idtelegram   = $info['from']['id'];
    Bot::sendChatAction('typing');

    include ('../config/system.conn.php');
    if ($idtelegram == $id_own) {
        $API = new routeros_api();
        if ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password, $mikrotik_port)) {
            $ARRAY = $API->comm("/ip/hotspot/user/print", ["?name" => $name, ]);
            $get   = $API->comm("/system/scheduler/print", ["?name" => $name, ]);

            if (empty($ARRAY)) {
                $texta = "User tidak ditemukan...";
            } else {
                foreach ($ARRAY as $index => $baris) {
                    $text = "";
                    $text .= "Hotspot Client";
                    $text .= "\n=======================\n";
                    $text .= "Nama     :" . $baris['name'] . "\n";
                    $text .= "Password :" . $baris['password'] . "\n";
                    $text .= "Limit    :" . $baris['limit-uptime'] . "\n";
                    $text .= "Uptime   :" . formatDTM($baris['uptime']) . "\n";
                    $text .= "Upload   :" . formatBytes($baris['bytes-in']) . "\n";
                    $text .= "Downlaod :" . formatBytes($baris['bytes-out']) . "\n";
                    $text .= "Profil   :" . $baris['profile'] . "\n";
                    $data   = $baris['.id'];
                    $dataid = str_replace('*', 'id', $data);
                }
                foreach ($get as $index => $baris) {
                    $experid = "";
                    $experid .= "Start-time : <b>" . $baris['start-date'] . " " . $baris['start-time'] . "</b>\n";
                    $experid .= "Interval   : <b>" . $baris['interval'] . "</b>\n";
                    $experid .= "expired    : <b>" . $baris['next-run'] . "</b>\n<code>=======================</code>\n";
                }

                $texta = "<code>" . $text . "</code>$experid\nRemove User /rEm0v$dataid\n\n";
            }
        }

        $options = ['parse_mode' => 'html', ];
        Bot::sendMessage($texta, $options);
    } else {
        $denid = "Maaf..! Aksess Hanya untuk Administator";
        Bot::sendMessage($denid);
    }
});
$mkbot->cmd('!Menu|/menu|/Menu', function () {
	 $info              = bot::message();
    $usernamepelanggan = $info['from']['username'];
    $id                = $info['from']['id'];
    $nama              = $info['from']['first_name'];
    
	if (has($id)) {
    include ('../config/system.conn.php');
    $data = json_decode($Voucher_nonsaldo, true);
    $text = "";
    $text .= " Selamat datang   <i>$nama </i> \n\n";
    $text .= "<i>Silahkan Pilih voucher dibawah ini</i>\n\n";
    foreach ($data as $hargas) {
        
                $textlist = $hargas['Text_List'];
                
                $text .= "<code>$textlist  </code>\n";
    }
    for ($i = 0; $i < count($data); $i++) {
        ${
            'database' . $i
        } = ['text' => $data[$i]['Voucher'] . '', 'callback_data' => 'Vcrnos' . $data[$i]['id'] . ''];
    }

    $vouchernamea0 = array_filter(
        [
            $database0,
            $database1

        ]);

    $vouchernameb1 = array_filter(
        [
            $database2,
            $database3

        ]);

    $vouchernamec2 = array_filter(
        [
            $database4,
            $database5

        ]);

    $send = [];
    array_push($send, $vouchernamea0);
    array_push($send, $vouchernameb1);
    array_push($send, $vouchernamec2);

    $options = [
        'reply_markup' => json_encode(['inline_keyboard' => $send]),
        'parse_mode' => 'html'
    ];

    Bot::sendMessage($text, $options);
    unset($data, $voucher_1);
    
	}else{
        $text    = 'Maaf '.$nama.' anda tidak terdaftar silahkan daftar terlebih dahulu ke admin';
        Bot::sendMessage($text);
   
	}
});
$mkbot->on('callback', function ($command) {

    $message           = Bot::message();
    $enkod             = json_encode($message);
    $id                = $message['from']['id'];
    $usernamepelanggan = $message['from']['username'];
    $namatele          = $message['from']['first_name'];
    $chatidtele        = $message["message"]['chat']['id'];
    $message_idtele    = $message["message"]["message_id"];

    include ('../config/system.conn.php');

    if (has($id)) {
    	  if (strpos($command, 'Vcrnos') !== false) {
        	
            $data  = json_decode($Voucher_nonsaldo, true);
            $cekid = "Vcrnos" . $data[0]['id'] . ",Vcrnos" . $data[1]['id'] . ",Vcrnos" . $data[2]['id'] . ",Vcrnos" . $data[3]['id'] . ",Vcrnos" . $data[4]['id'] . ",Vcrnos" . $data[5]['id'];

            if (preg_match('/' . $command . '/i', $cekid)) {
                $API = new routeros_api();
                foreach ($data as $datas => $getdata) {
                    $getid2      = $getdata['id'];
                    $profile     = $getdata['profile'];
                    $length      = $getdata['length'];
                    $vouchername = $getdata['Voucher'];
                    $server      = $getdata['server'];
                    $type        = $getdata['type'];
                    $typechar    = $getdata['typechar'];

                    if ($command == 'Vcrnos' . $getid2) {
                            $sendupdate = "";
                            $sendupdate .= "<code>========================</code>\n";
                            $sendupdate .= "<code>  ID User  :</code> <code>$id</code>\n";
                            $sendupdate .= "<code>  Username :</code> @$usernamepelanggan\n";
                            $sendupdate .= "<code>  Status   : Pending </code>\n";
                            $sendupdate .= "<code>========================</code>\n";
                            $sendupdate .= "Mohon ditunggu Voucher akan segera dibuat\n";

                            $options = [
                                'chat_id' => $chatidtele,
                                'message_id' => (int) $message['message']['message_id'],
                                'text' => $sendupdate,
                                'reply_markup' => json_encode([
                                    'inline_keyboard' => [
                                        [
                                            ['text' => 'Back', 'callback_data' => 'Menu'],
                                        ], ]]),
                                'parse_mode' => 'html'

                            ];

                            Bot::editMessageText($options);

                            
                            $delete = [
                                'chat_id' => $chatidtele,
                                'message_id' => (int) $message['message']['message_id'],
                            ];

                            Bot::deleteMessage($delete);
                            
                            
                          	if ($type == 'up') {
                                $usernamereal = make_string($length,$typechar);
                                $passwordreal = make_string($length,$typechar);
                            } else {
                                $usernamereal = make_string($length,$typechar);
                                $passwordreal = $usernamereal;
                            } 
                            
                            
                    
                           if ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password, $mikrotik_port)) {
                                $add_user_api = $API->comm("/ip/hotspot/user/add", [
                                    "server"       => $server,
                                    "profile"      => $profile,
                                    "name"         => $usernamereal,
                                    "password"     => $passwordreal,
                                    "comment"      => "vc-bot|$usernamepelanggan|nonsaldo|" . date('d-m-Y'),
                                ]);

                               if ($type == 'up') {
                               
                                $caption = "";
                                $caption .= "<code>=========================</code>\n";
                                $caption .= "<code>  ID         : $add_user_api</code>\n";
                                $caption .= "<code>  Username   :</code> <code>$usernamereal</code>\n";
                                $caption .= "<code>  Password   :</code> <code>$passwordreal</code>\n";
                                $caption .= "<code>=========================</code>\n";
                                $caption .= "<code>GUNAKAN INTERNET DGN BIJAK</code>\n";
                                $caption .= "<code>=========================</code>\n";
                            } else {
                                $caption = "";
                                $caption .= "<code>=========================</code>\n";
                                $caption .= "<code>  ID         : $add_user_api</code>\n";
                                $caption .= "<code>  ID Voucher :</code> <code>$usernamereal</code>\n";
                                $caption .= "<code>=========================</code>\n";
                                $caption .= "<code>GUNAKAN INTERNET DGN BIJAK</code>\n";
                                $caption .= "<code>=========================</code>\n";
                            }
                                $qrcode  = 'http://qrickit.com/api/qr.php?d=' . urlencode("$dnsname/login?username=$usernamereal&password=$passwordreal") . '&addtext=' . urlencode($Name_router) . '&txtcolor=000000&fgdcolor='.$Color.'&bgdcolor=FFFFFF&qrsize=500';
                         
                                
                                $options = [
                                    'chat_id' => $chatidtele,
                                    'caption' => $caption,
                                    'parse_mode' => 'html'
                                ];

                                $succes  = Bot::sendPhoto($qrcode, $options);
                                $success = json_decode($succes, true);
                                if ($success['ok'] !== true) {
                                    $errorprint = true;
                                }
                            } else {
                                $ganguan = true;
                            }
                           
                            break;
                        
                    }
                }
                if (!empty($ganguan)) {
                    $gagal .= "<code>========================</code>\n";
                    $gagal .= "<code>  ID User  :</code> <code>$id</code>\n";
                    $gagalt .= "<code>  Username :</code> @$usernamepelanggan\n";
                    $gagal .= "<code>  Status   : Vaild Conect Server </code>\n";
                    $gagal .= "<code>========================</code>\n";
                    $gagalt .= "Maaf server mengalami gangguan silahkan hubungi admin\n";
                    $options = [
                        'chat_id' => $chatidtele,
                        'parse_mode' => 'html'

                    ];
                    $keterangan = 'gagalNonSaldo';
                    Bot::sendMessage($gagal, $options);
                    //remove user
                    if ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password, $mikrotik_port)) {
                        $add_user_apis = $API->comm("/ip/hotspot/user/remove", [
                            "numbers" => $add_user_api,
                        ]);
                    }
                    $set =belivoucher($id, $usernamepelanggan, '0','0', $usernamereal, $passwordreal, $profile, $keterangan);
                } elseif (!empty($errorprint)) {
						  $gagalprint="";
                    $gagalprint .= "<code>========================</code>\n";
                    $gagalprint .= "<code>  ID User  :</code> <code>$id</code>\n";
                    $gagalprint .= "<code>  Username :</code> @$usernamepelanggan\n";
                    $gagalprint .= "<code>  Status   : Vaild Print Voucher </code>\n";
                    $gagalprint .= "<code>========================</code>\n";
                    $gagalprint .= "Maaf server mengalami gangguan silahkan hubungi admin\n";
                    $options = [
                        'chat_id' => $chatidtele,
                        'parse_mode' => 'html'

                    ];
                    $keterangan = 'gagalprintNonSaldo';
                    Bot::sendMessage($gagalprint, $options);
                    //remove user
                    if ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password, $mikrotik_port)) {
                        $add_user_apis = $API->comm("/ip/hotspot/user/remove", [
                            "id" => $add_user_api,
                        ]);
                    }
                    $set =belivoucher($id, $usernamepelanggan, '0','0', $usernamereal, $passwordreal, $profile, $keterangan);
                } else if (!empty($succes)) {
                	
                    $Success .= "<code>========================</code>\n";
                    $Success .= "<code>  ID User  :</code> <code>$id</code>\n";
                    $Success .= "<code>  Username :</code> @$usernamepelanggan\n";
                    $Success .= "<code>  Status   : Success </code>\n";
                    $Success .= "<code>========================</code>\n";
                    $options = [
                        'chat_id' => $chatidtele,
                        'reply_markup' => json_encode([
                            'inline_keyboard' => [
                                [
                                    ['text' => 'Back', 'callback_data' => 'Menu'],
                                ], ]]),
                        'parse_mode' => 'html'

                    ];

                    Bot::sendMessage($Success, $options);
                    if (isset($Success)) {
                        $keterangan  = 'SuccessNonSaldo';
                        $set          = belivoucher($id, $usernamepelanggan, '0','0', $usernamereal, $passwordreal, $profile, $keterangan);
                      
                    }
                }
            } else {
            	$Success="";
                $Success = "Maaf voucher ini tidak lagi tersedia \n";

                $options = [
                    'chat_id' => $chatidtele,
                    'parse_mode' => 'html'

                ];

                Bot::sendMessage($Success, $options);
            }
        }elseif ($command == 'Menu') {   
    $data = json_decode($Voucher_nonsaldo, true);
    $text = "";
    $text .= " Selamat datang   <i>$namatele </i> \n\n";
    $text .= "<i>Silahkan Pilih voucher dibawah ini</i>\n\n";
    foreach ($data as $hargas) {
 
                $textlist = $hargas['Text_List'];
                
                $text .= "<code>$textlist  </code>\n";
    }
    for ($i = 0; $i < count($data); $i++) {
        ${
            'database' . $i
        } = ['text' => $data[$i]['Voucher'] . '', 'callback_data' => 'Vcrnos' . $data[$i]['id'] . ''];
    }

    $vouchernamea0 = array_filter(
        [
            $database0,
            $database1

        ]);

    $vouchernameb1 = array_filter(
        [
            $database2,
            $database3

        ]);

    $vouchernamec2 = array_filter(
        [
            $database4,
            $database5

        ]);

    $send = [];
    array_push($send, $vouchernamea0);
    array_push($send, $vouchernameb1);
    array_push($send, $vouchernamec2);

            $options = [
                'chat_id' => $chatidtele,
                'message_id' => (int) $message['message']['message_id'],
                'text' => $text,
                'reply_markup' => json_encode(['inline_keyboard' => $send]),
                'parse_mode' => 'html'

            ];

            Bot::editMessageText($options);
        } elseif ($command == 'ceksaldo') {

            if (has($id) == false) {
                $text = 'Anda tidak terdaftar silahkan daftar terlebih dahulu ke admin atau klik /daftar';
            } else {
                $angka = lihatsaldo($id);
                $text  = "<code>      Informasi Saldo</code>\n";
                $text .= "<code>========================</code>\n";
                $text .= "<code>  ID User : $id</code>\n";
                $text .= "<code>  Name    : @$usernamepelanggan</code>\n";
                $text .= "<code>  Saldo   : " . rupiah($angka) . "</code>\n";
                $text .= "<code>========================</code>\n";
            }

            $options = [
                'chat_id' => $chatidtele,
                'message_id' => (int) $message['message']['message_id'],
                'text' => $text,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Back', 'callback_data' => 'Menu'],
                        ], ]]),
                'parse_mode' => 'html'

            ];

            Bot::editMessageText($options);
        } elseif ($command == 'informasi') {
            $text    = 'Tidak ada informasi terkini';
            $options = [
                'chat_id' => $chatidtele,
                'message_id' => (int) $message['message']['message_id'],
                'text' => $text,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Back', 'callback_data' => 'Menu'],
                        ], ]]),
                'parse_mode' => 'html'

            ];

            Bot::editMessageText($options);
        }
        } else{
        $text    = 'Maaf '.$namatele.' anda tidak terdaftar silahkan daftar terlebih dahulu ke admin';
        $options = [
            'chat_id' => $chatidtele,
            'message_id' => (int) $message['message']['message_id'],
            'text' => $text,
        ];
        Bot::editMessageText($options);
    }
});
$mkbot->run();					
					
	        
					
					
	        