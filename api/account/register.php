<?php

$phone_number = '';
$user_arr = '';
if (isset($_REQUEST['phone_number']) && ! empty($_REQUEST['phone_number'])) {
    $phone_number = $_REQUEST['phone_number'];

    // check customer_id_code exists
    $sql_check_customer_code = "SELECT * FROM  tbl_customer WHERE phone_number = '" . $phone_number . "'";
    $result_check_customer_code = $conn->query($sql_check_customer_code);
    $num_result_check_customer_code = mysqli_num_rows($result_check_customer_code);
    if ($num_result_check_customer_code > 0) {
        returnError("Khách hàng đã tồn tại!");
    }
}
else{
    returnError("Nhập phone_number!");
}
$full_name = '';
if (isset($_REQUEST['full_name']) && ! empty($_REQUEST['full_name'])) {
    $full_name = $_REQUEST['full_name'];
}else{
    returnError("Nhập full_name!");
}

/* password */
$password = '';
if (isset($_REQUEST['password']) && ! empty($_REQUEST['password'])) {
    $password = $_REQUEST['password'];
}else{
    returnError("Nhập password!");
}
/* password */

$query_image = '';
if (isset($_FILES['image'])) {
    $query_image = saveImage($_FILES['image'], 'images/customer/');

    if ($query_image == "error_size_img") {
        returnError("image > 5MB !");
    }

    if ($query_image == "error_type_img") {
        returnError("image error type");
    }
}

$full_name = $_REQUEST['full_name'];
$password = md5($_REQUEST['password']);
$phone_number = $_REQUEST['phone_number'];

$sex = '';
if (isset($_REQUEST['sex']) && ! empty($_REQUEST['sex'])) {
    $sex = $_REQUEST['sex'];
}

$address = '';
if (isset($_REQUEST['address']) && ! empty($_REQUEST['address'])) {
    $address = $_REQUEST['address'];
} else {
    if (empty($id_address)) {
        returnError("Nhập address!");
    }
}
// Create query insert into user

$sql = "
    INSERT INTO  tbl_customer
    SET full_name           = '" . $full_name . "',
        phone_number          = '" . $phone_number . "',
        address        = '" . $address . "',
        pass_word            = '" . $password . "'
    ";

if (!empty($sex)){
    $sql .= " , gender = '".$sex."'";
}
if (!empty($query_image)){
    $sql .= " , image = '".$query_image."'";
}

// Return customer info just created
if ($conn->query($sql)) {

    $id_created = mysqli_insert_id($conn);

    //tạo địa chỉ mặc định cho customer

    $user_arr = array();

    $user_arr['success'] = 'true';
    $user_arr['data'] = array();
    // get all info of created user
    $sql = "SELECT
                    tbl_customer.id as id,
                    tbl_customer.full_name as full_name,
                    tbl_customer.phone_number as phone_number,
                    tbl_customer.address as address,
                    tbl_customer.gender as gender,
                    tbl_customer.image as image,
                    tbl_customer.status as status
        
              FROM tbl_customer
              WHERE tbl_customer .id = '".$id_created."'
              ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $user_item = array(
            'id' => $row['id'],
            'full_name' => $row['full_name'],
            'phone_number' => $row['phone_number'],
            'address' => $row['address'],
            'gender' => $row['gender'],
            'image' => $row['image'],
            'status' => $row['status'],
        );
        // Push to "data"
        $user_arr['data'] = array(
            $user_item
        );
    }

    echo json_encode($user_arr);
} else {
    returnError("Đăng ký không thành công!");
}

?>

