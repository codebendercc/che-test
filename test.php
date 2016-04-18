<?PHP

header('Content-type: text/plain; charset=utf8', true);

function check_header($name, $value = false) {
    
    if(!isset($_SERVER[$name])) {
        return false;
    }
    if($value && $_SERVER[$name] != $value) {
        return false;
    }
    return true;
}

function sendFile($path) {
    header($_SERVER["SERVER_PROTOCOL"].' 200 OK', true, 200);
    header('Content-Type: application/octet-stream', true);
    header('Content-Disposition: attachment; filename='.basename($path));
    header('Content-Length: '.filesize($path), true);
    header('x-MD5: '.md5_file($path), true);
    readfile($path);
}

// Make sure the User Agent is correct

if(!check_header('HTTP_USER_AGENT', 'ESP8266-http-Update')) {
    header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden', true, 403);
    echo "only for ESP8266 updater!\n";
    exit();
}

// Extra checks for the rest of the User Agents. Just checks they have a value

if(
    !check_header('HTTP_X_ESP8266_STA_MAC') ||
    !check_header('HTTP_X_ESP8266_AP_MAC') ||
    !check_header('HTTP_X_ESP8266_FREE_SPACE') ||
    !check_header('HTTP_X_ESP8266_SKETCH_SIZE') ||
    !check_header('HTTP_X_ESP8266_CHIP_SIZE') ||
    !check_header('HTTP_X_ESP8266_SDK_VERSION') ||
    !check_header('HTTP_X_ESP8266_VERSION')
) {
    header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden', true, 403);
    echo "only for ESP8266 updater! (header)\n";
    exit();
}

$currentVersion = intval(file_get_contents("/tmp/version"));



if(intval($_SERVER['HTTP_X_ESP8266_VERSION']) >= $currentVersion)
{
    file_put_contents("./devices/".$_SERVER['HTTP_X_ESP8266_STA_MAC'], $_SERVER['HTTP_X_ESP8266_VERSION']);

    header($_SERVER["SERVER_PROTOCOL"].' 304 Not Modified', true, 304);
}
else
{
    sendFile("./binaries/sketch.ino.bin.v".$currentVersion);
}
exit();
