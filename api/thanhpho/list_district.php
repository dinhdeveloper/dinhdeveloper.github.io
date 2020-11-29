<?php
$city_id = '';
if (isset($_REQUEST['city_id']) && !empty($_REQUEST['city_id'])) {
    $city_id = $_REQUEST['city_id'];
    $sqls = "SELECT * FROM quanhuyen WHERE quanhuyen.matp = '$city_id'";
    $results = $conn->query($sqls);
    $nums = mysqli_num_rows($results);
    if ($nums > 0) {
        $district_arr = array();
        $district_arr['success'] = 'true';
        $district_arr['data'] = array();
        while ($row = $results->fetch_assoc()) {
            $district_item = array(
                'district_id' => $row['maqh'],
                'city_id' => $row['matp'],
                'district_name' => $row['name'],
                'district_type' => $row['type'],
            );
// Push to "data"
            array_push($district_arr['data'], $district_item);
        }
//Turn to JSON & output
        echo json_encode($district_arr);
    }
} else {
    $sql = "SELECT * FROM quanhuyen";

    $result = $conn->query($sql);
//Get row count
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $category_arr = array();
        $category_arr['success'] = 'true';
        $category_arr['data'] = array();
        while ($row = $result->fetch_assoc()) {
            $category_item = array(
                'district_id' => $row['maqh'],
                'city_id' => $row['matp'],
                'district_name' => $row['name'],
                'district_type' => $row['type'],
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
}

?>