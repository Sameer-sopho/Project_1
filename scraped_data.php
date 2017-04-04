<?php



// separating url into its own local variable
extract($_GET);

// get the raw html
$ret = file_get_contents($url);


// remove the new lines so that regex doesn't break halfway
preg_replace('/\n/','', $ret);

// initialize the array
$college = array();

// find and store the names
preg_match_all('/<h2 class="tuple-clg-heading"><a href="(?:.*?)">(.*?)<\/a>/', $ret, $matches);
$college["cname"] = $matches[1];



?>



<html>
    <head>
        <title>Scraped Data</title>
    </head>
    <body>
        <?php
        
        //echo "The source code of the page is:<br>".htmlspecialchars($ret);
        //print_r("<pre>");
        //print_r($matches);
        //print_r("<pre>");
        //print_r($college["cname"]);
        
        ?>
    </body>
</html>