<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>Galgjeee</h1>
    <p>Maak een keuze</p>

    <form method="post" action="../php/willekeurig.php">
        <input type="submit" name="willekeurig" id="willekeurig" value="Willekeurig woord">
    </form>

    <form action="../php/zelf_kiezen.php" method="post">
        <input type="text" name="eigenWoord">
        <input type="submit" name="eigenWoorden" id="eigenWoorden" value="Eigen woord invullen">
    </form>

    <script src="zelf_kiezen.js">

    </script>
</body>
</html>