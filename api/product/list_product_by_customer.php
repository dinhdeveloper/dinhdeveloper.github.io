<?php

$customer_id = '';
if (isset($_REQUEST['customer_id']) && !empty($_REQUEST['customer_id'])){
    $customer_id = $_REQUEST['customer_id'];
    if (!empty($customer_id)) {

        $customer_arr = array();

        $sql = "SELECT count(tbl_customer.id) as customer_total
                    FROM tbl_customer WHERE 1=1 ";
        $result = mysqli_query($conn, $sql);

        while ($row = $result->fetch_assoc()) {
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

        $sql = "SELECT  tbl_customer.id as customer_id,
                            tbl_customer.full_name as full_name,
                            tbl_customer.phone_number as phone_number,
                            tbl_customer.address as address,
                            tbl_customer.gender as status
                            FROM tbl_customer
                            WHERE tbl_customer.id ='$customer_id'";

        $result = $conn->query($sql);
        // Get row count
        $num = mysqli_num_rows($result);

        $customer_arr['success'] = 'true';
        $customer_arr['data'] = array();
        if ($num > 0) {
            while ($row = $result->fetch_assoc()) {
                $customer_item = array(
                    'customer_id' => $row['customer_id'],
                    'full_name' => $row['full_name'],
                    'phone_number' => $row['phone_number'],
                    'address' => $row['address'],
                    'status' => $row['status'],
                    'product' => array(),
                );
                //kiem tra customer
                $sql_get_product = "SELECT  tbl_product.id AS product_id,
                                                tbl_product.product_name AS product_name,
                                                tbl_product.product_image as product_image,
                                                tbl_product.price_sale as price_sale,
                                                tbl_product.quantity as quantity,
                                                tbl_product.description as description,
                                                tbl_product.discount as discount,
                                                tbl_product.location as location,
                                                tbl_product.status as status
                                                FROM tbl_customer
                                                LEFT JOIN tbl_product
                                                ON tbl_customer.id = tbl_product.customer_id
                                                WHERE tbl_customer.id ='" . $row['customer_id'] . "'";
                $result_get_product = $conn->query($sql_get_product);
                $num_get_product = mysqli_num_rows($result_get_product);
                if ($num_get_product > 0) {
                    while ($row_get_product = $result_get_product->fetch_assoc()) {
                        $product = array(
                            'product_id' => $row_get_product['product_id'],
                            'product_name' => $row_get_product['product_name'],
                            'product_image' => $row_get_product['product_image'],
                            'price_sale' => $row_get_product['price_sale'],
                            'quantity' => $row_get_product['quantity'],
                            'description' => $row_get_product['description'],
                            'location' => $row_get_product['location'],
                            'status' => $row_get_product['status'],
                        );
                        array_push($customer_item['product'], $product);
                    }
                }
                // Push to "data"
                array_push($customer_arr['data'], $customer_item);
            }
            // Turn to JSON & output
            echo json_encode($customer_arr);
        } else {
            // No Categories
            echo json_encode(array(
                'success' => 'false',
                'message' => 'Không tìm thấy khách hàng!'
            ));
        }
    }
    exit();
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
                'status' => $row['status'],
                'product' => array(),
            );
            //kiem tra customer
            $sql_get_product = "SELECT  tbl_product.id AS product_id,
                                                tbl_product.product_name AS product_name,
                                                tbl_product.product_image as product_image,
                                                tbl_product.price_sale as price_sale,
                                                tbl_product.quantity as quantity,
                                                tbl_product.description as description,
                                                tbl_product.discount as discount,
                                                tbl_product.location as location,
                                                tbl_product.status as status
                                                FROM tbl_customer
                                                LEFT JOIN tbl_product
                                                ON tbl_customer.id = tbl_product.customer_id
                                                WHERE tbl_customer.id ='" . $row['id'] . "'";
            $result_get_product = $conn->query($sql_get_product);
            $num_get_product = mysqli_num_rows($result_get_product);
            if ($num_get_product > 0) {
                while ($row_get_product = $result_get_product->fetch_assoc()) {
                    $product = array(
                        'product_id' => $row_get_product['product_id'],
                        'product_name' => $row_get_product['product_name'],
                        'product_image' => $row_get_product['product_image'],
                        'price_sale' => $row_get_product['price_sale'],
                        'quantity' => $row_get_product['quantity'],
                        'description' => $row_get_product['description'],
                        'location' => $row_get_product['location'],
                        'status' => $row_get_product['status'],
                    );
                    array_push($customer_item['product'], $product);
                }
            }
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
};
?>
