<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Methods: GET");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'basic_auth.php';
include_once '../lib/connect.php';

include_once '../lib/reuse_function.php';

// check if data recived is from raw - if so, assign it to $_REQUEST
if (!isset($_REQUEST['detect'])) {
    // get raw json data
    $_REQUEST = json_decode(file_get_contents('php://input'), true);
    if (!isset($_REQUEST['detect'])) {
        echo json_encode(array(
            'message' => 'detect parameter not found !'
        ));
        exit();
    }
}
// handle detect value
$detect = $_REQUEST['detect'];

switch ($detect) {
    /**
     * tinh, thanh pho, quan huyen*
     */
    case 'list_city':
    {
        include_once 'thanhpho/list_city.php';
        break;
    }
    case 'list_district':
    {
        include_once 'thanhpho/list_district.php';
        break;
    }
    /**
     * account*
     */
    case 'login':
    {
        include_once 'account/login.php';
        break;
    }
    case 'check_login':
    {
        include_once 'account/check_phone.php';
        break;
    }
    case 'register':
    {
        include_once 'account/register.php';
        break;
    }
    case 'forgot_password':
    {
        include_once 'account/forgot_password.php';
        break;
    }

    /**
     * list_board*
     */
    case 'list_product':
    {
        include_once 'product/list_product.php';
        break;
    }
    case 'list_product_by_discount':
    {
        include_once 'product/list_product_by_discount.php';
        break;
    }

    case 'search_product':
    {
        include_once 'product/search_product.php';
        break;
    }

    case 'product_by_date':
    {
        include_once 'product/product_by_date.php';
        break;
    }
    case 'list_product_customer':
    {
        include_once 'product/list_product_by_customer.php';
        break;
    }
    case 'list_category':
    {
        include_once 'category/list_category.php';
        break;
    }
    case 'list_image_product':
    {
        include_once 'image_product/list_image_product.php';
        break;
    }
    case 'list_customer':
    {
        include_once 'customer/list_customer.php';
        break;
    }

    /**
     * list_board_lazada*
     */

    case 'lazada_list_import':
    {
        include_once 'lazada/product_import/lazada_list_import.php';
        break;
    }

     case 'lazada_list_export':
    {
        include_once 'lazada/product_export/lazada_list_export.php';
        break;
    }

    case 'create_product_import':
    {
        include_once 'lazada/product_import/lazada_create_product_import.php';
        break;
    }

    case 'create_product_export':
    {
        include_once 'lazada/product_export/lazada_create_product_export.php';
        break;
    }

    case 'update_product_import':
    {
        include_once 'lazada/product_import/lazada_update_product_import.php';
        break;
    }

    case 'update_product_export':
    {
        include_once 'lazada/product_export/lazada_update_product_export.php';
        break;
    }



    /**
     * end lazada*
     */


    /**
     * create_board*
     */
    case 'create_product':
    {
        include_once 'product/create_product.php';
        break;
    }
    case 'create_category':
    {
        include_once 'category/create_category.php';
        break;
    }
    case 'create_image_product':
    {
        include_once 'image_product/create_image_product.php';
        break;
    }
    case 'create_customer':
    {
        include_once 'customer/create_customer.php';
        break;
    }
    /**
     * update_board*
     */
    case 'update_product':
    {
        include_once 'product/update_product.php';
        break;
    }
    case 'update_category':
    {
        include_once 'category/update_category.php';
        break;
    }
    case 'update_image_product':
    {
        include_once 'image_product/update_image_product.php';
        break;
    }
    case 'update_customer':
    {
        include_once 'customer/update_customer.php';
        break;
    }
    /**
     * delete_board*
     */
    case 'delete_product':
    {
        include_once 'product/delete_product.php';
        break;
    }
    case 'delete_category':
    {
        include_once 'category/delete_category.php';
        break;
    }
    case 'delete_image_product':
    {
        include_once 'image_product/delete_image_product.php';
        break;
    }
    case 'delete_customer':
    {
        include_once 'customer/delete_customer.php';
        break;
    }

    /**
     * Admin_board*
     */


    // end Quang's links

    default:
    {
        echo json_encode(array(
            'success' => 'false',
            'message' => 'detect has been failed !'
        ));
        break;
    }
}

// edit file in new branch
?>