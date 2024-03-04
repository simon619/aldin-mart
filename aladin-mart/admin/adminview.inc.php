<?php

    declare(strict_types=1);

    function showVendors(array $vendors) {

        echo '<table align = "left" border = "1">';
        echo '<tr>
                <th>Vendor Name</th>
                <th>Vendor Email</th>
                <th>Vendor Number</th>
                <th>Vendor Shop Name</th>
                <th>Profile Status</th>
                <th>Profile Created</th>
                <th>Vendor Products</th>
                <th>Change Status</th>
            </tr>';

            foreach ($vendors as $key => $vendor) {

                $vendorid = $vendor['id'];
                $vendorname = ucwords(str_replace("_", " ", $vendor['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $vendor['user_last_name']));
                $vendoremail = $vendor['user_email'];
                $vendornumber = $vendor['user_number'];
                $vendorshopname = $vendor['user_shop_name'];
                // $vendorsoldquantity = (String )$vendor['total_sold_quantity'];
                // $totalsold = (String) $vendor['total_sold_price'];
                $profilestatusvalue = $vendor['profile_status'];
                $profilestatus = ($vendor['profile_status']) ? "ACTIVE" : "BLOCKED";
                $buttonstatus = ($vendor['profile_status']) ? "BLOCK" : "UNBLOCK"; 
                $profilecreated = $vendor['profile_created'];

                echo '<tr>
                    <td>' . htmlspecialchars($vendorname) . '</td>
                    <td>' . htmlspecialchars($vendoremail) . '</td>
                    <td>' . htmlspecialchars($vendornumber) . '</td>
                    <td>' . htmlspecialchars($vendorshopname) . '</td>
                    <td>' . htmlspecialchars($profilestatus) . '</td>
                    <td>' . htmlspecialchars($profilecreated) . '</td>
                    <td>
                        <a href="../products/productslist.php?vendor_id=' . $vendorid . '">
                            <button>Vendor Product List</button>
                        </a>
                    </td>
                    <td>
                        <a href="profilestatuschangeoperation.inc.php?user_id=' . $vendorid . '&profile_status=' . $profilestatusvalue . '">
                            <button>' . $buttonstatus . '</button>
                        </a>
                    </td>
                </tr>';

            }

    }

    function showCustomers(array $customers) {

        echo '<table align = "left" border = "1">';
        echo '<tr>
                <th>Vendor Name</th>
                <th>Vendor Email</th>
                <th>Vendor Number</th>
                <th>Profile Status</th>
                <th>Profile Created</th>
                <th>Customer Transactions</th>
                <th>Change Status</th>
            </tr>';

            foreach ($customers as $key => $customer) {

                $customerid = $customer['id'];
                $customername = ucwords(str_replace("_", " ", $customer['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $customer['user_last_name']));
                $customeremail = $customer['user_email'];
                $customernumber = $customer['user_number'];
                // $customersoldquantity = ($customer['total_sold_quantity']) ? (String) $customer['total_sold_quantity'] : "No Data";
                // $totalpurchased = ($customer['total_sold_price']) ? (String) $customer['total_sold_price'] : "No Data";
                $profilestatusvalue = $customer['profile_status'];
                $profilestatus = ($customer['profile_status']) ? "ACTIVE" : "BLOCKED";
                $buttonstatus = ($customer['profile_status']) ? "BLOCK" : "UNBLOCK"; 
                $profilecreated = $customer['profile_created'];

                echo '<tr>
                    <td>' . htmlspecialchars($customername) . '</td>
                    <td>' . htmlspecialchars($customeremail) . '</td>
                    <td>' . htmlspecialchars($customernumber) . '</td>
                    <td>' . htmlspecialchars($profilestatus) . '</td>
                    <td>' . htmlspecialchars($profilecreated) . '</td>
                    <td>
                        <a href="../track/customerproducttransactionlist.php?customer_id=' . $customerid . '">
                            <button>All My Purchase History</button>
                        </a>
                    </td>
                    <td>
                        <a href="profilestatuschangeoperation.inc.php?user_id=' . $customerid . '&profile_status=' . $profilestatusvalue . '">
                            <button>' . $buttonstatus . '</button>
                        </a>
                    </td>
                </tr>';

            }

    }

    function showUsersEarnSpendData(array | null $usersdata) {

        echo '<table align = "left" border = "1">';
        echo '<tr>
                <th>User Name</th>
                <th>User Email</th>
                <th>User Number</th>
                <th>Total Sell/Purchae Quantity</th>
                <th>Total Earn/Spend</th>
            </tr>';

            foreach ($usersdata as $key => $user) {
            
                $username = ucwords(str_replace("_", " ", $user['user_first_name'])) . ' ' . ucwords(str_replace("_", " ", $user['user_last_name']));
                $useremail = $user['user_email'];
                $usernumber = $user['user_number'];
                $userquantity = (String) $user['total_quantity'];
                $usercost = (String) $user['total_cost'];

                echo '<tr>
                    <td>' . htmlspecialchars($username) . '</td>
                    <td>' . htmlspecialchars($useremail) . '</td>
                    <td>' . htmlspecialchars($usernumber) . '</td>
                    <td>' . htmlspecialchars($userquantity) . '</td>
                    <td>' . htmlspecialchars($usercost) . '</td>
                </tr>';

            }
        

    }


?>