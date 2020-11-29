<?php

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

$sql = "SELECT  	         tbl_category.id as category_id,
                            tbl_category.category_name as category_name,
                            tinhthanhpho.name as city_name,
                            quanhuyen.name as district_name,
                            xaphuongthitran.name as ward_name,
                            tbl_product.id AS product_id,
                            tbl_product.product_name AS product_name,
                            tbl_product.phone_contact AS phone_contact,
                            tbl_product.product_image as product_image,
                            tbl_product.price_sale as price_sale,
                            tbl_product.quantity as quantity,
                            tbl_product.date_create as date_create,
                            tbl_product.description as description,
                            tbl_product.discount as discount,
                            tbl_product.location as location,
                            tbl_product.status as status
							FROM ((((tbl_product
							LEFT JOIN tbl_category ON tbl_product.category_id = tbl_category.id)
                            LEFT JOIN tinhthanhpho ON  tbl_product.city_id = tinhthanhpho.matp )
                           	LEFT JOIN quanhuyen ON  tbl_product.district_id = quanhuyen.maqh )
                            LEFT JOIN xaphuongthitran ON  tbl_product.ward_id = xaphuongthitran.xaid )
							ORDER BY tbl_product.date_create DESC";

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
            'phone_contact' => $row['phone_contact'],
            'product_image' => $row['product_image'],
            'price_sale' => $row['price_sale'],
            'quantity' => $row['quantity'],
            'date_create' => $row['date_create'],
            'description' => $row['description'],
            'discount' => $row['discount'],
            'city_name' =>$row['city_name'],
            'district_name' =>$row['district_name'],
            'ward_name' =>$row['ward_name'],
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
                array_push($product_item['product_photo'], $product_photo);
            }
        }
        // Push to "data"
        array_push($product_arr['data'], $product_item);
    }
    echo json_encode($product_arr);
} else {
    echo json_encode(array(
        'success' => 'false',
        'message' => 'Không tìm thấy sản phẩm!'
    ));
}

?>