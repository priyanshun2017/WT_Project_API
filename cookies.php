<?php
$cookie_name = "PriyanshuNiranjan";
$cookie_value = "PTU(PEC)";
setcookie($cookie_name, $cookie_value, time() - 360, "/"); // 86400 = 1 day 
//To delete a cookie, use the setcookie() function with an expiration date in the past:
?>

<html>
<body>

<?php
if(!isset($_COOKIE[$cookie_name])) {
  echo "Cookie name '" . $cookie_name . "' is not set!</br>";
} else {
  echo "Cookie '" . $cookie_name . "' is set!<br>";
  echo "Value is: " . $_COOKIE[$cookie_name];
}
//Check if Cookies are Enabled
if(count($_COOKIE) > 0) {
    echo "</br>Cookies are enabled.";
  } else {
    echo "Cookies are disabled.";
  }
?>
</body>
</html>