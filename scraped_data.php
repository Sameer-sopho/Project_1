<?php


// separating url into its own local variable
extract($_GET);

// get the raw html
if(!($ret = file_get_contents($url)))
{
    echo "Couldn't fetch html data.";
    exit;
}



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

// setting up connection
$servername = "localhost";
$username = "sameerjathavedan";
$password = "3vXt73bGW7mEcGnI";
$dbname = "Project_1";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// clearing previous entries in table
$sql = "TRUNCATE TABLE  college;";
$mysqli->query($sql) or die($mysqli->error);


// entering new data into table
for( $i=0 ; $i < count($college["name"]) ; $i++ )
{
    $name = $mysqli->escape_string($college["name"][$i]);
    $address = $mysqli->escape_string($college["address"][$i]);
    $facilities = $mysqli->escape_string($college["facilities"][$i]);
    $reviews = intval($college["reviews"][$i]);
    
    $sql = "INSERT IGNORE INTO college (name, address, facilities, reviews) VALUES ('$name', '$address', '$facilities', '$reviews')";
    
    $mysqli->query($sql) or die($mysqli->error);
}

?>






<html>
    <head>
        <title>Scraped Colleges</title>
         <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div style="text-align: center;">
        <h1>Scraped Colleges</h1> 
        </div>
        <br><br>
         <table class="table table-striped">
          <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Address</th>
            <th>Facilities</th>
            <th>Reviews</th>
          </tr>
          <?php
          
          for( $i=0 ; $i < count($college["name"]) ; $i++ )
          {
            echo "<tr>"
            . "<td>" . ($i+1) . "</td>" 
            . "<td>" . $college["name"][$i] . "</td>" 
            . "<td>" . $college["address"][$i] . "</td>" 
            . "<td>" . $college["facilities"][$i] . "</td>"
            . "<td>" . $college["reviews"][$i] . "</td>"
            . "</tr>";
          }
          
          ?>
    </body>
</html>