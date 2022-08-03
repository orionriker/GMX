<?php ob_start(); session_name('GMX');session_start(); require "misc/header.php"; ?>

<title> <?php echo $_REQUEST["q"]; ?> - GMX</title>
</head>
    <body>
        <form class="sub-search-container" method="get" autocomplete="off">
            <a href="./"><img class="logo" src="static/images/gmx.png" width="64" height="64" alt="GMX Logo"></a>
            <input type="text" name="q" 
                <?php
                    $query = htmlspecialchars(trim($_REQUEST["q"]));
                    $query_encoded = urlencode($query);

                    if (1 > strlen($query) || strlen($query) > 256)
                    {
                        header("Location: ./");
                        die();
                    } 
 
                    echo "value=\"$query\"";
                ?>
            >
            <br>
            <?php
                $type = isset($_GET["type"]) ? (int) $_GET["type"] : 0;
                echo "<button class=\"hide\" name=\"type\" value=\"$type\"/></button>";
            ?>
            <button type="submit" class="hide"></button>
            <input type="hidden" name="p" value="0">
            <div class="sub-search-button-wrapper">
                <button name="type" value="0"<?php if($_GET["type"] == 0)echo ' class="active"'; ?>><i class="fa-solid fa-file"></i> General</button>
                <button name="type" value="1"<?php if($_GET["type"] == 1)echo ' class="active"'; ?>><i class="fa-solid fa-image"></i> Images</button>
                <button name="type" value="2"<?php if($_GET["type"] == 2)echo ' class="active"'; ?>><i class="fa-solid fa-eye"></i> Videos</button>
                <button name="type" value="3"<?php if($_GET["type"] == 3)echo ' class="active"'; ?>><i class="fa-solid fa-archive"></i> Torrents</button>
            </div>
        <hr>
        </form>

        <?php
            $config = require "config.php";
            require "misc/tools.php";

            $safe = get_safesearch();

            if(!str_contains($_SERVER['REQUEST_URI'], 'safe=')) $safenotset = true;

            $page = isset($_REQUEST["p"]) ? (int) $_REQUEST["p"] : $pagenotset = true;

            if($pagenotset == true || $safenotset == true) {
                if($pagenotset) {
                    $newuri = $_SERVER['REQUEST_URI'].'&page=0';
                }
                if($safenotset) {
                    if(isset($newuri)) {
                        $newuri = $newuri.'?safe=on';
                    } else
                    $newuri = $_SERVER['REQUEST_URI']."&safe=$safe";
                }
                header("Location: $newuri");
                ob_end_flush();
                exit;
            }

            $start_time = microtime(true);
            switch ($type)
            {
                case 0:
                    if (substr($query, 0, 1) == "!")
                        check_ddg_bang($query);
                    require "engines/google/text.php";
                    $results = get_text_results($query, $page);
                    if(!empty($results)) {
                        print_elapsed_time($start_time);
                        print_text_results($results);
                    } else {
                        $_SESSION['gmxerror'] = true;
                        print_no_results($query);
                    }
                    break;

                case 1:
                    $_SESSION['gmxerror'] = true;
                    require "engines/google/image.php";
                    $results = get_image_results($query_encoded, $page);
                    if(!empty($results)) {
                        print_elapsed_time($start_time);
                        print_image_results($results);
                    } else {
                        $_SESSION['gmxerror'] = true;
                        print_no_results($query);
                    }
                    break;

                case 2:
                    require "engines/google/video.php";
                    $results = get_video_results($query_encoded, $page);
                    if(!empty($results)) {
                        print_elapsed_time($start_time);
                        print_video_results($results);
                    } else {
                        $_SESSION['gmxerror'] = true;
                        print_no_results($query);
                    }
                    break;

                case 3:
                    if ($config->disable_bittorent_search)
                        echo "<p class=\"text-result-container\">The host disabled this feature! :C</p>";
                    else
                    {
                        require "engines/bittorrent/merge.php";
                        $results = get_merged_torrent_results($query_encoded);
                        if(!empty($results)) {
                            print_elapsed_time($start_time);
                            print_merged_torrent_results($results);
                        } else {
                            $_SESSION['gmxerror'] = true;
                            print_no_results($query);
                        }
                        break;
                    }
                    
                    break;

                default:
                    require "engines/google/text.php";
                    if(!empty($results)) {
                        print_elapsed_time($start_time);
                        print_text_results($results);
                    } else {
                        $_SESSION['gmxerror'] = true;
                        print_no_results($query);
                    }
                    break;
            }


            if ($type != 3 && !isset($_SESSION['gmxerror']))
            {
                echo "<div class=\"next-page-button-wrapper\">";

                    if ($page != 0) 
                    {
                        print_next_page_button("&lt;&lt;", 0, $query, $type); 
                        print_next_page_button("&lt;", $page - 10, $query, $type);
                    }
                    
                    for ($i=$page / 10; $page / 10 + 10 > $i; $i++)
                        print_next_page_button($i + 1, $i * 10, $query, $type);

                    print_next_page_button("&gt;", $page + 10, $query, $type);

                echo "</div>";
            }
        ?>

<?php require "misc/footer.php"; ?>
