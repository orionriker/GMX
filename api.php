<?php
    error_reporting(E_ERROR | E_PARSE);
    $config = require "config.php";
    require "misc/tools.php";

    if (!isset($_REQUEST['q']) || !isset($_REQUEST['p']) || !isset($_REQUEST['type'])) {
?>
<html>
    <head>
        <title>GMX - API</title>
    </head>
<body>
    <center>
    <h2>GMX API</h2>
    </center>
    <hr>
    <p>Example API <b>[GET]</b> request: <a href="./api?q=gentoo&p=2&type=0">/api?q=gentoo&p=2&type=0</a></p>
    <p style="margin-top: 30px; margin-left: 20px;"><b>"q"</b> is the keyword</p>
    <p style="margin-left: 20px;"><b>"p"</b> is the result page <b>(the first page is 0)</b></p>
    <p style="margin-left: 20px;"><b>"type"</b> is the search type <b>(0=text, 1=image, 2=video, 3=torrent)</b></p>
    <p style="margin-top: 30px;">The results are going to be in <b>JSON format</b>.</p>
    <p>The API supports both <b>POST</b> and <b>GET</b> requests.</p>
</body>
</html>
<?php
        die();
    }

    $query = $_REQUEST["q"];
    $query_encoded = urlencode($query);
    $page = isset($_REQUEST["p"]) ? (int) $_REQUEST["p"] : 0;
    $type = isset($_REQUEST["type"]) ? (int) $_REQUEST["type"] : 0;

    $results = array();

    switch ($type)
    {
        case 0:
            if(empty($_REQUEST['q'])) $results = print_api_error('query is empty', 'GMX_Q_NO');
            else {
                require "engines/google/text.php";
                $results = get_text_results($query, $page);
                if(empty($results)) $results = print_api_error('no results found', 'GMX_RES_NO');
            }
            break;
        case 1:
            if(empty($_REQUEST['q'])) $results = print_api_error('query is empty', 'GMX_Q_NO');
            else {
                require "engines/google/image.php";
                $results = get_image_results($query_encoded, $page);
                if(empty($results)) $results = print_api_error('no results found', 'GMX_RES_NO');
            }
            break;
        case 2:
            if(empty($_REQUEST['q'])) $results = print_api_error('query is empty', 'GMX_Q_NO');
            else {
                require "engines/google/video.php";
                $results = get_video_results($query_encoded, $page);
                if(empty($results)) $results = print_api_error('no results found', 'GMX_RES_NO');
            }
            break;
        case 3:
            if(empty($_REQUEST['q'])) $results = print_api_error('query is empty', 'GMX_Q_NO');
            else {
                if ($config->disable_bittorent_search)
                    $results = print_api_error('bittorrent search is disabled by host', 'GMX_BIT_DIS');
                else {
                    require "engines/bittorrent/merge.php";
                    $results = get_merged_torrent_results($query_encoded);
                    if(empty($results)) $results = print_api_error('no results found', 'GMX_RES_NO');
                }
            }
            break;
        default:
            if(empty($_REQUEST['q'])) $results = print_api_error('query is empty', 'GMX_Q_NO');
            else {
                require "engines/google/text.php";
                $results = get_text_results($query_encoded, $page);
                if(empty($results)) $results = print_api_error('no results found', 'GMX_RES_NO');
            }
            break;
    }

    header("Content-Type: application/json");
    echo json_encode($results, JSON_PRETTY_PRINT);
    if(isset($results['error'])) http_response_code('422');
    exit;
?>