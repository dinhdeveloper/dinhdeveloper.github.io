<?php

if(isset($_REQUEST['phone_number']))
{
    if($_REQUEST['phone_number']==''){
        unset($_REQUEST['phone_number']);
    }
}

if(isset($_REQUEST['new_password']))
{
    if($_REQUEST['new_password']==''){
        unset($_REQUEST['new_password']);
    }
}

if(!isset($_REQUEST['phone_number']))
{
    echo json_encode(
        array('success'   => 'false','message' => 'Nhập phone_number !')
    );
    exit();
}

if(!isset($_REQUEST['new_password']))
{
    echo json_encode(
        array('success'   => 'false','message' => 'Nhập new_password !')
    );
    exit();
}

if (isset($_REQUEST['new_password']) )
{
    $query = "UPDATE tbl_customer SET ";
    $query .= "pass_word = '" . md5(mysqli_real_escape_string($conn, $_REQUEST['new_password']))        . "' ";
    $query .= "WHERE phone_number = '" .mysqli_real_escape_string($conn, $_REQUEST['phone_number'])."'";
    // check execute query
    if($conn->query($query)) {
        $check=1;
    } else {
        $check=0;
    }
}

// get all user new info

$sql = "
    SELECT * FROM bl_customer WHERE phone_number = '".$_REQUEST['phone_number']."'
   ";
$result = $conn->query($sql);
$user_arr = array();
if ($result->num_rows > 0)
{
    while($row = $result->fetch_assoc())
    {
        $user_item = array(
            'id' => $row['id'],
            'full_name' => $row['full_name'],
            'phone_number' => $row['phone_number'],
            'address' => $row['address'],
            'gender' => $row['gender'],
            'status' => $row['status'],
        );
    }
    $user_arr['success'] = 'true';
    $user_arr['data'] = array(); //$user_item;
    // end get all user new info

    if( $check == 0){
        echo json_encode(
            array('success' => 'false','message' => 'C?p nh?t b? l?i !')
        );
    } else {
        echo json_encode($user_arr);
    }
}


?>