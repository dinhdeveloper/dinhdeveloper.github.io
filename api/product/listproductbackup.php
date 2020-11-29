<?php
$category_id = '';
$customer_id = '';
$product_id = '';

//category_id != null
if (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) {
    $category_id = $_REQUEST['category_id'];
    if (isset($_REQUEST['customer_id']) && !empty($_REQUEST['customer_id'])) {
        $customer_id = $_REQUEST['customer_id'];
        $product_arr = array();
        $sql = "SELECT count(tbl_product.id) as product_total
                    FROM tbl_product WHERE 1=1 ";
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

        $sql = "SELECT  	tbl_category.id as category_id,
                            tbl_category.category_name as category_name,
                            tbl_product.id AS product_id,
                            tbl_product.product_name AS product_name,
                            tbl_product.product_image as product_image,
                            tbl_product.price_sale as price_sale,
                            tbl_product.quantity as quantity,
                            tbl_product.description as description,
                            tbl_product.discount as discount,
                            tbl_product.location as location,
                            tbl_product.status as status
							FROM tbl_product
							INNER  JOIN tbl_category
							ON tbl_product.category_id = tbl_category.id
							WHERE tbl_product.category_id = 
							(SELECT tbl_product.category_id AS category_id FROM tbl_product
                            WHERE tbl_product.category_id = '$category_id'
                            AND tbl_product.customer_id = '$customer_id' LIMIT 0,1)";

        $result = $conn->query($sql);
        // Get row count
        $num = mysqli_num_rows($result);

        $product_arr['success'] = 'true';
        $product_arr['data'] = array();
        if ($num > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_item = array(
                    'product_id' => $row['product_id'],
                    'category_id' => $row['category_id'],
                    'category_name' => $row['category_name'],
                    'product_name' => $row['product_name'],
                    'product_image' => $row['product_image'],
                    'price_sale' => $row['price_sale'],
                    'quantity' => $row['quantity'],
                    'description' => $row['description'],
                    'discount' => $row['discount'],
                    'location' => $row['location'],
                    'status' => $row['status'],
                    'customer' => array(),
                );
                //kiem tra customer
                $sql_check_customer = "SELECT tbl_customer.* FROM tbl_customer
                                LEFT JOIN tbl_product ON tbl_product.customer_id = tbl_customer.id
                                WHERE tbl_product.id ='" . $row['product_id'] . "'";
                $result_check_customer = $conn->query($sql_check_customer);
                $num_check_customer = mysqli_num_rows($result_check_customer);
                if ($num_check_customer > 0) {
                    while ($row_check_customer = $result_check_customer->fetch_assoc()) {
                        $customer = array(
                            'customer_id' => $row_check_customer['id'],
                            'full_name' => $row_check_customer['full_name'],
                            'phone_number' => $row_check_customer['phone_number'],
                            'address' => $row_check_customer['address'],
                            'gender' => $row_check_customer['gender'],
                        );
                        array_push($product_item['customer'], $customer);
                    }
                }
                // Push to "data"
                array_push($product_arr['data'], $product_item);
            }
            // Turn to JSON & output
            echo json_encode($product_arr);
        } else {
            // No Categories
            echo json_encode(array(
                'success' => 'false',
                'message' => 'Không tìm thấy sản phẩm!'
            ));
        }
    }
    //category_id != null && customer_id == null
    else {
        $category_id = $_REQUEST['category_id'];
        if (!empty($category_id)) {
            $product_arr = array();
            $sql = "SELECT count(tbl_product.id) as product_total
                    FROM tbl_product WHERE 1=1 ";
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

            $sql = "SELECT  tbl_category.id as category_id,
                            tbl_category.category_name as category_name,
                            tbl_product.id AS product_id,
                            tbl_product.product_name AS product_name,
                            tbl_product.product_image as product_image,
                            tbl_product.price_sale as price_sale,
                            tbl_product.quantity as quantity,
                            tbl_product.description as description,
                            tbl_product.discount as discount,
                            tbl_product.location as location,
                            tbl_product.status as status
                            FROM tbl_product
                            LEFT JOIN tbl_category
                            ON  tbl_category.id = tbl_product.category_id
                            WHERE tbl_category.id ='$category_id'";

            $result = $conn->query($sql);
            // Get row count
            $num = mysqli_num_rows($result);

            $product_arr['success'] = 'true';
            $product_arr['data'] = array();
            if ($num > 0) {
                while ($row = $result->fetch_assoc()) {
                    $product_item = array(
                        'product_id' => $row['product_id'],
                        'category_id' => $row['category_id'],
                        'category_name' => $row['category_name'],
                        'product_name' => $row['product_name'],
                        'product_image' => $row['product_image'],
                        'price_sale' => $row['price_sale'],
                        'quantity' => $row['quantity'],
                        'description' => $row['description'],
                        'discount' => $row['discount'],
                        'location' => $row['location'],
                        'status' => $row['status'],
                        'customer' => array(),
                    );
                    //kiem tra customer
                    $sql_check_customer = "SELECT tbl_customer.* FROM tbl_customer
                                LEFT JOIN tbl_product ON tbl_product.customer_id = tbl_customer.id
                                WHERE tbl_product.id ='" . $row['product_id'] . "'";
                    $result_check_customer = $conn->query($sql_check_customer);
                    $num_check_customer = mysqli_num_rows($result_check_customer);
                    if ($num_check_customer > 0) {
                        while ($row_check_customer = $result_check_customer->fetch_assoc()) {
                            $customer = array(
                                'customer_id' => $row_check_customer['id'],
                                'full_name' => $row_check_customer['full_name'],
                                'phone_number' => $row_check_customer['phone_number'],
                                'address' => $row_check_customer['address'],
                                'gender' => $row_check_customer['gender'],
                            );
                            array_push($product_item['customer'], $customer);
                        }
                    }
                    // Push to "data"
                    array_push($product_arr['data'], $product_item);
                }
                // Turn to JSON & output
                echo json_encode($product_arr);
            } else {
                // No Categories
                echo json_encode(array(
                    'success' => 'false',
                    'message' => 'Không tìm thấy sản phẩm!'
                ));
            }
        }
        exit();
    }
}
//category_id == null
else {
    //category_id == null && customer_id != null
    if (isset($_REQUEST['customer_id']) && !empty($_REQUEST['customer_id'])) {
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
                    'message' => 'Không tìm thấy sản phẩm!'
                ));
            }
        }
        exit();
    }
    //category_id == null && customer_id == null
    else {
        if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])){
            $product_id = $_REQUEST['product_id'];
            if (!empty($product_id)) {

                $image_arr = array();

                $sql = "SELECT count(tbl_image_product.id) as image_total
                    FROM tbl_image_product WHERE 1=1 ";
                $result = mysqli_query($conn, $sql);

                while ($row = $result->fetch_assoc()) {
                    $image_arr['total'] = $row['image_total'];
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

                $image_arr['total_page'] = strval(ceil($image_arr['total'] / $limit));

                $image_arr['limit'] = strval($limit);
                $image_arr['page'] = strval($page);

                $start = ($page - 1) * $limit;

                $sql = "SELECT 
                            tbl_product.id AS product_id,
                            tbl_product.product_name AS product_name,
                            tbl_product.product_image as product_image,
                            tbl_product.price_sale as price_sale,
                            tbl_product.quantity as quantity,
                            tbl_product.description as description,
                            tbl_product.discount as discount,
                            tbl_product.location as location,
                            tbl_product.status as status
                            FROM tbl_product
                            LEFT JOIN tbl_image_product
                            ON  tbl_product.id = tbl_image_product.product_id
                            WHERE tbl_product.id = '$product_id' LIMIT 0,1";

                $result = $conn->query($sql);
                // Get row count
                $num = mysqli_num_rows($result);

                $image_arr['success'] = 'true';
                $image_arr['data'] = array();
                if ($num > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $photo_item = array(
                            'product_id' => $row['product_id'],
//                            'category_id' => $row['category_id'],
//                            'category_name' => $row['category_name'],
                            'product_name' => $row['product_name'],
                            'product_image' => $row['product_image'],
                            'price_sale' => $row['price_sale'],
                            'quantity' => $row['quantity'],
                            'description' => $row['description'],
                            'discount' => $row['discount'],
                            'location' => $row['location'],
                            'status' => $row['status'],
                            'product_photo' => array(),
                        );
                        //kiem tra image
                        $sql_get_product = "SELECT  tbl_image_product.id as image_id,
                            tbl_image_product.product_id as product_id,
                            tbl_image_product.product_photo as product_photo
                            FROM tbl_image_product
                                LEFT JOIN tbl_product
                                ON tbl_product.id = tbl_image_product.product_id
                                WHERE tbl_product.id = '" . $row['product_id'] . "'";
                        $result_get_product = $conn->query($sql_get_product);
                        $num_get_product = mysqli_num_rows($result_get_product);
                        if ($num_get_product > 0) {
                            while ($row_get_product = $result_get_product->fetch_assoc()) {
                                $product_photo = array(
                                    'image_id' => $row_get_product['image_id'],
                                    'product_id' => $row_get_product['product_id'],
                                    'product_photo' => $row_get_product['product_photo'],
                                );
                                array_push($photo_item['product_photo'], $product_photo);
                            }
                        }
                        // Push to "data"
                        array_push($image_arr['data'], $photo_item);
                    }
                    // Turn to JSON & output
                    echo json_encode($image_arr);
                } else {
                    // No Categories
                    echo json_encode(array(
                        'success' => 'false',
                        'message' => 'Không tìm thấy sản phẩm!'
                    ));
                }
            }
            exit();
        }else{
            returnError("Chọn phương thức tìm kiếm");
        }
    }
}

?>