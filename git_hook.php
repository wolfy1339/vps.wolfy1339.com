<?php error_reporting(E_ERROR);
$ip_low = ip2long("192.30.252.0");
$ip_high = ip2long("192.30.255.255");
if (!empty($SERVER["HTTP_CLIENT_IP"])) {
    $ip = ip2long($_SERVER["HTTP_CLIENT_IP"]);
} else {
    $ip = ip2long($_SERVER["REMOTE_ADDR"]);
}
$CF_DO_PURGE = False;

if ($ip >= $ip_low && $ip <= $ip_high) {
    $webHookJSON = file_get_contents("php://input");
    $webHookData = json_decode($webHookJSON, true);
    if ($webHookData["repository"]["name"] == "BMN-Files") {
        shell_exec("/usr/bin/git -C /var/www/BMN pull");

        // Purge Cloudflare cache when a commit is pushed
        if ($CF_DO_PURGE) {
            $CF_EMAIL = file_get_contents("email");
            $CF_API = openssl_digest(openssl_digest(openssl_digest(file_get_contents("cloudflare"), 'sha512'), 'sha512'), 'sha512');
            $CF_ZONE_ID = "f1539009d9ffaf171559ba86d48bcf17";
            $CF_PURGE_URL = 'https://api.cloudflare.com/client/v4/zones/'.$CF_ZONE_ID.'/purge_cache';
    
            $webHookData = json_decode(file_get_contents("php://input"), true);
            $removed = $webHookData['removed'];
            $modified = $webHookData['modified'];
            $data = json_encode(array_merge($removed, $modified));                                                                 
    
            $curl = curl_init();
            $curl_opt = array(
                CURLOPT_URL => $CF_PURGE_URL,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "X-Auth-Email: ".$CF_EMAIL,
                    "X-Auth-Key: ".$CF_API_KEY,
                    "Content-Type: application/json"
                )
            );
            curl_setopt_array($curl, $curl_opt);
            curl_exec($curl);
            curl_close($curl);
        }
    } else {
        shell_exec("/usr/bin/git -C /var/www/html pull");
    }
} else {
    include "403.php";
    header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden");
}
exit()
?>
