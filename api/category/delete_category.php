<?php
$category_id = '';
if (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) {
    $category_id = $_REQUEST['category_id'];
} else {
    returnError("Nhập category_id");
}
//kiem tra ton tai product
$query = "SELECT * FROM tbl_category WHERE id='$category_id'";
$result = $conn->query($query);
$num_category = mysqli_num_rows($result);

if ($num_category > 0) {

    $sql_check_product = "SELECT * FROM tbl_product WHERE tbl_product.category_id = '$category_id'";
    $result_check_product = $conn->query($sql_check_product);
    $row_check_product = mysqli_num_rows($result_check_product);
    if ($row_check_product>0){
        returnError("Không thể xóa danh mục");
    }
    else{
        while ($rowItem = $result->fetch_assoc()) {
            $category_image = $rowItem['category_image'];

            if (file_exists('../' . $category_image)) {
                unlink('../' . $category_image);
            }
        }
        $sql_delete_category = "DELETE FROM tbl_category WHERE id= '$category_id'";
        if ($conn->query($sql_delete_category)) {
            returnSuccess("Xóa danh mục thành công!");
        } else {
            returnError("Xóa danh mục không thành công!");
        }
    }

} else {
    returnError("Danh mục không tồn tại");
}
?>
