<?php error_reporting(E_ERROR);
$ip_low = ip2long("192.30.252.0");
$ip_high = ip2long("192.30.255.255");
if (!empty($SERVER["HTTP_CLIENT_IP"])) {
    $ip = ip2long($_SERVER["HTTP_CLIENT_IP"]);
} else {
    $ip = ip2long($_SERVER["REMOTE_ADDR"]);
}
$webHookJSON = file_get_contents("php://input");
$webHookData = json_decode($webHookJSON, true);
if ($ip >= $ip_low && $ip <= $ip_high) {
    if ($webHookData["repository.name"] == "BMN-Files") {
        shell_exec("/usr/bin/git -C /var/www/BMN pull");

        // Purge Cloudflare cache when a commit is pushed
        $CF_API_KEY = openssl_digest(openssl_digest(openssl_digest(file_get_contents("../BMN/cloudflare"), "sha512"), "sha512"), "sha512");
        $CF_ZONE_ID = "f1539009d9ffaf171559ba86d48bcf17";
        $CF_PURGE_URL = "https://api.cloudflare.com/client/v4/zones/".$CF_ZONE_ID."/purge_cache";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $CF_PURGE_URL);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "X-Auth-Email: ",
            "X-Auth-Key: ".$CF_API_KEY,
            "Content-Type: application/json"
        ));
        curl_exec($curl);
        curl_close($curl);
    } else {
        shell_exec("/usr/bin/git -C /var/www/html pull");
    }
} else {
    include "403.php";
    header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden");
}
exit()
?>
