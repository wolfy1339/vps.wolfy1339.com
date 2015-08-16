<?php error_reporting(E_ERROR);
$ip_low = ip2long("192.30.252.0");
$ip_high = ip2long("192.30.255.255");
if (!empty($SERVER['HTTP_CLIENT_IP'])) {
    $ip = ip2long($_SERVER['HTTP_CLIENT_IP']);
} else {
    $ip = ip2long($_SERVER['REMOTE_ADDR']);
}
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if ($ip >= $ip_low && $ip <= $ip_high) {
    if ($data['repository.name'] == 'TPT-NodeJS') {    
        shell_exec('cd /root/TPT && /usr/bin/git pull 2>&1');
        shell_exec('/usr/bin/npm install 2>&1');
    } else {
        shell_exec('cd /var/www/html && /usr/bin/git pull 2>&1');
    }
} else {
    include '403.php';
    header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
}
exit()
?>
