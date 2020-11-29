<?php

$product_id = '';
$product_photo = '';


if (isset($_FILES['product_photo'])) {
    $product_photo = saveImage($_FILES['product_photo'], 'images/image_product/');

    if ($product_photo == "error_size_img") {
        returnError("product_photo > 5MB !");
    }

    if ($product_photo == "error_type_img") {
        returnError("product_photo error type");
    }
}
if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id']))
{
    $product_id = $_REQUEST['product_id'];
}
else{
    returnError("Nhập product_id");
}

    $category_arr = array();

$sql = "INSERT INTO tbl_image_product(product_id,product_photo) VALUES ('$product_id','$product_photo')";


if ($conn->query($sql)) {
    $id_created = mysqli_insert_id($conn);
    $photo_arr = array();

    $photo_arr['success'] = 'true';
    $photo_arr['data'] = array();
    // get all info of created user
    
    $sql = "SELECT
                    tbl_image_product.id as id,
                    tbl_image_product.product_id as product_id,
                    tbl_image_product.product_photo as product_photo,
                          
              FROM tbl_image_product
              WHERE tbl_image_product .id = '".$id_created."'
              ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $user_item = array(
            'id' => $row['id'],
            'product_id' => $row['product_id'],
            'product_photo' => $row['product_photo'],
        );
        // Push to "data"
        $photo_arr['data'] = array(
            $user_item
        );
    }

    echo json_encode($photo_arr);
} else {
    returnError("Tạo hình ảnh không thành công!");
}

?>
