<?php

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

    $store_id =$_REQUEST['store_id'];

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

    $sql = "    INSERT INTO product_import 
                SET product_name = '" . $product_name . "',   
                product_price = '" . $product_price . "',    
                product_quantity_import = '" . $quantity_import . "',    
                product_safestock = '" . $safe_stock . "',    
                product_name_employee = '" . $employee_name . "',    
                product_phone_employee = '" . $employee_phone . "',       
                product_date_create = (SELECT NOW()),     
                WHERE store_id ='$store_id'
        ";

    if ($conn->query($sql)) {
        $result = mysqli_insert_id($conn);
        returnSuccess("Tạo sản phẩm thành công!");
    } else {
        returnError("Tạo sản phẩm không thành công!");
    }

} else {
    returnError("Nhập store_id");
}

?>
