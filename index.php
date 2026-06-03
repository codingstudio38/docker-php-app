<?php 
$base_path = __DIR__."/";
$result=[];
try {
require $base_path."Dbhelper.php";
$myclass = new Dbhelper();
$limit = isset($_GET['limit'])?$_GET['limit']:5;
$page = isset($_GET['page'])?$_GET['page']:1;
$column = array("id","name","email_id","phone","password");
$data_res = $myclass->GetData("user_tbl",$column,array(1),$page,$limit,"`id` DESC");
if($data_res['status']==1){
    $data = $data_res['data'];
    $result['status'] = 1;
    $result['message'] = "Data found.";
    $result['data'] = $data;
    $result['html_view'] = $data_res['html_view'];
} else {
    $result['status'] = 0;
    $result['message'] = "Data not found.";
    $result['data'] = [];
    $result['html_view'] = $data_res['html_view'];
}
} catch (\Throwable $th) {
    echo "<pre>";
    echo $th->getMessage();
    echo "</pre>";
}
// echo "<pre>";
// print_r($_SERVER);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker PHP App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <h2>Docker PHP App</h2>
    <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result['data'] as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email_id']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['password']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5"><?= $result['html_view'] ?></th>
        </tr>
    </tfoot>
    
</table>
</body>
</html>