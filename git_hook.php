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
    $curl = curl_init();
    $curl_opt = array(
        CURLOPT_URL => 'https://api.cloudflare.com/client/v4/zones/'.$zone_id.'/purge_cache',
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_POSTFIELDS => json_encode(array(
            "files" => $file_array
        )),
        CURLOPT_HTTPHEADER => array(
            "X-Auth-Email: ".$email,
            "X-Auth-Key: ".$api_key,
            "Content-Type: application/json"
        )
    );
    curl_setopt_array($curl, $curl_opt);
    $output = json_decode(curl_exec($curl), true);
    curl_close($curl);
    if (!$output['success']) {
        header($_SERVER['SERVER_PROTOCOL']." 400 Bad Request");
    }
}
if ($ip >= $ip_low && $ip <= $ip_high) {
    header("Content-Type: application/json; charset=utf-8");
    $webHookJSON = file_get_contents("php://input");
    $webHookData = json_decode($webHookJSON, true);
    if ($CF_DO_PURGE) {
        $CF_EMAIL = file_get_contents("../email");
        $CF_API = file_get_contents("../cloudflare_api");
        $head_commit = $webHookData['head_commit'];
        $removed = $head_commit['removed'];
        $modified = $head_commit['modified'];
        $files = array_unique(array_merge($removed, $modified));
    }

    if ($webHookData["repository"]["name"] == "BMN-Files") {
        shell_exec("/usr/bin/git -C /var/www/BMN pull");

        // Purge Cloudflare cache when a commit is pushed
        if ($CF_DO_PURGE) {
            $CF_ZONE_ID = "f1539009d9ffaf171559ba86d48bcf17";
            foreach($files as &$value) {
                $value = "http://files.brilliant-minds.tk/".$value;
            }
            unset($value);
            do_cloudflare_purge($CF_EMAIL, $CF_API, $CF_ZONE_ID, $files);
        }
    } else {
        shell_exec("/usr/bin/git -C /var/www/html pull");

        if ($CF_DO_PURGE) {
            $CF_ZONE_ID = "815d413ab92fd4066266c2559a22a3af";
            foreach($files as &$value) {
                $value = "https://vps.wolfy1339.com/".$value;
            }
            unset($value);
            do_cloudflare_purge($CF_EMAIL, $CF_API, $CF_ZONE_ID, $files);
        }
    }
} else {
    include "403.php";
    header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden");
}
exit()
?>
