<?php error_reporting(E_ERROR);
$ip_low = ip2long("192.30.252.0");
$ip_high = ip2long("192.30.255.255");
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = ip2long($_SERVER['HTTP_CLIENT_IP']);
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = ip2long($_SERVER['HTTP_X_FORWARDED_FOR']);
} else {
    $ip = ip2long($_SERVER['REMOTE_ADDR']);
}
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if ($ip >= $ip_low && $ip <= $ip_high) {
    if ($data['repository.name'] == "TPT-NodeJS") {    
        shell_exec("cd /var/www && /usr/bin/git pull 2>&1");
    } else {
        shell_exec("cd /root/TPT && /usr/bin/git pull 2>&1");
    }
} else {
    include '403.php';
    header("HTTP/1.1 403 Forbidden");
    header("Status: 403 Your IP is not on our list; bugger off", true, 403);
}
exit()
?>
