<?php
function getUserIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if( isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if( isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if( isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if( isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if( isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

function getUserInfo() {
    $userIP = getUserIP();
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    // Get IP details using an external API
    $ipDetails = file_get_contents("https://ipinfo.io/{$userIP}/json");
    $ipData = json_decode($ipDetails, true);

    $logEntry = [
        'ipv4' => $ipData['ip'],
        'ipv6' => isset($ipData['ipv6']) ? $ipData['ipv6'] : 'N/A',
        'subnet_mask' => 'N/A', // This requires more complex network analysis
        'gateway' => 'N/A', // This requires more complex network analysis
        'device_info' => $userAgent,
        'location' => $ipData['city'] . ', ' . $ipData['region'] . ', ' . $ipData['country'],
        'timestamp' => date('Y-m-d H:i:s')
    ];

    return $logEntry;
}

function logUserInfo($logEntry) {
    $file = '../logs.txt';
    $current = file_get_contents($file);
    $current .= json_encode($logEntry) . "\n";
    file_put_contents($file, $current);
}

$logEntry = getUserInfo();
logUserInfo($logEntry);

echo "Information logged successfully!";
?>
