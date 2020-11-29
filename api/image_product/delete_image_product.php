<?php
$image_id = '';
if (isset($_REQUEST['image_id']) && !empty($_REQUEST['image_id'])) {
    $image_id = $_REQUEST['image_id'];
} else {
    returnError("Nhập image_id");
}
//kiem tra ton tai product
$query = "SELECT * FROM tbl_image_product WHERE id='$image_id'";
$result = $conn->query($query);
$num_image = mysqli_num_rows($result);

if ($num_image > 0) {

    while ($rowItem = $result->fetch_assoc()) {
        $_image = $rowItem['product_photo'];

        if (file_exists('../' . $_image)) {
            unlink('../' . $_image);
        }
    }
    $sql_delete_image = "DELETE FROM tbl_image_product WHERE id= '$image_id'";
    if ($conn->query($sql_delete_image)) {
        returnSuccess("Xóa hình ảnh thành công!");
    } else {
        returnError("Xóa hình ảnh không thành công!");
    }

} else {
    returnError("Hình ảnh không tồn tại");
}
?>
