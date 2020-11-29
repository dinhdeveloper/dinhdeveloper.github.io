<?php

$product_id = '';
$product_import_id = '';
$product_name = '';
$quantity_export = '';
$customer_name = '';
$customer_phone = '';
$customer_address = '';
$type_order = '';
$date_create = '';
$store_id = '';
if (isset($_REQUEST['store_id']) && !empty($_REQUEST['store_id'])) {

    $store_id = $_REQUEST['store_id'];

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
    $product_old_quantity_export = '';
    $product_old_quantity_import = '';
//lay so luong cu cua export
    $sql2 = "SELECT product_export.product_quantity,
                product_export.product_import_id
                FROM product_export
                WHERE product_export.id = '$product_id'";

    $result_2 = $conn->query($sql2);
    $num_2 = mysqli_num_rows($result_2);
    if ($num_2 > 0) {
        while ($rowItem = $result_2->fetch_assoc()) {
            $product_old_quantity_export = $rowItem['product_quantity']; // lay dc id product import
            $product_import_id = $rowItem['product_import_id'];
        }
    }

    $name = "    SELECT product_import.product_name
             FROM product_import 
             WHERE product_import.id = '$product_import_id'";

    $result = $conn->query($name);
    $num = mysqli_num_rows($result);

    if ($num > 0) {
        while ($rowItem = $result->fetch_assoc()) {
            $product_name = $rowItem['product_name'];
        }

//update
        $sql = "    UPDATE product_export 
                SET product_name = '" . $product_name . "',   
                product_quantity = '" . $quantity_export . "',    
                product_name_customer = '" . $customer_name . "',    
                product_phone_customer = '" . $customer_phone . "',
                product_date_create = (SELECT NOW()),
                product_address_customer = '" . $customer_address . "'
        ";
        if (!empty($type_order)) {
            $sql .= " , product_type = '" . $type_order . "'";
        }
        $sql .= " WHERE product_export.id = '$product_id'";

        if ($conn->query($sql)) { //cap nhat export thanh cong
            // tim so luong ben import
            $sql2 = "SELECT product_import.product_quantity_import
                    FROM product_import
                    WHERE product_import.id = '$product_import_id'";

            $result_2 = $conn->query($sql2);
            $num_2 = mysqli_num_rows($result_2);
            if ($num_2 > 0) {
                while ($rowItem = $result_2->fetch_assoc()) {
                    $product_old_quantity_import = $rowItem['product_quantity_import']; // lay dc id product import
                }
                //cap nhat lai so luong
                $product_new_quantity_import = $product_old_quantity_export + $product_old_quantity_import;

                $sql_3 = "UPDATE product_import 
                SET product_quantity_import = '$product_new_quantity_import'
                WHERE product_import.id = '$product_import_id'";
                if ($conn->query($sql_3)) {//tra lai so luong ban dau
                    $product_quantity_after_update = $product_new_quantity_import - $quantity_export;

                    $sql_4 = "UPDATE product_import 
                                SET product_quantity_import = '$product_quantity_after_update'
                                WHERE product_import.id = '$product_import_id'";

                    if ($conn->query($sql_4)) {
                        returnSuccess("Cập nhật thành công.");
                    } else {
                        returnError("Cập nhật không thành công.");
                    }
                }
            }

        } else {
            returnError("Cập nhật không thành công.");
        }

    } else {
        returnError("Không tìm thấy sản phẩm");
    }
}else{
    returnError("Chọn cửa hàng.");
}
?>
