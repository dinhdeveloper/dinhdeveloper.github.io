<?php
$customer_id = '';
$full_name = '';
$phone_number = '';
$image = '';
$address = '';
$gender = '';
$status = '';
if (isset($_REQUEST['customer_id']) && !empty($_REQUEST['customer_id'])) {
    $customer_id = $_REQUEST['customer_id'];
} else {
    returnError("Chọn danh mục sản phẩm");
}

if (isset($_REQUEST['full_name'])) {
    if ($_REQUEST['full_name'] == '') {
        unset($_REQUEST['full_name']);
    } else {
        $full_name = $_REQUEST['full_name'];
    }
}
if (isset($_REQUEST['address'])) {
    if ($_REQUEST['address'] == '') {
        unset($_REQUEST['address']);
    } else {
        $address = $_REQUEST['address'];
    }
}
if (isset($_REQUEST['gender'])) {
    if ($_REQUEST['gender'] == '') {
        unset($_REQUEST['gender']);
    } else {
        $gender = $_REQUEST['gender'];
    }
}
if (isset($_REQUEST['status'])) {
    if ($_REQUEST['status'] == '') {
        unset($_REQUEST['status']);
    } else {
        $status = $_REQUEST['status'];
    }
}

if (isset($_FILES['image'])) {
    $image = saveImage($_FILES['image'], 'images/customer/');

    if ($image == "error_size_img") {
        returnError("image > 5MB !");
    }

    if ($image == "error_type_img") {
        returnError("image error type");
    }
}

$sql = "SELECT * FROM tbl_customer WHERE id = '$customer_id'";

$result = $conn->query($sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
    while ($rowItem = $result->fetch_assoc()) {
        $image = $rowItem['image'];

        if (file_exists('../' . $image)) {
            unlink('../' . $image);
        }
    }

    $query = "UPDATE tbl_customer SET ";
    if (!empty($full_name)) {
        $query .= " full_name = '" . $full_name . "'";
    }
    if (!empty($image)) {
        $query .= " , image = '" . $image . "'";
    }
    if (!empty($address)) {
        $query .= " , address = '" . $address . "'";
    }
    if (!empty($gender)) {
        $query .= " , gender = '" . $gender . "'";
    }
    if (!empty($status)) {
        $query .= " , status = '" . $status . "'";
    }
    $query .= " WHERE id ='$customer_id'";

    if ($conn->query($query)) {
        returnSuccess("Cập nhật danh mục thành công!");
    } else {
        returnError("Cập nhật danh mục không thành công!");
    }
} else {
    returnError("Danh mục không tồn tại");
}
?>