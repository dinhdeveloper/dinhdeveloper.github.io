<?php
$phone_number = '';
$user_arr = '';
if (isset($_REQUEST['phone_number']) && !empty($_REQUEST['phone_number'])) {
    $phone_number = $_REQUEST['phone_number'];

    // check customer_id_code exists
    $sql_check_customer_code = "SELECT * FROM  tbl_customer WHERE phone_number = '" . $phone_number . "'";
    $result_check_customer_code = $conn->query($sql_check_customer_code);
    $num_result_check_customer_code = mysqli_num_rows($result_check_customer_code);
    if ($num_result_check_customer_code > 0) {
        returnError("Khách hàng đã tồn tại!");
    }
    else{
        returnSuccess("Khách hàng chưa có trên hệ thống!");
    }
}else{
    returnError("Nhập số điện thoại");
}

?>