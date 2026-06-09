<?php 
$base_path = __DIR__."/";
$result=['data'=>[],'html_view'=>'','message'=>''];
try {
require $base_path."Dbhelper.php";
$myclass = new Dbhelper();

    

    try {
        $limit = isset($_GET['limit'])?(int)$_GET['limit']:5;
        $page = isset($_GET['page'])?(int)$_GET['page']:1;

        $total_records = $myclass->Count("SELECT count(id) as total FROM `user_tbl`");
        $total_page = ceil($total_records/$limit);
        $start = ($page - 1)*$limit;
        $limit_ = "LIMIT $start,$limit";
        
        $records = $myclass->FetchData("SELECT * FROM `user_tbl` ORDER BY id desc $limit_");
        $req_query_srt_arr= count($_SERVER['argv']) > 0?explode('&', $_SERVER['argv'][0]):[];
        $req_query_srt_arr = array_filter($req_query_srt_arr, function($item){
            return strpos($item, 'page=') !== 0 && strpos($item, 'limit=') !== 0;
        });
        $req_query_srt= count($req_query_srt_arr) > 0 ? implode('&', $req_query_srt_arr) : '';
     
        $pagination = $myclass->Pagination($records, $page, $limit, $total_records, $req_query_srt);
        $result['data'] = isset($pagination['data'])?$pagination['data']:[];
        $result['html_view'] = isset($pagination['html_view'])?$pagination['html_view']:"";
        
    } catch (\Exception $th) {
        echo "<pre>";
        echo "<small style='color: red;'>failed to fetch data. Error: ".$th->getMessage()."! </small>";
        echo "</pre>";
    }

} catch (\Exception $th) {
    echo "<pre>";
    echo "<small style='color: red;'>Error: ".$th->getMessage()."! </small>";
    echo "</pre>";
}

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