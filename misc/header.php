<?php
error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html >
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta charset="UTF-8"/>
        <meta name="description" content="A privacy respecting meta search engine."/>
        <meta name="referrer" content="no-referrer"/>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" type="text/css" href="/static/css/styles.css"/>
        <link title="GMX search" type="application/opensearchdescription+xml" href="/opensearch.xml?method=POST" rel="search"/>
        <link rel="stylesheet" type="text/css" href="<?php
                echo "/static/css/";
                if (isset($_COOKIE["theme"]) || isset($_REQUEST["theme"]))
                    echo htmlspecialchars((isset($_COOKIE["theme"]) ? $_COOKIE["theme"] : $_REQUEST["theme"]) . ".css");
                else
                echo "dark.css";
        ?>"/>
