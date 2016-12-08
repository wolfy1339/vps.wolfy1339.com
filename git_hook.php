<?php error_reporting(E_ERROR);
$ip_low = ip2long("192.30.252.0");
$ip_high = ip2long("192.30.255.255");
if (!empty($SERVER["HTTP_CLIENT_IP"])) {
    $ip = ip2long($_SERVER["HTTP_CLIENT_IP"]);
} else {
    $ip = ip2long($_SERVER["REMOTE_ADDR"]);
}
$CF_DO_PURGE = False;

function do_cloudflare_purge($email, $api_key, $zone_id, $file_array) {
    $CF_PURGE_URL = 'https://api.cloudflare.com/client/v4/zones/'.$zone_id.'/purge_cache';
    $curl = curl_init();
    $curl_opt = array(
        CURLOPT_URL => $CF_PURGE_URL,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_POSTFIELDS => $file_array,
        CURLOPT_HTTPHEADER => array(
            "X-Auth-Email: ".$email,
            "X-Auth-Key: ".$api_key,
            "Content-Type: application/json"
        )
    );
    curl_setopt_array($curl, $curl_opt);
    curl_exec($curl);
    curl_close($curl);
}
if ($ip >= $ip_low && $ip <= $ip_high) {
    if ($CF_DO_PURGE) {
        $CF_EMAIL = file_get_contents("../BMN/email");
        $CF_API = openssl_digest(openssl_digest(openssl_digest(file_get_contents("../BMN/cloudflare"), 'sha512'), 'sha512'), 'sha512');
        $removed = $webHookData['removed'];
        $modified = $webHookData['modified'];
        $data = json_encode(array_merge($removed, $modified));
    }

    $webHookJSON = file_get_contents("php://input");
    $webHookData = json_decode($webHookJSON, true);
    if ($webHookData["repository"]["name"] == "BMN-Files") {
        shell_exec("/usr/bin/git -C /var/www/BMN pull");

        // Purge Cloudflare cache when a commit is pushed
        if ($CF_DO_PURGE) {
            $CF_ZONE_ID = "f1539009d9ffaf171559ba86d48bcf17";
            do_cloudflare_purge($CF_EMAIL, $CF_API, $CF_ZONE_ID, $data)
        }
    } else {
        shell_exec("/usr/bin/git -C /var/www/html pull");

        if ($CF_DO_PURGE) {
            $CF_ZONE_ID = "";
            do_cloudflare_purge($CF_EMAIL, $CF_API, $CF_ZONE_ID, $data)
        }
    }
} else {
    include "403.php";
    header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden");
}
exit()
?>
