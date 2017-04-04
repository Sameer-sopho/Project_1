 <!DOCTYPE html>
<html>
<body>

<?php

$ret = file_get_contents('http://www.shiksha.com/b-tech/colleges/b-tech-colleges-bangalore');
echo "My first PHP script!<br>";
echo "The source code of the page is:<br>";
echo htmlspecialchars($ret);
?>

</body>
</html> 