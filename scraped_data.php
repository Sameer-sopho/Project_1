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
$college["name"] = $matcha[1];

// find and store the addresses
preg_match_all('/<p>\| (.*?)<\/p><\/h2>/', $ret, $matchb);
$college["address"] = $matchb[1];

// find the facilities code block of all colleges
preg_match_all('/<\/p><\/h2>(.*?)<\/ul>/s', $ret, $matchc);

// separate and store the facilities of each individual college 
for( $i=0 ; $i < count($matchc[1]) ; $i++ )
{
    if(preg_match_all('/<h3>(.*?)<\/h3>/', $matchc[1][$i], $matchca))
    {
        $college["facilities"][$i] = implode(', ', $matchca[1]);
    }
    else
    {
        $college["facilities"][$i] = "No facilities available";
    }
    
    
}



// find the reviews code block of all colleges
preg_match_all('/<section class="tpl-curse-dtls">(.*?)<p class="clr">/s', $ret, $matchd);



// store the reviews of each individual college
for( $i=0 ; $i < count($matchd[1]) ; $i++ )
{
    if(preg_match_all('/<span><b>(\d+)<\/b>/', $matchd[1][$i], $matchda))
    {
        $college["reviews"][$i] = $matchda[1][0];
    }
    else
    {
        $college["reviews"][$i] = '0';
    }
    
}





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
        //print_r($college["name"]);
        //print_r($college["address"]);
        //print_r($college["facilities"]);
        //print_r($college["reviews"]);
        //print($matchda);
        //print_r($matchc[1]);
        print_r($college);
        //print($temp);
        //echo "<br><br>";
        //print_r($matchc[1]);
        //print_r($matchd[1]);
        
        ?>
    </body>
</html>