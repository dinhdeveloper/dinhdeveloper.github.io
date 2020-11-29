<?php

$filter = '';
$date_option = '';
$date_start = '';
$date_end = '';

if (isset($_REQUEST['date_begin']) && !empty($_REQUEST['date_begin'])) {
    $date_start = $_REQUEST['date_begin'];
}
if (isset($_REQUEST['date_end']) && !empty($_REQUEST['date_end'])) {
    $date_end = $_REQUEST['date_end'];
}
$store_id = '';
if (isset($_REQUEST['store_id']) && !empty($_REQUEST['store_id'])) {
    $store_id = $_REQUEST['store_id'];
    $product_arr = array();
    $sql = "SELECT count(product_import.id) as product_total
                    FROM product_import WHERE product_import.store_id = '$store_id' ";
    $result = mysqli_query($conn, $sql);

    while ($row = $result->fetch_assoc()) {
        $product_arr['total'] = $row['product_total'];
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

    $product_arr['total_page'] = strval(ceil($product_arr['total'] / $limit));

    $product_arr['limit'] = strval($limit);
    $product_arr['page'] = strval($page);

    $start = ($page - 1) * $limit;
    $sql = '';

    if (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) {
        $filter = $_REQUEST['filter'];
        $sql = "SELECT  	        product_import.id AS import_id,
                            product_import.product_name AS product_name,
                            product_import.product_price AS product_price,
                            product_import.product_quantity_import as quantity_import,
                            product_import.product_safestock as safe_stock,
                            product_import.product_name_employee as employee_name,
                            product_import.product_phone_employee as employee_phone,
                            product_import.product_date_create as date_create,
                            product_import.product_status as status
							FROM product_import
							INNER JOIN store_business
							ON product_import.store_id = store_business.store_id
							WHERE product_import.store_id = '$store_id'
							AND product_import.product_name LIKE '%$filter'
							ORDER BY product_import.product_date_create DESC";
    }
    if (! empty($date_start) && ! empty($date_end)) {
        $sql = "SELECT  	        product_import.id AS import_id,
                            product_import.product_name AS product_name,
                            product_import.product_price AS product_price,
                            product_import.product_quantity_import as quantity_import,
                            product_import.product_safestock as safe_stock,
                            product_import.product_name_employee as employee_name,
                            product_import.product_phone_employee as employee_phone,
                            product_import.product_date_create as date_create,
                            product_import.product_status as status
							FROM product_import
							INNER JOIN store_business
							ON product_import.store_id = store_business.store_id
							WHERE product_import.store_id = '$store_id'
							AND DATE(product_import.product_date_create) >='$date_start'
							AND DATE(product_import.product_date_create) <='$date_end'
							ORDER BY product_import.product_date_create DESC";
    }

    else {
        $sql = "SELECT  	        product_import.id AS import_id,
                            product_import.product_name AS product_name,
                            product_import.product_price AS product_price,
                            product_import.product_quantity_import as quantity_import,
                            product_import.product_safestock as safe_stock,
                            product_import.product_name_employee as employee_name,
                            product_import.product_phone_employee as employee_phone,
                            product_import.product_date_create as date_create,
                            product_import.product_status as status
							FROM product_import
							INNER JOIN store_business
							ON product_import.store_id = store_business.store_id
							WHERE product_import.store_id = '$store_id'
							ORDER BY product_import.product_date_create DESC";
    }


    $result = $conn->query($sql);
// Get row count
    $num = mysqli_num_rows($result);

    $product_arr['success'] = 'true';
    $product_arr['data'] = array();

    if ($num > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_item = array(
                'import_id' => $row['import_id'],
                'product_name' => $row['product_name'],
                'product_price' => $row['product_price'],
                'quantity_import' => $row['quantity_import'],
                'safe_stock' => $row['safe_stock'],
                'employee_name' => $row['employee_name'],
                'employee_phone' => $row['employee_phone'],
                'date_create' => $row['date_create'],
                'status' => $row['status']
            );
            // Push to "data"
            array_push($product_arr['data'], $product_item);
        }
        echo json_encode($product_arr);
    }else{
       returnError("Không tìm thấy sản phẩm");
    }
} else {
    returnError("Chọn cửa hàng");
}
?>
