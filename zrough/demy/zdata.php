<?php
include_once('../../includes/connection.php');


$sql = mysqli_query($db,"SELECT count(id) AS total FROM rough");
if(mysqli_num_rows($sql)>0){
    $result = mysqli_fetch_object($sql);
    $total = $result->total;

    $pagination_object = (object)$_REQUEST['pagination'];
    $perpage = $pagination_object->perpage;
    $pages = floor(round($total)/round($perpage));
    $remain = round(round($total)%round($perpage));
    if($remain>0){$pages = round(round($pages)+1);}

    $sort_object = (object)$_REQUEST['sort'];

    $meta=[
        "page" => $pagination_object->page,
        "pages"=> $pages,
        "perpage"=> $pagination_object->perpage,
        "total" => $total,
        "sort"=> $sort_object->sort,
        "field"=> 'first_name',
    ];

    $offset=round(round($pagination_object->page)*round($pagination_object->perpage)) - round($pagination_object->perpage);
    $limit=round($pagination_object->perpage);
    $sort =" ORDER BY `first_name` ASC ";
    $number_of_record = " LIMIT ".$offset.", ".$limit;
    $condition='';
    if(isset($_REQUEST['query']) && !empty($_REQUEST['query'])){
        $conditions_object = $_POST['query'];
        foreach($conditions_object AS $key => $value){
            if($key ==  'search'){
                $condition = " WHERE employee_code LIKE '%{$value}%' OR first_name LIKE '%{$value}%' OR last_name LIKE '%{$value}%' OR pseudo_name LIKE '%{$value}%' OR email LIKE '%{$value}%' OR official_email LIKE '%{$value}%' ";
            }
        }
    }
    $select = "SELECT * FROM rough ".$condition.$sort.$number_of_record;

    $query = mysqli_query($db, $select);
    if(mysqli_num_rows($query)>0){
        $data=array();
        while ($object = mysqli_fetch_object($query)){
            $data[] = $object;
        }
        echo json_encode(['meta' => $meta, 'data' => $data]);
    }

}

/*
Array
(
    [pagination] => Array(
            [page] => 1
            [pages] => 18
            [perpage] => 20
            [total] => 350
        )
    [sort] => Array(
            [field] => id
            [sort] => asc
        )
    [query] => Array(
            [generalSearch] => name
            [Status] => 1
            [Type] => 1
        )

)
*/
?>