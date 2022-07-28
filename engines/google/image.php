<?php
    function get_image_results($query, $page=0)
    {
        global $config;

        $url = "https://www.google.$config->google_domain/search?&q=$query&start=$page&hl=$config->google_language&tbm=isch";
        $response = request($url);
        $xpath = get_xpath($response);

        $results = array();

        foreach($xpath->query("//a[@rel='noopener']") as $result)
        {       
                $image = $xpath->evaluate(".//img", $result)[0];

                if ($image) {
                    $url = check_for_privacy_frontend($result->getAttribute("href"));

                    var_dump($url);

                    $alt = $image->getAttribute("alt");
                    $thumbnail = urlencode($image->getAttribute("src"));

                    array_push($results, 
                        array (
                            "thumbnail" => $thumbnail,
                            "alt" => htmlspecialchars($alt),
                            "url" => htmlspecialchars($url)
                        )
                    );
    
                }
        }

        return $results;
    }

    function print_image_results($results)
    {
        echo "<div class=\"image-result-container\">";

            foreach($results as $result)
            {
                $thumbnail = $result["thumbnail"];
                $alt = $result["alt"];
                $url = $result["url"];

                echo "<a title=\"$alt\" href=\"$url\" target=\"_blank\">";
                echo "<img src=\"image_proxy?url=$thumbnail\">";
                echo "</a>";
            }

        echo "</div>";
    }
?>
