<?php
//
//$category_name = '';
//$category_image = '';
//
//if (isset($_REQUEST['category_name'])) {
//    if ($_REQUEST['category_name'] == '') {
//        unset($_REQUEST['category_name']);
//    } else {
//        $category_name = $_REQUEST['category_name'];
//    }
//} else {
//    returnError("Nhập category_name!");
//}
//if (isset($_FILES['category_image'])) {
//    $category_image = saveImage($_FILES['category_image'], 'images/category/');
//
//    if ($category_image == "error_size_img") {
//        returnError("category_image > 5MB !");
//    }
//
//    if ($category_image == "error_type_img") {
//        returnError("category_image error type");
//    }
//}
//
//$category_arr = array();
//
//$sql = "INSERT INTO tbl_category(category_name,category_image) VALUES ('$category_name','$category_image')";
//
//if ($conn->query($sql)) {
//    $result = mysqli_insert_id($conn);
//    returnSuccess("Tạo danh mục thành công!");
//} else {
//    returnError("Tạo danh mục không thành công!");
//}
//
//?>
