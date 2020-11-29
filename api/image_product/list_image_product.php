<?php
$sql = "SELECT * FROM tbl_image_product";

$result = $conn->query($sql);
//Get row count
$num = mysqli_num_rows($result);
if ($num > 0) {
    $image_product_arr = array();
    $image_product_arr['success'] = 'true';
    $image_product_arr['data'] = array();
    while ($row = $result->fetch_assoc()) {
        $image_product_item = array(
            'image_id' => $row['id'],
            'product_id' => $row['product_id'],
            'product_photo' => $row['product_photo'],
        );
        // Push to "data"
        array_push($image_product_arr['data'], $image_product_item);
    }
    //Turn to JSON & output
    echo json_encode($image_product_arr);
} else {
    echo json_encode(array(
        'success' => 'false',
        'message' => 'Không tìm thấy danh mục sản phẩm!'
    ));
}
?>
