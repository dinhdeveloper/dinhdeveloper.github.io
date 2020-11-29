<?php
$category_id = '';
$category_name = '';
$category_image = '';
if (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) {
    $category_id = $_REQUEST['category_id'];
} else {
    returnError("Chọn danh mục sản phẩm");
}

if (isset($_REQUEST['category_name'])) {
    if ($_REQUEST['category_name'] == '') {
        unset($_REQUEST['category_name']);
    } else {
        $category_name = $_REQUEST['category_name'];
    }
}

if (isset($_FILES['category_image'])) {
    $category_image = saveImage($_FILES['category_image'], 'images/category/');

    if ($category_image == "error_size_img") {
        returnError("category_image > 5MB !");
    }

    if ($category_image == "error_type_img") {
        returnError("category_image error type");
    }
}

$sql = "SELECT * FROM tbl_category WHERE id = '$category_id'";
$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
    while ($rowItem = $result->fetch_assoc()) {
        $image = $rowItem['category_image'];

        if (file_exists('../' . $image)) {
            unlink('../' . $image);
        }
    }

    $query = "UPDATE tbl_category SET ";
    if (!empty($category_name)) {
        $query .= " category_name = '" . $category_name . "'";
    }
    if (!empty($category_image)) {
        $query .= " , category_image = '" . $category_image . "'";
    }
    $query .= " WHERE id ='$category_id'";

    if ($conn->query($query)) {
        returnSuccess("Cập nhật danh mục thành công!");
    } else {
        returnError("Cập nhật danh mục không thành công!");
    }
} else {
    returnError("Danh mục không tồn tại");
}
?>