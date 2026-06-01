<?php 
try {
    $base_path = __DIR__."/";
    require $base_path."config.php";
} catch (\Throwable $th) {
    echo "<pre>";
    echo $th->getMessage();
    echo "</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker PHP App</title>
</head>
<body>
    <h2>Docker PHP App</h2>
</body>
</html>