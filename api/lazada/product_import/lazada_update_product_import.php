<?php

$product_id = '';
$product_name = '';
$product_price = '';
$quantity_import = '';
$safe_stock = '';
$employee_name = '';
$employee_phone = '';
$date_create = '';
$status = '';
$store_id = '';
if (isset($_REQUEST['store_id']) && !empty($_REQUEST['store_id'])) {
    $store_id = $_REQUEST['store_id'];
    if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) {
        $product_id = $_REQUEST['product_id'];
    } else {
        returnError("Nhập product_id");
    }

    if (isset($_REQUEST['product_name']) && !empty($_REQUEST['product_name'])) {
        $product_name = $_REQUEST['product_name'];
    } else {
        returnError("Nhập product_name");
    }

    if (isset($_REQUEST['product_price']) && !empty($_REQUEST['product_price'])) {
        $product_price = $_REQUEST['product_price'];
    } else {
        returnError("Nhập product_price");
    }

    if (isset($_REQUEST['quantity_import']) && !empty($_REQUEST['quantity_import'])) {
        $quantity_import = $_REQUEST['quantity_import'];
    } else {
        returnError("Nhập quantity_import");
    }

    if (isset($_REQUEST['safe_stock']) && !empty($_REQUEST['safe_stock'])) {
        $safe_stock = $_REQUEST['safe_stock'];
    } else {
        returnError("Nhập safe_stock");
    }

    if (isset($_REQUEST['employee_name']) && !empty($_REQUEST['employee_name'])) {
        $employee_name = $_REQUEST['employee_name'];
    } else {
        returnError("Nhập employee_name");
    }

    if (isset($_REQUEST['employee_phone']) && !empty($_REQUEST['employee_phone'])) {
        $employee_phone = $_REQUEST['employee_phone'];
    } else {
        returnError("Nhập employee_phone");
    }

    $sql = "    UPDATE product_import 
                SET product_name = '" . $product_name . "',   
                product_price = '" . $product_price . "',    
                product_quantity_import = '" . $quantity_import . "',    
                product_safestock = '" . $safe_stock . "',    
                product_name_employee = '" . $employee_name . "',    
                product_phone_employee = '" . $employee_phone . "',       
                product_date_create = (SELECT NOW())
                WHERE product_import.id = '$product_id'
                AND product_import.store_id = '$store_id'
        ";

    echo $sql;
    exit();

    if ($conn->query($sql)) {
        returnSuccess("Cập nhật sản phẩm thành công!");
    } else {
        returnError("Cập nhật sản phẩm không thành công!");
    }
} else {
    returnError("Chọn cửa hàng");
}

?>
