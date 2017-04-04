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
preg_match_all('/<h2 class="tuple-clg-heading"><a href="(?:.*?)">(.*?)<\/a>/', $ret, $matcha);
$college["cname"] = $matcha[1];

//find and store the addresses
preg_match_all('/<p>\| (.*?)<\/p><\/h2>/', $ret, $matchb);
$college["cadd"] = $matchb[1];

?>



<html>
    <head>
        <title>Scraped Data</title>
    </head>
    <body>
        <?php
        
        //echo "The source code of the page is:<br>".htmlspecialchars($ret);
        print_r("<pre>");
        //print_r($matcha[1]);
        //print_r($matchb[1]);
        print_r($college["cname"]);
        print_r($college["cadd"]);
        
        
        ?>
    </body>
</html>