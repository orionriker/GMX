<?php
    return (object) array(

        // e.g.: fr -> https://google.fr/
        "google_domain"   => "com",
        // Google results will be in this language
        "google_language" => "en",

        "disable_bittorent_search" => false,
        "bittorent_trackers"       => "&tr=http%3A%2F%2Fnyaa.tracker.wf%3A7777%2Fannounce&tr=udp%3A%2F%2Fopen.stealth.si%3A80%2Fannounce&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce&tr=udp%3A%2F%2Fexodus.desync.com%3A6969%2Fannounce&tr=udp%3A%2F%2Ftracker.torrent.eu.org%3A451%2Fannounce",

        /* 
            Preset privacy friendly frontends for users, these can be overwritten by users in settings
            e.g.: "invidious" => "https://yewtu.be",
        */
        "invidious"  => "",
        "bibliogram" => "",
        "nitter"     => "",
        "libreddit"  => "",
        "proxitok"   => "",
        "wikiless"   => "",

        /*
            if this is set true Safesearch will be enabled of all search engines, these can be overwritten by users in settings
        */
        "safesearch" => true,

        /*
            Search results per page (Default Value: 15)
        */
        "search_results" => 15,

        /*
            GMX Themes, the user can choose a theme in the settings page
            Template for add your theme to this list:
            "THEMENAME" => array(
                'THEMEFILENAME',
                'THEMEICON',
            ),
            the THEMEFILENAME should not have the .css extension!
            the THEMEICON should be a fontawesome icon go to https://www.fontawesome.com/icons
            and find a icon that fits your theme.
            to disable a theme type // behind the theme like this:
            //"THEMENAME" => array(
            //    'THEMEFILENAME',
            //    'THEMEICON',
            //),
        */
        "themes" => array(
            "Dark" => array(
                'dark',
                'fa-solid fa-moon',
            ),
            "Light" => array(
                'light',
                'fa-solid fa-sun',
            ),
            "Auto" => array(
                'auto',
                'fa-solid fa-circle-half-stroke',
            ),
            "Nord" => array(
                'nord',
                'fa-solid fa-mountain',
            ),
            "Night Owl" => array(
                'night_owl',
                'fa-solid fa-feather',
            ),
            "Discord" => array(
                'discord',
                'fa-brands fa-discord',
            ),
        ),

        /*
            To send requests trough a proxy uncomment CURLOPT_PROXY and CURLOPT_PROXYTYPE:

            CURLOPT_PROXYTYPE options:

                CURLPROXY_HTTP
                CURLPROXY_SOCKS4
                CURLPROXY_SOCKS4A
                CURLPROXY_SOCKS5
                CURLPROXY_SOCKS5_HOSTNAME

            !!! ONLY CHANGE THE OTHER OPTIONS IF YOU KNOW WHAT YOU ARE DOING !!!
        */
        "curl_settings" => array(
            //CURLOPT_PROXY           => "ip:port",
            //CURLOPT_PROXYTYPE       => CURLPROXY_HTTP,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => "",
            CURLOPT_USERAGENT       => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36",
            CURLOPT_IPRESOLVE       => CURL_IPRESOLVE_V4,
            CURLOPT_CUSTOMREQUEST   => "GET",
            CURLOPT_PROTOCOLS       => CURLPROTO_HTTPS | CURLPROTO_HTTP,
            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTPS | CURLPROTO_HTTP,
            CURLOPT_MAXREDIRS       => 5,
            CURLOPT_TIMEOUT         => 8,
            CURLOPT_VERBOSE         => false
        ),

        // !!! DO NOT CHANGE THIS !!!
        "gmx_version" => "1.0.1"
    );
?>
