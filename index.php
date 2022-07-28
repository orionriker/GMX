<?php
$serverres = http_response_code();
require "misc/header.php";
?>
        <title>GMX</title>
        </head>
        <body>
        <?php
             if($serverres !== 200) {
                if($serverres == 400) {
                        $errorcode = '400';
                        $errordes = 'Bad request.';
                }
                if($serverres == 403) {
                        $errorcode = '403';
                        $errordes = 'The requested URL <b>'.parse_url($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], PHP_URL_PATH).'</b> is forbidden.';
                }
                if($serverres == 404) {
                        $errorcode = '404';
                        $errordes = 'The requested URL <b>'.parse_url($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], PHP_URL_PATH).'</b> was not found.';
                }
                if($serverres == 405) {
                        $errorcode = '405';
                        $errordes = 'Method not allowed.';
                }
                if($serverres == 500) {
                        $errorcode = '500';
                        $errordes = 'An unknown error occurred.';
                }
                if($serverres == 501) {
                        $errorcode = '501';
                        $errordes = 'Not implemented.';
                }
                if($serverres == 502) {
                        $errorcode = '502';
                        $errordes = 'Bad gateway.';
                }
                if($serverres == 504) {
                        $errorcode = '504';
                        $errordes = 'Gateway timeout.';
                }
                if($serverres == 505) {
                        $errorcode = '505';
                        $errordes = 'HTTP version not supported.';
                }
        ?>
                <div class="search-container">
                        <h1 class="mb-1">GM<span class="X">X</span></h1>
                        <p class="mb-4"><b><?php echo $errorcode; ?></b> That's an error.</p>
                        <p><?php echo $errordes; ?></p>
                </div>
        <?php } else { ?>
                <div class="p-2"><a class="float-end" href="./settings"><button class="settings-button"><i class="fa-solid fa-cog"></i></button></a></div>
                <div class="clearfix"></div>
                <form class="search-container" action="search" method="get" autocomplete="off">
                        <h1 class="mb-0">GM<span class="X">X</span></h1>
                        <input type="text" class="mt-3" name="q"/>
                        <input type="hidden" name="p" value="0"/>
                        <input type="hidden" name="type" value="0"/>
                        <input type="submit" class="hide"/><br>
                        <button class="search-button mt-4" name="type" value="0" type="submit">GMX Search</button>
                        <button class="search-button mt-4" name="type" value="3" type="submit">Search Torrents</button>
                </form>
        <?php } ?>
<?php require "misc/footer.php"; ?>
