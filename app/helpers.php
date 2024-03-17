<?php

function getTrackingDetailsByIp($userAgent, $ip, $created_at)
{
    $user_agent = $userAgent;
    $browser_name = 'Unknown';
    $platform = 'Unknown';
    $device_name = "Desktop";
    $device_model = "";

    //First get the platform?
    if (preg_match('/linux/i', $user_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $user_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
        $browser_name = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $user_agent)) {
        $browser_name = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/OPR/i', $user_agent)) {
        $browser_name = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Chrome/i', $user_agent) && !preg_match('/Edge/i', $user_agent)) {
        $browser_name = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $user_agent) && !preg_match('/Edge/i', $user_agent)) {
        $browser_name = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Netscape/i', $user_agent)) {
        $browser_name = 'Netscape';
        $ub = "Netscape";
    } elseif (preg_match('/Edge/i', $user_agent)) {
        $browser_name = 'Edge';
        $ub = "Edge";
    } elseif (preg_match('/Trident/i', $user_agent)) {
        $browser_name = 'Internet Explorer';
        $ub = "MSIE";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $user_agent, $matches)) {
        // we have no matching number just continue
    }
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($user_agent, "Version") < strripos($user_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    // Check if the user is using an iOS device
    if (preg_match('/(iPhone|iPod|iPad)/', $user_agent)) {
        // Get the device model name
        $device_model = preg_replace('/^.*\((.+)\)$/', '$1', $user_agent);

        // Set the device name to "iOS"
        $device_name = "iOS";
    } // Check if the user is using an Android device
    else if (preg_match('/Android/', $user_agent)) {
        // Get the device model name
        $device_model = preg_replace('/^.*;([^;]+)\sBuild.*$/', '$1', $user_agent);

        // Set the device name to "Android"
        $device_name = "Android";
    }

    $location_info = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));

    return [
        "ip" => $ip,
        "country" => $location_info->country,
        "country_code" => $location_info->countryCode,
        "region" => $location_info->region,
        "region_name" => $location_info->regionName,
        "city" => $location_info->city,
        "lat" => $location_info->lat,
        "lon" => $location_info->lon,
        "timezone" => $location_info->timezone,
        "isp" => $location_info->isp,
        "org" => $location_info->org,
        "org_as" => $location_info->as,
        "browser_name" => $browser_name,
        "browser_version" => $version,
        "device_name" => $device_name,
        "device_model" => $device_model,
        "os_name" => $platform,
        "user_agent" => $user_agent,
        "location" => json_encode($location_info),
        "created_at" => $created_at
    ];
}

