<?php

//if (isset($_REQUEST['phone_number']) && ! empty($_REQUEST['phone_number'])) {
//    $phone_number = $_REQUEST['phone_number'];
//}else{
//    returnError("Nhập số điện thoại");
//}
//if (isset($_REQUEST['password']) && ! empty($_REQUEST['password'])) {
//    $password = $_REQUEST['password'];
//}else{
//    returnError("Nhập mật khẩu");
//}
//
//
if (isset($_REQUEST['phone_number'])) {
    if ($_REQUEST['phone_number'] == '') {
        unset($_REQUEST['phone_number']);
    }
}
if (! isset($_REQUEST['phone_number'])) {
    returnError("Nhập phone!");
}

if (isset($_REQUEST['password'])) {
    if ($_REQUEST['password'] == '') {
        unset($_REQUEST['password']);
    }
}

if (! isset($_REQUEST['password'])) {
    returnError("Nhập password!");
}

$username = $_REQUEST['phone_number'];
$password = $_REQUEST['password'];

$result_arr = array();

// check login employee
$sql_check_employee_exists = "SELECT tbl_customer.id as id,
                                     tbl_customer.full_name as full_name,
                                     tbl_customer.phone_number as phone_number,
                                     tbl_customer.address as address,
                                     tbl_customer.gender as gender,
                                     tbl_customer.status as status,
                                     tbl_customer.image as image,
                                     tbl_customer.pass_word as pass_word
                                 FROM tbl_customer 
                                WHERE BINARY tbl_customer.phone_number = '" . $username . "'";

$result_check_employee_exists = mysqli_query($conn, $sql_check_employee_exists);
$num_result_check_employee_exists = mysqli_num_rows($result_check_employee_exists);

if ($num_result_check_employee_exists > 0) {
    while ($rowItemEmployee = $result_check_employee_exists->fetch_assoc()) {
        if ($rowItemEmployee['pass_word'] == md5($password)) {
            $employee_item = array(
                'id' => $rowItemEmployee['id'],
                'full_name' => $rowItemEmployee['full_name'],
                'phone_number' => $rowItemEmployee['phone_number'],
                'address' => $rowItemEmployee['address'],
                'gender' => $rowItemEmployee['gender'],
                'image' => $rowItemEmployee['image'],
                'status' => $rowItemEmployee['status'],
            );

            $result_arr['success'] = 'true';
            $result_arr['data'] = array(
                $employee_item
            );

            echo json_encode($result_arr);

            exit();
        } else {
            returnError("Sai mật khẩu!");
        }
    }
}
else{
    $result_arr['success'] = 'false';
    returnError("Đăng nhập không thành công!");
}

//else {
//    // login customer
//    $sql = "SELECT
//                    id,
//                    id_code,
//                    full_name,
//                    gender,
//                    phone_number,
//                    status,
//                    password
//
//            FROM  customer
//            WHERE phone_number = '" . $username . "'
//           ";
//    $result = mysqli_query($conn, $sql);
//
//    $num_row = mysqli_num_rows($result);
//
//    if ($num_row > 0) {
//
//        while ($row = $result->fetch_assoc()) {
//            if ($row['password'] == md5($password)) {
//
////                // if users account banned
////                if ($row['status'] == 'N') {
////                    returnError("Tài khoản này đã bị khóa!");
////                }
//
//                $user_item = array(
//                    'id' => $row['id'],
//                    'id_code' => $row['id_code'],
//                    'full_name' => $row['full_name'],
//                    'gender' => $row['gender'],
//                    'phone_number' => $row['phone_number'],
//                    'status' => $row['status']
//                );
//
//                $result_arr['success'] = 'true';
//                $result_arr['data'] = array(
//                    $user_item
//                );
//
//                echo json_encode($result_arr);
//
//                exit();
//            } else {
//                returnError("Sai mật khẩu!");
//            }
//        }
//    } else {
//        returnError("Tài khoản đăng nhập không tồn tại!");
//    }
//}

