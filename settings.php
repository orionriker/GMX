<?php
$config = require "config.php";
require "misc/tools.php";

if (isset($_REQUEST["save"]) || isset($_REQUEST["reset"])) {
    if (isset($_SERVER["HTTP_COOKIE"])) {
        $cookies = explode(";", $_SERVER["HTTP_COOKIE"]);
        foreach($cookies as $cookie) 
        {
            $parts = explode("=", $cookie);
            $name = trim($parts[0]);
            if($name !== 'safesearch')
            setcookie($name, "", time() - 1000);
        }
    }   
}

function better_setcookie($name) {
    setcookie($name, $_REQUEST[$name], time() + (86400 * 90), '/');
    $_COOKIE[$name] = $_REQUEST[$name];
}

function gmx_theme_set($theme) {
    if (!empty($theme)) {
        setcookie('theme', $theme, time() + (86400 * 90), '/');
        $_COOKIE['theme'] = $theme;
    }
}

if (isset($_REQUEST["save"])) {
    if($_REQUEST['dis_special_queries'] == true)
    better_setcookie("dis_special_queries");
    if(empty($_REQUEST['safesearch'])) $_REQUEST['safesearch'] = 'off';
    better_setcookie("safesearch");
    if(!empty($_REQUEST['invidious']))
    better_setcookie("invidious");
    if(!empty($_REQUEST['bibliogram']))
    better_setcookie("bibliogram");
    if(!empty($_REQUEST['nitter']))
    better_setcookie("nitter");
    if(!empty($_REQUEST['libreddit']))
    better_setcookie("libreddit");
    if(!empty($_REQUEST['proxitok']))
    better_setcookie("proxitok");
    if(!empty($_REQUEST['wikiless']))
    better_setcookie("wikiless");
}

if(isset($_REQUEST['applytheme'])) {
    gmx_theme_set($_REQUEST['applytheme']);
}

if (isset($_REQUEST["save"]) || isset($_REQUEST["reset"]) || isset($_REQUEST['applytheme'])) {
    header("Location: ./settings");
    die();
}

$safe = get_safesearch();
if($safe == 'on') $safe = 'checked'; elseif($safe == 'on') $safe = '';

