<?php

class Utils
{
    // Function to generate a random string of a specified length using given characters
    public function generateString($length = 32, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $randomString = null;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    // Function to retrieve a system root filepath of website project
    public function getRootPath($extraPath = "")
    {
        return $_SERVER["DOCUMENT_ROOT"] . $extraPath;
    }

    // Function to retrieve a system root filepath of website project
    public function getPublicPath($extraPath = "")
    {
        return $_SERVER["DOCUMENT_ROOT"] . "/public" . $extraPath;
    }

    // Function to retrieve a query string parameter by key, or return all query string parameters if key is not specified
    public function getQueryString($key = null)
    {
        if (isset($key)) {
            if (isset($_GET[$key])) {
                return $_GET[$key];
            } else {
                return null;
            }
        } else {
            return $_GET;
        }
    }

    // Function to get the domain of the current URL
    public function getDomain()
    {
        $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $urlParts = parse_url($currentUrl);
        $domain = $urlParts['host'];
        return $domain;
    }

    public // Function to calculate and return the execution time in seconds since a global start time
    function getLoadTime()
    {
        global $startTime;
        $endTime = microtime(true);
        $execution_time = ($endTime - $startTime);
        return round($execution_time, 4);
    }

    // Function to set a key-value pair in a global values array
    public function setValue($key, $value)
    {
        global $values;
        $values[$key] = $value;
    }

    // Function to retrieve a value by key from a global values array
    public function getValue($key)
    {
        global $values;

        if (isset($values[$key])) {
            return $values[$key];
        } else {
            return null;
        }
    }

    // Function to Get Client's Operating System
    public function getClientOS($formatted = true)
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $osArray = array(
            '/windows nt 10/i'     => 'Windows 10',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile'
        );

        foreach ($osArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                return $value;
            }
        }

        return null;
    }

    // Function to Get Server's Operating System
    public function getServerOS()
    {
        return PHP_OS_FAMILY;
    }
}
