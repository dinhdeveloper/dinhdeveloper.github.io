<?php
$sql = "SELECT * FROM tbl_category";

$result = $conn->query($sql);
//Get row count
$num = mysqli_num_rows($result);
if ($num > 0) {
    $category_arr = array();
    $category_arr['success'] = 'true';
    $category_arr['data'] = array();
    while ($row = $result->fetch_assoc()) {
        $category_item = array(
            'category_id' => $row['id'],
            'category_name' => $row['category_name'],
            'category_image' => $row['category_image'],
        );
        // Push to "data"
        array_push($category_arr['data'], $category_item);
    }
    //Turn to JSON & output
    echo json_encode($category_arr);
} else {
    echo json_encode(array(
        'success' => 'false',
        'message' => 'Không tìm thấy danh mục sản phẩm!'
    ));
}
?>
