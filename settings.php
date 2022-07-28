<?php
$config = require "config.php";


if (isset($_REQUEST["save"]) || isset($_REQUEST["reset"])) {
    if (isset($_SERVER["HTTP_COOKIE"])) {
        $cookies = explode(";", $_SERVER["HTTP_COOKIE"]);
        foreach($cookies as $cookie) 
        {
            $parts = explode("=", $cookie);
            $name = trim($parts[0]);
            setcookie($name, "", time() - 1000);
        }
    }   
}

function better_setcookie($name, $theme = false) {
    if (!empty($_REQUEST[$name]) && $theme !== true) {
        setcookie($name, $_REQUEST[$name], time() + (86400 * 90), '/');
        $_COOKIE[$name] = $_REQUEST[$name];
    } elseif (!empty($_REQUEST[$name]) && $theme == true) {
        setcookie($name, $_REQUEST['applytheme'], time() + (86400 * 90), '/');
        $_COOKIE['theme'] = $_REQUEST['applytheme'];
    }
}

function gmx_theme_set($theme) {
    if (!empty($theme)) {
        setcookie('theme', $theme, time() + (86400 * 90), '/');
        $_COOKIE['theme'] = $theme;
    }
}

if (isset($_REQUEST["save"])) {
    better_setcookie("disable_special");
    better_setcookie("invidious");
    better_setcookie("bibliogram");
    better_setcookie("nitter");
    better_setcookie("libreddit");
    better_setcookie("proxitok");
    better_setcookie("wikiless");
}

if(isset($_REQUEST['applytheme'])) {
    gmx_theme_set($_REQUEST['applytheme']);
}

if (isset($_REQUEST["save"]) || isset($_REQUEST["reset"]) || isset($_REQUEST['applytheme'])) {
    header("Location: ./settings");
    die();
}

require "misc/header.php";
?>
    <title>GMX - Settings</title>
    </head>
    <body>
        <div class="misc-container">
            <h1 class="mt-3">GM<span class="X">X</span> Settings</h1>
            <hr>
            <form method="post" enctype="multipart/form-data" autocomplete="off">
              <div>
                <h3>User Interface</h3>
                <h5 class="mt-3">Themes</h5>
                    <div class="row mt-4">
                        <div class="col">
                            <div class="settings-theme">
                                <p>Dark</p>
                                <button type="submit" name="applytheme" value="dark">Apply</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="settings-theme">
                                <p>Light</p>
                                <button type="submit" name="applytheme" value="light">Apply</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="settings-theme">
                                <p>Auto</p>
                                <button type="submit" name="applytheme" value="auto">Apply</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="settings-theme">
                                <p>Nord</p>
                                <button type="submit" name="applytheme" value="nord">Apply</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="settings-theme">
                                <p>Night Owl</p>
                                <button type="submit" name="applytheme" value="night_owl">Apply</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="settings-theme">
                                <p>Discord</p>
                                <button type="submit" name="applytheme" value="discord">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <label>Disable special queries (e.g.: currency conversion)</label>
                    <input type="checkbox" name="disable_special" <?php echo isset($_COOKIE["disable_special"]) ? "checked"  : ""; ?> >
                </div>
                <h3>Privacy friendly frontends</h3>
                <p>For an example if you want to view YouTube without getting spied on, click on "Invidious", find the instance that is most suitable for you then paste it in (correct format: https://example.com)</p>
                <div class="instances-container">   

                      <div>
                        <a for="invidious" href="https://docs.invidious.io/instances/" target="_blank">Invidious</a>
                        <input type="text" name="invidious" placeholder="Replace YouTube" value=
                            <?php echo isset($_COOKIE["invidious"]) ? htmlspecialchars($_COOKIE["invidious"])  : "\"$config->invidious\""; ?>
                        >
                      </div>

                      <div>
                        <a for="bibliogram" href="https://git.sr.ht/~cadence/bibliogram-docs/tree/master/docs/Instances.md" target="_blank">Bibliogram</a>
                        <input type="text" name="bibliogram" placeholder="Replace Instagram" value=
                            <?php echo isset($_COOKIE["bibliogram"]) ? htmlspecialchars($_COOKIE["bibliogram"]) : "\"$config->bibliogram\""; ?>
                        >
                      </div>

                      <div>
                        <a for="nitter" href="https://github.com/zedeus/nitter/wiki/Instances" target="_blank">Nitter</a>
                        <input type="text" name="nitter" placeholder="Replace Twitter" value=
                            <?php echo isset($_COOKIE["nitter"]) ? htmlspecialchars($_COOKIE["nitter"])  : "\"$config->nitter\""; ?>
                        >
                      </div>

                      <div>
                        <a for="libreddit" href="https://github.com/spikecodes/libreddit" target="_blank">Libreddit</a>
                        <input type="text" name="libreddit" placeholder="Replace Reddit" value=
                            <?php echo isset($_COOKIE["libreddit"]) ? htmlspecialchars($_COOKIE["libreddit"])  : "\"$config->libreddit\""; ?>
                        >
                      </div>

                      <div>
                        <a for="proxitok" href="https://github.com/pablouser1/ProxiTok/wiki/Public-instances" target="_blank">ProxiTok</a>
                        <input type="text" name="proxitok" placeholder="Replace TikTok" value=
                            <?php echo isset($_COOKIE["proxitok"]) ? htmlspecialchars($_COOKIE["proxitok"])  : "\"$config->proxitok\""; ?>
                        >
                      </div>

                      <div>
                        <a for="wikiless" href="https://codeberg.org/orenom/wikiless" target="_blank">Wikiless</a>
                        <input type="text" name="wikiless" placeholder="Replace Wikipedia" value=
                            <?php echo isset($_COOKIE["wikiless"]) ? htmlspecialchars($_COOKIE["wikiless"])  : "\"$config->wikiless\""; ?>
                        >
                      </div>
                </div>
                <div>
                  <button type="submit" name="save" value="1">Save</button>
                  <button type="submit" name="reset" value="1">Reset</button>
                </div>
            </form>

            <h1 class="mt-3">About GM<span class="X">X</span></h1>
            <hr>
            <p class="mb-3">GM<span class="X">X</span>(A fork of <a class="text-muted" href="https://github.com/hnhx/librex/">LibreX</a>), is a meta search engine that is private has no javascript, no tracking, no analytics. Your ip is private we use the THIS host's ip AKA THIS website's ip instead of your ip to get results for your query from google and bittorrent sites privately.</p>
            <p class="mb-2">Your GMX Version: <span style="color: var(--gmx-blue);"><?php echo $config->gmx_version; ?></span></p>
            <p class="mb-5">GMX is developed and maintained by: <span style="color: var(--gmx-blue);">gamemaster123356</span></p>
        </div>
<?php require "misc/footer.php"; ?>
