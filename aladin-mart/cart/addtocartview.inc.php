<?php

    declare(strict_types=1);

    function showtransactions(array $transactions) {

        echo '<table align = "left" border = "1">';
        echo '<tr>
                <th>Product Title</th>
                <th>Product SKU</th>
                <th>Product Wholesale Price</th>
                <th>Product Retail Price</th>
                <th>Sub Category Name</th>
                <th>Purchased Quantity</th>
                <th>Total Price</th>
                <th>Vendor Name</th>
                <th>Customer Name</th>
                <th>Customer Phone Number</th>
                <th>District Name</th>
                <th>Delivery Address</th>
                <th>Purchased On</th>
                <th>Status</th>
                <th>Change Status</th>
            </tr>';
        
        foreach ($transactions as $key => $transactions) {


            $transactionid = (int) $transactions['id'];
            $producttitle = ucwords(str_replace("_", " ", $transactions['product_title']));
            $productsku = $transactions['product_sku'];
            $productwholesaleprice = (String) $transactions['product_wholesale_price'];
            $productretailprice = (String) $transactions['product_retail_price'];
            $subcategoryname = ucwords(str_replace("_", " ", $transactions['sub_category_name']));
            $purchasedquantity = (String) $transactions['purchase_quantity'];
            $totalprice = (String) $transactions['total_price'];
            $vendorname = ucwords(str_replace("_", " ", $transactions['vendor_first_name'])) . ' ' . ucwords(str_replace("_", " ", $transactions['vendor_last_name']));
            $customername = ucwords(str_replace("_", " ", $transactions['customer_first_name'])) . ' ' . ucwords(str_replace("_", " ", $transactions['customer_last_name']));
            $customernumber = (String) $transactions['customer_number'];
            $districtname = $transactions['district_name'];
            $deliveryaddress = $transactions['delivery_address'];
            $status = ucwords(str_replace("_", " ", $transactions['status_name']));
            $purchasedon = $transactions['purchased_on']; 
            

            echo '<tr>
                <td>' . htmlspecialchars($producttitle) . '</td>
                <td>' . htmlspecialchars($productsku) . '</td>
                <td>' . htmlspecialchars($productwholesaleprice) . ' Tk</td>
                <td>' . htmlspecialchars($productretailprice) . ' TK</td>
                <td>' . htmlspecialchars($subcategoryname) . '</td>
                <td>' . htmlspecialchars($purchasedquantity) . '</td>
                <td>' . htmlspecialchars($totalprice) . ' </td>
                <td>' . htmlspecialchars($vendorname) . ' </td>
                <td>' . htmlspecialchars($customername) . ' </td>
                <td>' . htmlspecialchars($customernumber) . ' </td>
                <td>' . htmlspecialchars($districtname) . '</td>
                <td>' . htmlspecialchars($deliveryaddress) . '</td>
                <td>' . htmlspecialchars($purchasedon) . '</td>
                <td>' . htmlspecialchars($status) . '</td>
                <td>
                    <form action="changestatusoperation.inc.php" method="post">
                        <input type="hidden" name="transaction_id" value="' . $transactionid . '">
                        <select id="statusid" name="statusid">
                            <option value="0">Pending</option>
                            <option value="1">Packaging Process</option>
                            <option value="2">Handed Over to Carrier</option>
                            <option value="3">delivered</option>
                            <option value="4">cancelled</option>
                        </select>
                        <input type="submit" name="submit" class="submitBtn" value="SUBMIT">
                    </form>
                </td>
            </tr>';

        }

    }

?>