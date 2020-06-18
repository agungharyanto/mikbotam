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
 *  Last Edited : 26 Desember 2019
 *
 *  Please do not change this code
 *  All damage caused by editing we will not be responsible please think carefully,
 *
 */

//=====================================================START SCRIPT====================//
error_reporting(0);

if (!isset($_SESSION["Mikbotamuser"])) {
    header("Location:../admin/login.php");
} else {
    include '../config/system.conn.php';
    include '../config/system.byte.php';
    include '../Api/routeros_api.class.php';
    $datavoucher = sethistory($id);
    date_default_timezone_set('Asia/Jakarta');
    $API = new routeros_api();

    if ($API->connect($mikrotik_ip, $mikrotik_username, $mikrotik_password, $mikrotik_port)) {
        $IDENTITY      = $API->comm('/system/identity/getall');
        $routername    = $IDENTITY['0']['name'];
        $health        = $API->comm("/system/health/print");
        $dhealth       = $health['0'];
        $ARRAY         = $API->comm("/system/resource/print");
        $first         = $ARRAY['0'];
        $memperc       = ($first['free-memory'] / $first['total-memory']);
        $hddperc       = ($first['free-hdd-space'] / $first['total-hdd-space']);
        $mem           = ($memperc * 100);
        $hdd           = ($hddperc * 100);
        $sehat         = $dhealth['temperature'];
        $platform      = $first['platform'];
        $board         = $first['board-name'];
        $version       = $first['version'];
        $architecture  = $first['architecture-name'];
        $cpu           = $first['cpu'];
        $cpuload       = $first['cpu-load'];
        $uptime        = $first['uptime'];
        $cpufreq       = $first['cpu-frequency'];
        $cpucount      = $first['cpu-count'];
        $memory        = formatBytes($first['total-memory']);
        $fremem        = formatBytes($first['free-memory']);
        $mempersen     = number_format($mem, 3);
        $hdd           = formatBytes($first['total-hdd-space']);
        $frehdd        = formatBytes($first['free-hdd-space']);
        $hddpersen     = number_format($hdd, 3);
        $sector        = $first['write-sect-total'];
        $setelahreboot = $first['write-sect-since-reboot'];
        $kerusakan     = $first['bad-blocks'];
    }
}

?>
     <script src='../js/mikbotamRunnertext.js'></script> 
     
     <script>
    
