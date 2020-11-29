<?php
$image_id = '';
$product_id = '';
$product_photo = '';
if (isset($_REQUEST['image_id']) && !empty($_REQUEST['image_id'])) {
    $image_id = $_REQUEST['image_id'];
} else {
    returnError("Nhập image_id");
}
if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) {
    $product_id = $_REQUEST['product_id'];
} else {
    returnError("Nhập product_id");
}

if (isset($_FILES['product_photo'])) {
    $product_photo = saveImage($_FILES['product_photo'], 'images/image_product/');

    if ($product_photo == "error_size_img") {
        returnError("product_photo > 5MB !");
    }

    if ($product_photo == "error_type_img") {
        returnError("product_photo error type");
    }
}

$sql = "SELECT * FROM tbl_image_product WHERE tbl_image_product.id = '$image_id'";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
    while ($rowItem = $result->fetch_assoc()) {
        $image = $rowItem['product_photo'];

        if (file_exists('../' . $image)) {
            unlink('../' . $image);
        }
    }

    $query = "UPDATE tbl_image_product SET product_id='$product_id',
                    product_photo = '$product_photo' WHERE id ='$image_id'";
    if ($conn->query($query)) {
        returnSuccess("Cập nhật hình ảnh thành công!");
    } else {
        returnError("Cập nhật hình ảnh không thành công!");
    }
} else {
    returnError("Hình ảnh không tồn tại");
}
?>