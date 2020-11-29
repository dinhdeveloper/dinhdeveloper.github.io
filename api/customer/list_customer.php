<?php

$customer_id ='';
if (isset($_REQUEST['customer_id']) && !empty($_REQUEST['customer_id'])){
    $customer_id = $_REQUEST['customer_id'];
    $sql = "SELECT * FROM tbl_customer WHERE id = '$customer_id'";

    $result = $conn->query($sql);
//Get row count
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $customer_arr = array();
        $sql_count = "SELECT count(tbl_customer.id) as customer_total
                    FROM tbl_customer WHERE 1=1";
        $result_count = mysqli_query($conn, $sql_count);

        while ($row = $result_count->fetch_assoc()) {
            $customer_arr['total'] = $row['customer_total'];
        }

        $limit = 20;

        if (!empty($price_range)) {
            $limit = 100;
        }
        $page = 1;
        if (isset($_REQUEST['limit']) && $_REQUEST['limit'] != '') {
            $limit = $_REQUEST['limit'];
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] != '') {
            $page = $_REQUEST['page'];
        }

        $customer_arr['total_page'] = strval(ceil($customer_arr['total'] / $limit));

        $customer_arr['limit'] = strval($limit);
        $customer_arr['page'] = strval($page);

        $start = ($page - 1) * $limit;

        $customer_arr['success'] = 'true';
        $customer_arr['data'] = array();
        while ($row = $result->fetch_assoc()) {
            $customer_item = array(
                'customer_id' => $row['id'],
                'full_name' => $row['full_name'],
                'phone_number' => $row['phone_number'],
                'address' => $row['address'],
                'image' => $row['image'],
                'gender' => $row['gender'],
                'status' => $row['status'],
            );
            // Push to "data"
            array_push($customer_arr['data'], $customer_item);
        }
        //Turn to JSON & output
        echo json_encode($customer_arr);
    } else {
        echo json_encode(array(
            'success' => 'false',
            'message' => 'Không tìm thấy khách hàng!'
        ));
    }
}
else{
    $sql = "SELECT * FROM tbl_customer";

    $result = $conn->query($sql);
//Get row count
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $customer_arr = array();
        $sql_count = "SELECT count(tbl_customer.id) as customer_total
                    FROM tbl_customer WHERE 1=1";
        $result_count = mysqli_query($conn, $sql_count);

        while ($row = $result_count->fetch_assoc()) {
            $customer_arr['total'] = $row['customer_total'];
        }

        $limit = 20;

        if (!empty($price_range)) {
            $limit = 100;
        }
        $page = 1;
        if (isset($_REQUEST['limit']) && $_REQUEST['limit'] != '') {
            $limit = $_REQUEST['limit'];
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] != '') {
            $page = $_REQUEST['page'];
        }

        $customer_arr['total_page'] = strval(ceil($customer_arr['total'] / $limit));

        $customer_arr['limit'] = strval($limit);
        $customer_arr['page'] = strval($page);

        $start = ($page - 1) * $limit;

        $customer_arr['success'] = 'true';
        $customer_arr['data'] = array();
        while ($row = $result->fetch_assoc()) {
            $customer_item = array(
                'customer_id' => $row['id'],
                'full_name' => $row['full_name'],
                'phone_number' => $row['phone_number'],
                'address' => $row['address'],
                'gender' => $row['gender'],
                'image' => $row['image'],
                'status' => $row['status'],
            );
            // Push to "data"
            array_push($customer_arr['data'], $customer_item);
        }
        //Turn to JSON & output
        echo json_encode($customer_arr);
    } else {
        echo json_encode(array(
            'success' => 'false',
            'message' => 'Không tìm thấy khách hàng!'
        ));
    }
}

?>