require "misc/header.php";
?>
    <title>GMX - Settings</title>
    </head>
    <body>
    <h1 class="mt-3 text-center">GM<span class="X">X</span> Settings</h1>
    <hr>
    <form method="post" enctype="multipart/form-data" autocomplete="off">
        <div class="misc-container">
            <h3 style="color: var(--gmx-blue);">User Interface</h3>
            <h5 class="mt-3">Themes</h5>
                <table class="table mt-4 mb-3 rounded-3 shadow" style="color: var(--main-fg); background: var(--secondary-bg);">
                    <?php
                        $keys = array_keys($config->themes);
                        $themecount = count($keys);
                        for ($i = 0; $i < $themecount; $i++) {
                            $themename = $keys[$i];
                            $themeslug = $config->themes[$keys[$i]][0];
                            $themeicon = $config->themes[$keys[$i]][1];
                    ?>
                    <tr>
                        <td class="border-0 p-3 text-start"><span><i class="<?php echo $themeicon; ?>"></i> <?php echo $themename; ?></span></td>
                        <td class="border-0 text-end p-3">
                            <input class="form-check-input" type="radio" name="applytheme" value="<?php echo $themeslug; ?>" <?php if($_COOKIE['theme'] == $themeslug || !isset($_COOKIE['theme']) && $themeslug == 'auto') echo 'checked'; ?>>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
                <h5 class="mt-4 mb-4">Search</h5>
                <table class="table mb-5 rounded-3 shadow" style="color: var(--main-fg); background: var(--secondary-bg);">
                    <tr>
                        <td class="border-0 text-start p-3"><span><i class="fa-solid fa-shield"></i> Safe Search <span class="tooltip-wrapper tooltip-toggle t-top" data-tooltip-text="Helps hide explicit content on Search"><i class="text-muted fa-regular fa-sm fa-circle-question" style="margin-left: 5px;"></i></span></span></td>
                        <td class="border-0 text-end p-3"><div class="mb-0 form-switch"><input class="form-check-input" type="checkbox" name="safesearch" <?php echo $safe; ?>></div></td>
                    </tr>
                    <tr>
                        <td class="border-0 text-start p-3"><span><i class="fa-solid fa-ban"></i> Disable Special Queries <span class="tooltip-wrapper tooltip-toggle t-top" data-tooltip-text="eg.: currency conversion"><i class="text-muted fa-regular fa-sm fa-circle-question" style="margin-left: 5px;"></span></span></td>
                        <td class="border-0 text-end p-3"><div class="mb-0 form-switch"><input class="form-check-input" type="checkbox" name="dis_special_queries" <?php echo isset($_COOKIE["dis_special_queries"]) ? "checked"  : ""; ?>></div></td>
                    </tr>
                </table>
                <h3 style="color: var(--gmx-blue);">Privacy</h3>
                <h5 class="mt-3">Privacy friendly frontends</h5>
                <p>For an example if you want to view YouTube without getting spied on, click on "Invidious", find the instance that is most suitable for you then paste it in (correct format: https://example.com)</p>
                <div class="instances-container rounded-3 shadow p-3 mb-3" style="color: var(--main-fg); background: var(--secondary-bg);">   
                    <div>
                        <a for="invidious" style="text-decoration: none;" href="https://docs.invidious.io/instances/" target="_blank"><i class="fa-brands fa-youtube"></i> Invidious</a>
                        <input type="text" name="invidious" placeholder="Replace YouTube" value=
                            <?php echo isset($_COOKIE["invidious"]) ? htmlspecialchars($_COOKIE["invidious"])  : "\"$config->invidious\""; ?>
                        >
                    </div>

                    <div>
                        <a for="bibliogram" style="text-decoration: none;" href="https://git.sr.ht/~cadence/bibliogram-docs/tree/master/docs/Instances.md" target="_blank"><i class="fa-brands fa-instagram"></i> Bibliogram</a>
                        <input type="text" name="bibliogram" placeholder="Replace Instagram" value=
                            <?php echo isset($_COOKIE["bibliogram"]) ? htmlspecialchars($_COOKIE["bibliogram"]) : "\"$config->bibliogram\""; ?>
                        >
                    </div>

                    <div>
                        <a for="nitter" style="text-decoration: none;" href="https://github.com/zedeus/nitter/wiki/Instances" target="_blank"><i class="fa-brands fa-twitter"></i> Nitter</a>
                        <input type="text" name="nitter" placeholder="Replace Twitter" value=
                            <?php echo isset($_COOKIE["nitter"]) ? htmlspecialchars($_COOKIE["nitter"])  : "\"$config->nitter\""; ?>
                        >
                    </div>

                    <div>
                        <a for="libreddit" style="text-decoration: none;" href="https://github.com/spikecodes/libreddit" target="_blank"><i class="fa-brands fa-reddit"></i> Libreddit</a>
                        <input type="text" name="libreddit" placeholder="Replace Reddit" value=
                            <?php echo isset($_COOKIE["libreddit"]) ? htmlspecialchars($_COOKIE["libreddit"])  : "\"$config->libreddit\""; ?>
                        >
                    </div>

                    <div>
                        <a for="proxitok" style="text-decoration: none;" href="https://github.com/pablouser1/ProxiTok/wiki/Public-instances" target="_blank"><i class="fa-brands fa-tiktok"></i> ProxiTok</a>
                        <input type="text" name="proxitok" placeholder="Replace TikTok" value=
                            <?php echo isset($_COOKIE["proxitok"]) ? htmlspecialchars($_COOKIE["proxitok"])  : "\"$config->proxitok\""; ?>
                        >
                    </div>

                    <div>
                        <a for="wikiless" style="text-decoration: none; text-align:start;" href="https://codeberg.org/orenom/wikiless" target="_blank"><i class="fa-brands fa-wikipedia-w"></i> Wikiless</a>
                        <input type="text" name="wikiless" placeholder="Replace Wikipedia" value=
                            <?php echo isset($_COOKIE["wikiless"]) ? htmlspecialchars($_COOKIE["wikiless"])  : "\"$config->wikiless\""; ?>
                        >
                    </div>
                </div>
            </div>
            <hr>
            <div class="mb-4 text-center">
                <button class="btn-gmx" style="margin-right: 4px;" type="submit" name="save" value="1">Save</button>
                <button class="btn-gmx" style="margin-left: 4px;" type="submit" name="reset" value="1">Reset</button>
            </div>
        </form>
<?php require "misc/footer.php"; ?>
