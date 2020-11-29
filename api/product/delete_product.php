<?php
$id_product = '';
if (isset($_REQUEST['id_product']) && !empty($_REQUEST['id_product'])) {
    $id_product = $_REQUEST['id_product'];
} else {
    returnError("Nhập id_product");
}
//kiem tra ton tai product
$query = "SELECT * FROM tbl_product WHERE tbl_product.id='$id_product'";
$result = $conn->query($query);
$num_product = mysqli_num_rows($result);
if ($num_product > 0) {

    while ($rowItem = $result->fetch_assoc()) {
        $product_image = $rowItem['product_image'];

//        echo $product_image;
//        exit();

        if (file_exists('../' . $product_image)) {
            unlink('../' . $product_image);
        }
    }
    $sql_delete_product = "DELETE FROM tbl_product WHERE tbl_product.id= '$id_product'";

    if ($conn->query($sql_delete_product)) {
        returnSuccess("Xóa sản phẩm thành công!");
    } else {
        returnError("Xóa sản phẩm không thành công!");
    }

} else {
    returnError("Sản phẩm không tồn tại");
}
?>
