<?

// separating url into its own local variable
extract($_GET);

// setting up curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// getting raw html
$ret = curl_exec($ch);
curl_close($ch);

// connection fail
if($ret === false)
{
    echo "Could not fetch data from Shiksha.com";
    exit;
}

preg_match('')
