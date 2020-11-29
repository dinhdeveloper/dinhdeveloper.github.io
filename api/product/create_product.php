<?php

$category_id = '';
$city_id = '';
$district_id = '';
$ward_id = '';
$customer_id = '';
$product_name = '';
$product_image = '';
$price_sale = '';
$quantity = '';
$phone_contact = '';
$description = '';
$discount = '';
$location = '';
$status = '';
$product_arr = '';

if (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) {
    $category_id = $_REQUEST['category_id'];
} else {
    returnError("Nhập category_id");
}
if (isset($_REQUEST['city_id']) && !empty($_REQUEST['city_id'])) {
    $city_id = $_REQUEST['city_id'];
} else {
    returnError("Nhập city_id");
}
if (isset($_REQUEST['district_id']) && !empty($_REQUEST['district_id'])) {
    $district_id = $_REQUEST['district_id'];
} else {
    returnError("Nhập district_id");
}
if (isset($_REQUEST['ward_id']) && !empty($_REQUEST['ward_id'])) {
    $ward_id = $_REQUEST['ward_id'];
} else {
    returnError("Nhập ward_id");
}

if (isset($_REQUEST['customer_id']) && !empty($_REQUEST['customer_id'])) {
    $customer_id = $_REQUEST['customer_id'];
} else {
    returnError("Nhập customer_id");
}

if (isset($_REQUEST['phone_contact']) && !empty($_REQUEST['phone_contact'])) {
    $phone_contact = $_REQUEST['phone_contact'];
} else {
    returnError("Nhập phone_contact");
}
/*if (isset($_REQUEST['image_id'])) {
    if ($_REQUEST['image_id'] == '') {
        unset($_REQUEST['image_id']);
    } else {
        $image_id = $_REQUEST['image_id'];
    }
}*/

if (isset($_REQUEST['product_name']) && !empty($_REQUEST['product_name'])) {
    $product_name = $_REQUEST['product_name'];
} else {
    returnError("Nhập product_name");
}

if (isset($_FILES['product_image'])) {
    $product_image = saveImage($_FILES['product_image'], 'images/product/');

    if ($product_image == "error_size_img") {
        returnError("product_image > 5MB !");
    }

    if ($product_image == "error_type_img") {
        returnError("product_image error type");
    }
}
if (isset($_REQUEST['price_sale']) && !empty($_REQUEST['price_sale'])) {
    $price_sale = $_REQUEST['price_sale'];
} else {
    returnError("Nhập price_sale");
}

if (isset($_REQUEST['quantity']) && !empty($_REQUEST['quantity'])) {
    $quantity = $_REQUEST['quantity'];
} else {
    returnError("Nhập quantity");
}

if (isset($_REQUEST['description'])) {
    if ($_REQUEST['description'] == '') {
        unset($_REQUEST['description']);
    } else {
        $description = $_REQUEST['description'];
    }
}

if (isset($_REQUEST['discount'])) {
    if ($_REQUEST['discount'] == '') {
        unset($_REQUEST['discount']);
    } else {
        $discount = $_REQUEST['discount'];
    }
}

if (isset($_REQUEST['location'])) {
    if ($_REQUEST['location'] == '') {
        unset($_REQUEST['location']);
    } else {
        $location = $_REQUEST['location'];
    }
}

if (isset($_REQUEST['status'])) {
    if ($_REQUEST['status'] == '') {
        unset($_REQUEST['status']);
    } else {
        $status = $_REQUEST['status'];
    }
}

//kiem tra category ton tai hay khong
$sql_check_category_exist = "SELECT * FROM tbl_category WHERE tbl_category.id = '$category_id'";
$result_check_category_exist = $conn->query($sql_check_category_exist);
$row_check_category_exist = mysqli_num_rows($result_check_category_exist);

if ($row_check_category_exist > 0) {
    //kiem tra customer ton tai hay khong
    $sql_check_customer_exist = "SELECT * FROM tbl_customer WHERE tbl_customer.id = '$customer_id'";
    $result_check_customer_exist = $conn->query($sql_check_customer_exist);
    $row_check_customer_exist = mysqli_num_rows($result_check_customer_exist);

    if ($row_check_customer_exist > 0) {
        $sql = "
            INSERT INTO tbl_product 
            SET category_id = '" . $category_id . "',   
                customer_id = '".$customer_id."',    
                city_id = '".$city_id."',    
                district_id = '".$district_id."',    
                ward_id = '".$ward_id."',    
                product_name = '".$product_name."',    
                phone_contact = '".$phone_contact."',    
                product_image = '".$product_image."',    
                price_sale = '".$price_sale."',
                date_create = (SELECT NOW()),    
                quantity = '".$quantity."'   
        ";
        if (!empty($description)){
            $sql .= " , description = '".$description."'";
        }
        if (!empty($discount))
        {
            $sql .= " , discount = '".$discount."'";
        }
        if (!empty($location))
        {
            $sql .= " , location = '".$location."'";
        }
        if (!empty($status)) {
            $sql .= " , status = '" . $status . "'";
        }

        if ($conn->query($sql)) {
            $id_created = mysqli_insert_id($conn);
            $product_arr = array();

            $product_arr['success'] = 'true';
            $product_arr['data'] = array();
            // get all info of created user

            $sql = "SELECT  	    tbl_category.id as category_id,
                            tbl_category.category_name as category_name,
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
							FROM tbl_product
							INNER  JOIN tbl_category
							ON tbl_product.category_id = tbl_category.id
							WHERE tbl_product.id = '$id_created'";
            $result = $conn->query($sql);
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
                    'location' => $row['location'],
                    'status' => $row['status'],
                    'product_photo' => array(),
                );
                // Push to "data"
                $product_arr['data'] = array(
                    $product_item
                );
            }

            echo json_encode($product_arr);
        } else {
            returnError("Tạo sản phẩm không thành công!");
        }
    } else {
        returnError("Khách hàng không tồn tại");
    }
} else {
    returnError("Danh mục sản phẩm không tồn tại");
}

?>
