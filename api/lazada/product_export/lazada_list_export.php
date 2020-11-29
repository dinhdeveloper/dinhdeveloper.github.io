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
    $sql = "SELECT count(product_export.id) as product_total
                    FROM product_export WHERE product_export.store_id = '$store_id' ";
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
        $sql = "SELECT  	    product_export.id AS export_id,
                            product_export.product_import_id AS product_import_id,
                            product_export.product_name AS product_name,
                            product_export.product_quantity AS quantity_export,
                            product_export.product_name_customer AS customer_name,
                            product_export.product_phone_customer as customer_phone,
                            product_export.product_address_customer as customer_address,
                            product_export.product_date_create as date_create,
                            product_export.product_type as type_order,
                            product_export.product_status as status
							FROM product_export
							INNER JOIN store_business
							ON product_export.store_id = store_business.store_id
							WHERE product_export.store_id = '$store_id'
							AND product_export.product_name LIKE '%$filter'
							ORDER BY product_export.product_date_create DESC";
    }
    if (!empty($date_start) && !empty($date_end)) {
        $sql = "SELECT  	    product_export.id AS export_id,
                            product_export.product_import_id AS product_import_id,
                            product_export.product_name AS product_name,
                            product_export.product_quantity AS quantity_export,
                            product_export.product_name_customer AS customer_name,
                            product_export.product_phone_customer as customer_phone,
                            product_export.product_address_customer as customer_address,
                            product_export.product_date_create as date_create,
                            product_export.product_type as type_order,
                            product_export.product_status as status
							FROM product_export
							INNER JOIN store_business
							ON product_export.store_id = store_business.store_id
							WHERE product_export.store_id = '$store_id'
							AND DATE(product_export.product_date_create) >='$date_start'
							AND DATE(product_export.product_date_create) <='$date_end'
							ORDER BY product_export.product_date_create DESC";
    } else {
        $sql = "SELECT  	    product_export.id AS export_id,
                            product_export.product_import_id AS product_import_id,
                            product_export.product_name AS product_name,
                            product_export.product_quantity AS quantity_export,
                            product_export.product_name_customer AS customer_name,
                            product_export.product_phone_customer as customer_phone,
                            product_export.product_address_customer as customer_address,
                            product_export.product_date_create as date_create,
                            product_export.product_type as type_order,
                            product_export.product_status as status
							FROM product_export
							INNER JOIN store_business
							ON product_export.store_id = store_business.store_id
							WHERE product_export.store_id = '$store_id'
							ORDER BY product_export.product_date_create DESC";
    }


    $result = $conn->query($sql);
// Get row count
    $num = mysqli_num_rows($result);

    $product_arr['success'] = 'true';
    $product_arr['data'] = array();

    if ($num > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_item = array(
                'export_id' => $row['export_id'],
                'product_import_id' => $row['product_import_id'],
                'product_name' => $row['product_name'],
                'quantity_export' => $row['quantity_export'],
                'customer_name' => $row['customer_name'],
                'customer_phone' => $row['customer_phone'],
                'customer_address' => $row['customer_address'],
                'date_create' => $row['date_create'],
                'type_order' => $row['type_order'],
                'status' => $row['status']
            );
            // Push to "data"
            array_push($product_arr['data'], $product_item);
        }
        echo json_encode($product_arr);
    } else {
        returnError("Không tìm thấy sản phẩm");
    }
} else {
    returnError("Chọn cửa hàng");
}
?>
