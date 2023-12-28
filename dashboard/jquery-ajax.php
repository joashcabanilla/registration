<?php
include 'config/db-config.php';
global $connection;

if($_REQUEST['action'] == 'fetch_users'){

    $requestData = $_REQUEST;
    $start = $_REQUEST['start'];

    $initial_date = $_REQUEST['initial_date'];
    $final_date = $_REQUEST['final_date'];
    $branch = $_REQUEST['branch'];

    if(!empty($initial_date) && !empty($final_date)){
        $date_range = " AND date_posted BETWEEN '".$initial_date."' AND '".$final_date."' ";
    }else{
        $date_range = "";
    }

    if($branch != ''){
        $branch = " AND branch = '$branch' ";
    }

    $columns = ' id, lname, fname, mname, branch, status, date_posted ';
    $table = ' applicants ';
    $where = " WHERE lname!='' ".$date_range.$branch;

    $columns_order = array(
        0 => 'id',
        1 => 'lname',
        2 => 'fname',
        3 => 'mname',
        4 => 'branch',
        5 => 'status',
        6 => 'date_posted'
    );

    $sql = "SELECT ".$columns." FROM ".$table." ".$where;

    $result = mysqli_query($connection, $sql);
    $totalData = mysqli_num_rows($result);
    $totalFiltered = $totalData;

    if( !empty($requestData['search']['value']) ) {
        $sql.=" OR lname LIKE '%".$requestData['search']['value']."%'";
        $sql.=" AND ( fname LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR mname LIKE '%".$requestData['search']['value']."%'";
        $sql.=" OR branch LIKE '".$requestData['search']['value']."'";
        $sql.=" OR status LIKE '%".$requestData['search']['value']."%'";
        $sql.=" OR date_posted LIKE '%".$requestData['search']['value']."%' )";
    }

    $result = mysqli_query($connection, $sql);
    $totalData = mysqli_num_rows($result);
    $totalFiltered = $totalData;

    $sql .= " ORDER BY ". $columns_order[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];

    if($requestData['length'] != "-1"){
        $sql .= " LIMIT ".$requestData['start']." ,".$requestData['length'];
    }

    $result = mysqli_query($connection, $sql);
    $data = array();
    $counter = $start;

    $count = $start;
    while($row = mysqli_fetch_array($result)){
        $count++;
        $nestedData = array();

        $nestedData['counter'] = $count;

        $nestedData['lname'] = $row["lname"];
        $nestedData['fname'] = $row["fname"];
        $nestedData['mname'] = $row["mname"];

        $nestedData['status'] = $row["status"];
        $nestedData['branch'] = $row["branch"];
        $nestedData['date_posted'] = $row["date_posted"];
        // $time = strtotime($row["date"]);
        // $nestedData['date'] = date('M d, Y');
        // $nestedData['date'] = date('h:i:s A - d M, Y', $time);

        $data[] = $nestedData;
    }

    $json_data = array(
        "draw"            => intval( $requestData['draw'] ),
        "recordsTotal"    => intval( $totalData),
        "recordsFiltered" => intval( $totalFiltered ),
        "records"         => $data
    );

    echo json_encode($json_data);
}

?>
