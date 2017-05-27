<?php

include(dirname(__FILE__) . "/../utils/Util.php");
Util::routing(null);
$username = $_SESSION["username"];
$userType = $_SESSION["userType"];
$userid = $_SESSION["userid"];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
    <script>
        "use strict";
        const userid = "<?php echo $userid; ?>";
    </script>
</head>
<body>
    <h1 style="text-align: center">Welcome CycleTwo <?php echo $username;?></h1>
</body>
</html>