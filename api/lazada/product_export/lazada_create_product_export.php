<?php

$product_id = '';
$product_name = '';
$quantity_export = '';
$customer_name = '';
$customer_phone = '';
$customer_address = '';
$type_order = '';
$date_create = '';
$store_id = '';
if (isset($_REQUEST['store_id']) && !empty($_REQUEST['store_id'])){

    $store_id =$_REQUEST['store_id'];

    if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) {
        $product_id = $_REQUEST['product_id'];
    } else {
        returnError("Nhập product_id");
    }
    if (isset($_REQUEST['quantity_export']) && !empty($_REQUEST['quantity_export'])) {
        $quantity_export = $_REQUEST['quantity_export'];
    } else {
        returnError("Nhập quantity_export");
    }

    if (isset($_REQUEST['customer_name']) && !empty($_REQUEST['customer_name'])) {
        $customer_name = $_REQUEST['customer_name'];
    } else {
        returnError("Nhập customer_name");
    }

    if (isset($_REQUEST['customer_phone']) && !empty($_REQUEST['customer_phone'])) {
        $customer_phone = $_REQUEST['customer_phone'];
    } else {
        returnError("Nhập customer_phone");
    }

    if (isset($_REQUEST['customer_address']) && !empty($_REQUEST['customer_address'])) {
        $customer_address = $_REQUEST['customer_address'];
    } else {
        returnError("Nhập customer_address");
    }

    if (isset($_REQUEST['type_order'])) {
        if ($_REQUEST['type_order'] == '') {
            unset($_REQUEST['type_order']);
        } else {
            $type_order = $_REQUEST['type_order'];
        }
    }


    $name = "    SELECT product_import.product_name 
             FROM product_import 
             WHERE product_import.id = '$product_id'
             AND ";
    $result = $conn->query($name);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        while ($rowItem = $result->fetch_assoc()) {
            $product_name = $rowItem['product_name'];
        }
        //insert
        $sql = "    INSERT INTO product_export 
                    SET product_name = '" . $product_name . "',   
                    product_import_id = '" . $product_id . "',   
                    product_quantity = '" . $quantity_export . "',    
                    product_name_customer = '" . $customer_name . "',    
                    product_phone_customer = '" . $customer_phone . "',
                    product_date_create = (SELECT NOW()),
                    product_address_customer = '" . $customer_address . "'  
        ";
        if (!empty($type_order)) {
            $sql .= " , product_type = '" . $type_order . "'";
        }
        if ($conn->query($sql)) {
            $result = mysqli_insert_id($conn);

            //cap nhat lai ton kho
            $quantity_old_import = '0';
            $quantity_new_import = '0';
            $check_quantity_import = "SELECT product_import.product_quantity_import 
                                    FROM product_import 
                                    WHERE product_import.id = '$product_id' ";
            $result_check = $conn->query($check_quantity_import);
            $num_check = mysqli_num_rows($result_check);
            if ($num_check > 0) {
                while ($rowItem = $result_check->fetch_assoc()) {
                    $quantity_old_import = $rowItem['product_quantity_import'];
                }
            }
            $quantity_new_import = $quantity_old_import-$quantity_export;
            $sql = "UPDATE product_import 
                SET product_quantity_import = '$quantity_new_import'
                WHERE product_import.id = '$product_id'";
            if ($conn->query($sql)) {
                returnSuccess("Tạo sản phẩm thành công!");
            } else {
                returnError("Tạo sản phẩm không thành công!");
            }
        } else {
            returnError("Tạo sản phẩm không thành công.");
        }

    } else {

    }
}else{
    returnError("Chọn cửa hàng");
}

?>
