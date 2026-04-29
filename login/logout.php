<?php

setcookie("userID", 0, time() - 3600, "/pink/tchilders/tagStats/"); // deletes cookie
header("Location: ../login/login.html");

?>
