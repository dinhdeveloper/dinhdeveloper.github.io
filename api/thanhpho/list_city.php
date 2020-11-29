<?php
$sql = "SELECT * FROM tinhthanhpho";

$result = $conn->query($sql);
//Get row count
$num = mysqli_num_rows($result);
if ($num > 0) {
    $category_arr = array();
    $category_arr['success'] = 'true';
    $category_arr['data'] = array();
    while ($row = $result->fetch_assoc()) {
        $category_item = array(
            'city_id' => $row['matp'],
            'city_name' => $row['name'],
            'city_type' => $row['type'],
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
