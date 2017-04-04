<?php



// separating url into its own local variable
extract($_GET);

// get the raw html
$ret = file_get_contents($url);


// remove the new lines so that regex doesn't break halfway
preg_replace('/\n/','', $ret);

// initialize the array
$college = array();

// find and store all the details of the colleges
$num = preg_match_all('/<div class="clg-tpl-parent">(.*?)autocomplete="off"><\/div>/', $ret, $matches);


$c = array();
$college_name = array();
$ca = array();
$college_address = array();
$f = array();
$facilities = array();
//$r = array();
//$reviews = array();

for($i = 0; $i < $num ; $i++)
{
    preg_match_all('/<h2 class="tuple-clg-heading"><a href="(?:.*?)">(?:.*?)<\/a>\n<p>| (.*?)<\/p><\/h2>/', $matches[0][$i], $c);
    preg_match_all('/<h2 class="tuple-clg-heading"><a href="(?:.*?)">(?:.*?)<\/a>\n<p>| (.*?)<\/p><\/h2>/', $matches[0][$i], $ca);
    preg_match_all('/<h2 class="tuple-clg-heading"><a href="(?:.*?)">(?:.*?)<\/a>\n<p>| (.*?)<\/p><\/h2>/', $matches[0][$i], $f);
    //preg_match_all('/<h2 class="tuple-clg-heading"><a href="(?:.*?)">(?:.*?)<\/a>\n<p>| (.*?)<\/p><\/h2>/', $matches[0][$i], $r);
    
    $college_name[$i] = $c[1][0];
    $college_address[$i] = $ca[1][0];
    $facilities[$i] = $f[1][0];
    //$reviews[$i] = $r[1][0];
    
}

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
        print_r("<pre>");
        print_r($college["cname"]);
        //print_r($college["cadd"]);
        
        ?>
    </body>
</html>