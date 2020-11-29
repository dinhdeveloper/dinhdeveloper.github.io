<?php

$product_id = '';
$category_id = '';
//$customer_id = '';
$image_id = '';
$product_name = '';
$product_image = '';
$price_sale = '';
$quantity = '';
$description = '';
$discount = '';
$location = '';
$status = '';

if (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) {
    $category_id = $_REQUEST['category_id'];
} else {
    returnError("Chọn danh mục");
}

if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) {
    $product_id = $_REQUEST['product_id'];
} else {
    returnError("Chọn sản phẩm cập nhật");
}
//
if (isset($_REQUEST['image_id']) && !empty($_REQUEST['image_id'])) {
    $image_id = $_REQUEST['image_id'];
} else {
    returnError("Chọn hình ảnh");
}

if (isset($_REQUEST['product_name']) && !empty($_REQUEST['product_name'])) {
    $product_name = $_REQUEST['product_name'];
} else {
    returnError("Nhập tên sản phẩm");
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
    returnError("Nhập giá sản phẩm");
}

if (isset($_REQUEST['quantity']) && !empty($_REQUEST['quantity'])) {
    $quantity = $_REQUEST['quantity'];
} else {
    returnError("Nhập số lượng");
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
if (isset($_REQUEST['location']) && !empty($_REQUEST['location'])) {
    $location = $_REQUEST['location'];
} else {
    returnError("Nhập nơi bán");
}

if (isset($_REQUEST['status'])) {
    if ($_REQUEST['status'] == '') {
        unset($_REQUEST['status']);
    } else {
        $status = $_REQUEST['status'];
    }
}

$sql = "SELECT * FROM tbl_product WHERE id = '$product_id'";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
    while ($rowItem = $result->fetch_assoc()) {
        $image = $rowItem['product_image'];

        if (file_exists('../' . $image)) {
            unlink('../' . $image);
        }
    }
    $query = "  UPDATE tbl_product SET category_id ='$category_id', product_name='$product_name',
                product_image = '$product_image',price_sale = '$price_sale',quantity = '$quantity',
                description = '$description',location= '$location',status = '$status'
                WHERE tbl_product.id ='$product_id'";

//    $query = "  UPDATE tbl_product SET ";
//    if (!empty($category_id)) {
//        $query .= "  category_id = '" . $category_id . "'";
//    }
//    else{
//        returnError("Chọn danh mục sản phẩm");
//    }
//    if (!empty($image_id)) {
//        $query .= " , image_id = '" . $image_id . "'";
//    }
//    else{
//        returnError("Chọn hình ảnh hiển thị sản phẩm");
//    }
//    if (!empty($product_name)) {
//        $query .= " , product_name = '" . $product_name . "'";
//    }
//    else{
//        returnError("Nhập tên sản phẩm");
//    }
//    if (!empty($product_image)) {
//        $query .= " , product_image = '" . $product_image . "'";
//    }
//    else{
//        returnError("Chọn hình ảnh minh họa");
//    }
//    if (!empty($price_sale)) {
//        $query .= " , price_sale = '" . $price_sale . "'";
//    }
//    else{
//        returnError("Nhập giá sản phẩm");
//    }
//    if (!empty($quantity)) {
//        $query .= " , quantity = '" . $quantity . "'";
//    }
//    else{
//        returnError("Nhập số lượng sản phẩm");
//    }
//    if (!empty($description)) {
//        $query .= " , description = '" . $description . "'";
//    }
//    if (!empty($location)) {
//        $query .= " ,location = '" . $location . "'";
//    } else {
//        returnError("Hãy chọn nơi muốn bán");
//    }
//    if (!empty($status)) {
//        $query .= " , status = '" . $status . "'";
//    }
//
//    $query .= " WHERE id ='$product_id'";
    if ($conn->query($query)) {
        returnSuccess("Cập nhật sản phẩm thành công!");
    } else {
        returnError("Cập nhật sản phẩm không thành công!");
    }
} else {
    returnError("Sản phẩm không tồn tại");
}
?>