function testcon(){var _0x17A28=$("\x23\x69\x70").val();var _0x17A88=$("\x23\x75\x73\x65\x72\x6E\x61\x6D\x65").val();var _0x17A48=$("\x23\x70\x61\x73\x73\x77\x6F\x72\x64").val();var _0x17A68=$("\x23\x70\x6F\x72\x74\x61\x70\x69").val();$("\x23\x74\x65\x73\x74\x2D\x63\x6F\x6E\x6E\x65\x63\x74").html("\x3C\x64\x69\x76\x20\x63\x6C\x61\x73\x73\x3D\x22\x63\x61\x72\x64\x20\x70\x64\x2D\x32\x30\x20\x70\x64\x2D\x73\x6D\x2D\x32\x30\x20\x62\x67\x2D\x70\x72\x69\x6D\x61\x72\x79\x20\x22\x3E\x3C\x64\x69\x76\x20\x63\x6C\x61\x73\x73\x3D\x22\x73\x69\x67\x6E\x69\x6E\x2D\x6C\x6F\x67\x6F\x20\x74\x78\x2D\x63\x65\x6E\x74\x65\x72\x20\x74\x78\x2D\x34\x30\x20\x74\x78\x2D\x62\x6F\x6C\x64\x20\x74\x78\x2D\x77\x68\x69\x74\x65\x22\x3E\x4C\x4F\x41\x44\x49\x4E\x47\x2E\x2E\x2E\x2E\x20\x3C\x2F\x64\x69\x76\x3E\x3C\x64\x69\x76\x20\x63\x6C\x61\x73\x73\x3D\x22\x74\x78\x2D\x63\x65\x6E\x74\x65\x72\x20\x20\x74\x78\x2D\x77\x68\x69\x74\x65\x22\x3E\x50\x6C\x65\x61\x73\x65\x20\x77\x61\x69\x74\x20\x61\x20\x66\x65\x77\x20\x73\x65\x63\x6F\x6E\x64\x73\x3C\x2F\x64\x69\x76\x3E\x3C\x2F\x64\x69\x76\x3E");$.ajax({type:"\x50\x4F\x53\x54",url:"\x2E\x2E\x2F\x50\x72\x6F\x73\x73\x65\x73\x2F\x63\x6F\x6E\x6E\x74\x65\x73\x74\x2E\x70\x68\x70\x3F\x63\x6D\x64\x3D\x74\x65\x73\x74\x63\x6F\x6E",cache:false,data:{ip:_0x17A28,user:_0x17A88,pass:_0x17A48,portapi:_0x17A68},success:function(_0x17AA8){$("\x23\x74\x65\x73\x74\x2D\x63\x6F\x6E\x6E\x65\x63\x74").html(_0x17AA8)}})}
   
    </script>
      
    <div class="sl-pagebody">
        <div class="mg-t-10">
            <div class="card bd-primary">
                <div class="card-header bg-primary tx-white"> <i class="fa fa-th-list"></i> List Servers MikroTik &nbsp; | &nbsp;&nbsp;<i onclick="Reload();" class="fa fa-refresh pointer " title="Reload data"></i></div>
                <div class="card-body pd-sm-15">
				<div class="card bd-primary mg-t-10 ">
					<div class="card-body">
						<div class="table-wrapper">
							<table id="userhistory" class="table display  nowrap " width="100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Router Name</th>
										<th>IP</th>
										<th>Port</th>
										<th>User</th>
										<th>CPU Load</th>
										<th>Uptime</th>
									</tr>
								</thead>
								<tbody>

                                Router Name : <?=$routername;
											?><br>
											Model :  <?=$board;
											?><br>
											Router OS : <?=$version;
											?><br>
											<div class="up-time">Loading..
                                
									<?php
									$TotalReg = count($datavoucher);
									for ($i = 0; $i < $TotalReg; $i++) {
										$datas = $datavoucher[$i];
										$no = $i + 1;
										$id_user = $datas['id_user'];
										$nama_seller = $datas['nama_seller'];
										$saldo_awal = $datas['saldo_awal'];
										$beli_voucher = $datas['beli_voucher'];
										$saldo_akhir = $datas['saldo_akhir'];
										$top_up = $datas['top_up'];
										$top_up_fromid = $datas['top_up_fromid'];
										$username_voucher = $datas['username_voucher'];
										$password_voucher = $datas['password_voucher'];
										$exp_voucher = $datas['exp_voucher'];

										$keterangan = $datas['keterangan'];
										if ($keterangan == 'Success') {
											$ket = "<span class='label label-success m-r-15'>$keterangan  Voc $exp_voucher</span>";
										} elseif ($keterangan == 'gagalprint') {
											$ket = "<span class='label label-warning m-r-15'>$keterangan </span>";
										} elseif ($keterangan == 'gagal') {
											$ket = "<span class='label label-warning m-r-15'>$keterangan</span>";
										} else {
											$ket = "<span class='label label-info m-r-15'>$keterangan</span>";
											$beli_voucher = $top_up;
										}
										$Waktu = $datas['Waktu'];
										$Tanggal = $datas['Tanggal'];
										echo "<tr>";
										echo "<td>" . $no . "</td>";
										echo "<td> $routername </td>";
										echo "<td>" . $ket . "</td>";
										echo "<td>" . rupiah($beli_voucher) . "</td>";
										echo "<td>" . $Waktu . "</td>";
										echo "<td>" . $Tanggal . "</td>";
										
										echo "</tr>";
									}

									?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- card-body -->
				</div>		
			<div class="col-lg-4 mg-t-10">
                </div>
            </div>
            <!-- body -->
        </div>
    </div>

