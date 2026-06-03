<?php 
$base_path = __DIR__."/";
require $base_path. "/Dbconnect.php";
class Dbhelper {
    use DB{
        DB::CONNECT as protected MYCONNECT;
        DB::disconnect as protected MYDISCONNECT;
        DB::dbconfig as protected MYDBCONFIG;
    }
  private $CONNECT = null;
  private $dbconfig = null;
  public function __construct(){
   $this->CONNECT=$this->MYCONNECT();
   $this->dbconfig=$this->MYDBCONFIG();
  }
 

  public function GetData(string $table,array $column,array $option,int $page, int $limit,string $orderby){
    try {
        if(!$this->tableExists($table)){
          throw new Exception("Table not found.");
        }
        if($page <= 0){
          $page = 1;
        } else{
          $page = $page;
        }
        if(empty($orderby)){
        $order ="id DESC";
        } else {
        $order = $orderby;
        }
        $url = basename($_SERVER['PHP_SELF']);
        $previous = $page-1;
        $next =$page+1;
        $currentPage = $page;
        if(count($column)==0){
        $columnis = "*";
        } else {
          $columnis = implode(",",$column);
        }   
        $sql = "SELECT COUNT(id) as totalrecords FROM `$table`";
        $query = $this->CONNECT->prepare($sql);// $query->bindValue(':uid',1,PDO::PARAM_STR);
        $query->execute();
        $checktotal = $query->fetch(PDO::FETCH_ASSOC);//$checktotal = $query->rowCount();
        $total_records = $checktotal['totalrecords'];
        $total_page = ceil($total_records/$limit);
        $start = ($page - 1)*$limit;
        $limit_ = "LIMIT $start,$limit";

        $sql_query = "SELECT $columnis FROM `$table` ORDER BY $order $limit_";
        $query = $this->CONNECT->prepare($sql_query);
        $query->execute();
        $alldata = $query->fetchAll(PDO::FETCH_ASSOC);

        $lastPage = $total_page;
        $fiestPage = 1;
        if($next <= $total_page){
            $next_ = $next;
        } else {
            $next_ = 0;
        }

    if($total_records > $limit){
        $output_n = "<nav aria-label='Page navigation example'>";
        $output_n .= "<ul class='pagination nav justify-content-center'>";
        if($previous <= 0){
            $output_n .="<li class='page-item disabled'><a class='page-link' href='javascript:void(0)'>Previous</a></li>";
        } else {
            $output_n .="<li class='page-item'><a href='$url?page=$previous' class='page-link' rel='prev'>Previous</a></li>";
        }
        if ($currentPage > 3) {
                $output_n .="<li class='page-item'><a class='page-link' href='$url?page=1'>1</a></li>";
            }
            if ($currentPage > 4) {
                $output_n .="<li class='page-item'><a class='page-link' href='javascript:void(0)'>...</a></li>";
            }
        foreach (range(1, $lastPage) as $i){
            if ($i >= $currentPage - 2 && $i <= $currentPage + 2) {
                if ($i == $currentPage) {
                $output_n .="<li class='page-item active'><a class='page-link'>$i</a></li>";
            } else {
                $output_n .="<li class='page-item'><a class='page-link' href='$url?page=$i'>$i</a></li>";
            }
            }
        }
        if ($currentPage < $lastPage - 3) {
            $output_n .="<li class='page-item'><a class='page-link' href='javascript:void(0)'>...</a></li>";
            }

        if ($currentPage < $lastPage - 2) {
        $output_n .="<li class='page-item'><a class='page-link' href='$url?page=$lastPage'>$lastPage</a></li>";
        }

        if($next <= $total_page){
            $output_n .="<li class='page-item'><a class='page-link' href='$url?page=$next' rel='next'>Next</a></li>";
        } else {
            $output_n .="<li class='page-item disabled'><a class='page-link' href='javascript:void(0)'>Next</a></li>";
        }
        
        $output_n .="</ul>";

        $output_n .="</nav>";  



    } else {
    
    $output_n ="";
    
    }

    return array(
        "status"=>1,
        "message"=>"records found.",
        "data" => $alldata,
        "html_view" => $output_n,
        "active_page" => $page,
        "total_records" => $total_records,
        "total_page" => $total_page,
        "previous" => $previous,
        "next" => $next_,
        "first_page"=>$fiestPage,
        "last_page"=>$lastPage
    );
  
    } catch(Exception $error) {
        return array("status"=>0,"message"=>$error->getMessage());
    }

  }



private function tableExists(string $table){
  try {
        $db_name=$this->dbconfig->DB_NAME;
        $sql = "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = :db AND table_name = :table";
        $query = $this->CONNECT->prepare($sql);
        $query->execute([
            ':db'    => $this->dbconfig->DB_NAME,
            ':table' => $table
        ]);
        return $query->fetchColumn() <= 0 ? false : true;
  } catch(\Exception $error) {
    throw new \Exception($error->getMessage());
  }
}






public function __destruct(){
  $this->MYDISCONNECT();
} 

}
?>