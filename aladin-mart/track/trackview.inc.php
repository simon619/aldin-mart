<?php

    declare(strict_types=1);

    function showTrackedProducts(array $trackingproducts) {

        echo '<table align = "left" border = "1">';
        echo '<tr>
                <th>Product Title</th>
                <th>Product Category</th>
                <th>Product Subcategory</th>
                <th>Customer Name</th>
                <th>Customer Number</th>
                <th>Product Retail Price</th>
                <th>Purchased Quantity</th>
                <th>Sold Amount</th>
                <th>Delivered To</th>
              </tr>';
        
        foreach ($trackingproducts as $key => $trackingproduct) {

            $customername = ucwords(str_replace("_", " ", $trackingproduct['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $trackingproduct['user_last_name']));
            $producttitle = ucwords(str_replace("_", " ", $trackingproduct['product_title']));
            $productcategory = ucwords(str_replace("_", " ", $trackingproduct['category_name']));
            $productsubcategory = ucwords(str_replace("_", " ", $trackingproduct['sub_category_name']));
            $customernumber = $trackingproduct['customer_number'];
            $productretailprice = (String) $trackingproduct['product_retail_price'];
            $purchasedquantity = (String) $trackingproduct['purchase_quantity'];
            $soldamount = (String) $trackingproduct['total_price'];
            $districtname = $trackingproduct['district_name'];

            echo '<tr>
                <td>' . htmlspecialchars($producttitle) . '</td>
                <td>' . htmlspecialchars($productcategory) . '</td>
                <td>' . htmlspecialchars($productsubcategory) . '</td>
                <td>' . htmlspecialchars($customername) . '</td>
                <td>' . htmlspecialchars($customernumber) . '</td>
                <td>' . htmlspecialchars($productretailprice) . ' Tk</td>
                <td>' . htmlspecialchars($purchasedquantity) . '</td>
                <td>' . htmlspecialchars($soldamount) . ' Tk </td>
                <td>' . htmlspecialchars($districtname) . '</td>
            </tr>';

        }

    }

    function showCustomerTransactions(array | null $transactions) {

        echo '<table align = "left" border = "1">';
        echo '<tr>
                <th>Vendor Name</th>
                <th>Vendor Shop Name</th>
                <th>Vendor Number</th>
                <th>Vendor Email</th>
                <th>Customer Name</th>
                <th>Customer Personal Number</th>
                <th>Customer Email</th>
                <th>Customer Cart Number</th>
                <th>Purchased Quantity</th>
                <th>Total Price</th>
                <th>Product Title</th>
                <th>Product Retail Price</th>
                <th>Purchased On</th>
                <th>Delivered To District</th>
                <th>Delivered Address</th>
                <th>Status</th>
                <th>Product Detail</th>
              </tr>';

        foreach ($transactions as $key => $transaction) {

            $vendorid = $transaction['vendor_id'];
            $vendorname = ucwords(str_replace("_", " ", $transaction['vendor_first_name'])) . ' ' . ucwords(str_replace("_", " ", $transaction['vendor_last_name']));
            $vendorshopname = ucwords(str_replace("_", " ", $transaction['user_shop_name']));
            $vendornumber = $transaction['vendor_number'];
            $vendoremail = $transaction['vendor_email'];
            $customername = ucwords(str_replace("_", " ", $transaction['customer_first_name'])) . ' ' . ucwords(str_replace("_", " ", $transaction['customer_last_name']));
            $customerpersonalnumber = $transaction['customer_personal_number'];
            $customeremail= $transaction['customer_email'];
            $customercartnumber = $transaction['customer_cart_number'];
            $purchasedquantity = (String) $transaction['purchase_quantity'];
            $totalprice = (String) $transaction['total_price'];
            $productid = $transaction['product_id'];
            $producttitle = ucwords(str_replace("_", " ", $transaction['product_title']));
            $productretailprice = (String) $transaction['product_retail_price'];
            $purchaseon = $transaction['purchased_on'];
            $district = ucwords(str_replace("_", " ", $transaction['district_name']));
            $deliveryaddress = $transaction['delivery_address'];
            $deliverystatus = ucwords(str_replace("_", " ", $transaction['status_name']));

            echo '<tr>
                <td>' . htmlspecialchars($vendorname) . '</td>
                <td>' . htmlspecialchars($vendorshopname) . '</td>
                <td>' . htmlspecialchars($vendornumber) . '</td>
                <td>' . htmlspecialchars($vendoremail) . '</td>
                <td>' . htmlspecialchars($customername) . '</td>
                <td>' . htmlspecialchars($customerpersonalnumber) . ' </td>
                <td>' . htmlspecialchars($customeremail) . '</td>
                <td>' . htmlspecialchars($customercartnumber) . '</td>
                <td>' . htmlspecialchars($purchasedquantity) . '</td>
                <td>' . htmlspecialchars($totalprice) . ' Tk</td>
                <td>' . htmlspecialchars($producttitle) . '</td>
                <td>' . htmlspecialchars($productretailprice) . ' Tk</td>
                <td>' . htmlspecialchars($purchaseon) . '</td>
                <td>' . htmlspecialchars($district) . '</td>
                <td>' . htmlspecialchars($deliveryaddress) . '</td>
                <td>' . htmlspecialchars($deliverystatus) . '</td>
                <td>
                    <a href="../products/productdetail.php?product_id=' . $productid . '&vendor_id=' . $vendorid . '">
                        <button>Details</button>
                    </a>
                </td>
            </tr>';

        }
        
    }

    function showCustomerPendingTransactions(array | null $pendingtransactions) {

        echo '<table align = "left" border = "1">';
        echo '<tr>
                <th>Vendor Name</th>
                <th>Vendor Shop Name</th>
                <th>Vendor Number</th>
                <th>Vendor Email</th>
                <th>Customer Name</th>
                <th>Customer Personal Number</th>
                <th>Customer Email</th>
                <th>Customer Cart Number</th>
                <th>Purchased Quantity</th>
                <th>Total Price</th>
                <th>Product Title</th>
                <th>Product Retail Price</th>
                <th>Purchased On</th>
                <th>Delivered To District</th>
                <th>Delivered Address</th>
                <th>Status</th>
                <th>Cancel Order</th>
              </tr>';

        foreach ($pendingtransactions as $key => $transaction) {

            $transactionid = $transaction['transaction_id'];
            $customerid = $transaction['customer_id'];
            $vendorname = ucwords(str_replace("_", " ", $transaction['vendor_first_name'])) . ' ' . ucwords(str_replace("_", " ", $transaction['vendor_last_name']));
            $vendorshopname = ucwords(str_replace("_", " ", $transaction['user_shop_name']));
            $vendornumber = $transaction['vendor_number'];
            $vendoremail = $transaction['vendor_email'];
            $customername = ucwords(str_replace("_", " ", $transaction['customer_first_name'])) . ' ' . ucwords(str_replace("_", " ", $transaction['customer_last_name']));
            $customerpersonalnumber = $transaction['customer_personal_number'];
            $customeremail= $transaction['customer_email'];
            $customercartnumber = $transaction['customer_cart_number'];
            $purchasedquantity = (String) $transaction['purchase_quantity'];
            $totalprice = (String) $transaction['total_price'];
            $producttitle = ucwords(str_replace("_", " ", $transaction['product_title']));
            $productretailprice = (String) $transaction['product_retail_price'];
            $purchaseon = $transaction['purchased_on'];
            $district = ucwords(str_replace("_", " ", $transaction['district_name']));
            $deliveryaddress = $transaction['delivery_address'];
            $deliverystatus = ucwords(str_replace("_", " ", $transaction['status_name']));

            echo '<tr>
                <td>' . htmlspecialchars($vendorname) . '</td>
                <td>' . htmlspecialchars($vendorshopname) . '</td>
                <td>' . htmlspecialchars($vendornumber) . '</td>
                <td>' . htmlspecialchars($vendoremail) . '</td>
                <td>' . htmlspecialchars($customername) . '</td>
                <td>' . htmlspecialchars($customerpersonalnumber) . ' </td>
                <td>' . htmlspecialchars($customeremail) . '</td>
                <td>' . htmlspecialchars($customercartnumber) . '</td>
                <td>' . htmlspecialchars($purchasedquantity) . '</td>
                <td>' . htmlspecialchars($totalprice) . ' Tk</td>
                <td>' . htmlspecialchars($producttitle) . '</td>
                <td>' . htmlspecialchars($productretailprice) . ' Tk</td>
                <td>' . htmlspecialchars($purchaseon) . '</td>
                <td>' . htmlspecialchars($district) . '</td>
                <td>' . htmlspecialchars($deliveryaddress) . '</td>
                <td>' . htmlspecialchars($deliverystatus) . '</td>
                <td>
                    <a href="../track/cancelpendingproductsoperation.inc.php?transaction_id=' . $transactionid . '&customer_id=' . $customerid . '">
                        <button>Cencel</button>
                    </a>
                </td>
            </tr>';

        }

    }

?>