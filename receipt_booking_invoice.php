<?php
require_once "functions.php";

//getting data from the table Users
//getting data from the table Users
$rows_Users = table_Users('select_one', $_SESSION['UsersId'], NULL);
foreach ($rows_Users as $row_Users) {
    // code...
}

//getting the InvoiceNo
$InvoiceNo = trim($_REQUEST['InvoiceNo']);

//getting data from the table Invoices
$rows_Invoices = table_Invoices('select_one', $InvoiceNo, NULL);
foreach ($rows_Invoices as $row_Invoices) {
    $BookingsId = $row_Invoices->BookingsId;
}

//getting data from the table Bookings
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // code...
}

//getting data from the table InvoiceHeader
$rows_InvoiceHeader = table_InvoiceHeader('select_one', $InvoiceNo, NULL);
foreach ($rows_InvoiceHeader as $row_InvoiceHeader) {
    // code...
}

$rows_InvoiceDetails = table_InvoiceDetails('select_one', $InvoiceNo, NULL);
foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
    // print_r($row_InvoiceDetails);
}

//getting the currency
if ($row_Invoices->USD == 0 || $row_Invoices->USD == NULL) {
    $currency = 'MMK';
}
elseif ($row_Invoices->MMK == 0 || $row_Invoices->MMK == NULL) {
    $currency = 'USD';
}
else {
    echo "There was an error processing! Please contact the system administrator!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_Invoices('update_receipt', $InvoiceNo, NULL);
    $Method = $_REQUEST['Method'];
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = $row_Bookings->Reference.' - '.$InvoiceNo;
    include "includes/head.html";
    ?>
    <body>
        <!-- print -->
        <div class="print">
            <!-- pageHeader -->
            <div class="pageHeader">
                <table>
                    <thead>
                        <tr>
                            <td>
                                <img src="images/LinkLogo.jpg" alt="Link Logo">
                            </td>
                            <td>
                                <ul>
                                    <li class="bold">Link In Myanmar Travel</li>
                                    <li>No. 72, Tayoke Kyaung Street</li>
                                    <li>Sanchaung, Township, Yangon</li>
                                    <li>Tel: 95-9402590317</li>
                                    <li>Email: <a href="mailto:infor@linkinmyanmar.com">info@linkinmyanmar.com</a></li>
                                    <li>Website: <a href="http://www.linkinmyanmar.com">www.linkinmyanmar.com</a></li>
                                </ul>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- end of pageHeader -->
            <!-- Invoice -->
            <div class="Invoice">
                <h1>Receipt</h1>
                <!-- InvoiceHead -->
                <div class="InvoiceHead">
                    <table>
                        <thead>
                            <tr>
                                <td>
                                    <ul>
                                        <li>
                                            Addressee:
                                            <? echo $row_InvoiceHeader->Addressee; ?>
                                        </li>
                                        <li>
                                            Address:
                                            <? echo $row_InvoiceHeader->Address; ?>
                                        </li>
                                        <li>
                                            City:
                                            <? echo $row_InvoiceHeader->City; ?>
                                        </li>
                                        <li>
                                            Attn:
                                            <? echo $row_InvoiceHeader->Attn; ?>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>
                                            Date:
                                            <? echo date('d-M-Y', strtotime($row_Invoices->InvoiceDate)); ?>
                                        </li>
                                        <li>
                                            Invoice No:
                                            <? echo $InvoiceNo; ?>
                                        </li>
                                        <li>
                                            Booking Reference:
                                            <? echo $row_Bookings->Reference; ?>
                                        </li>
                                        <li>
                                            Booking Name:
                                            <? echo $row_Bookings->Name; ?>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- end of InvoiceHead -->
                <!-- InvoiceBody -->
                <div class="InvoiceBody">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount in <? echo $currency; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
                                $year = date('Y', strtotime($row_InvoiceDetails->Date));
                                if ($year >= 2019) {
                                    echo "<tr>";
                                    echo "<td>".date("d-M-y", strtotime($row_InvoiceDetails->Date))."</td>";
                                    echo "<td>".$row_InvoiceDetails->Description."</td>";
                                    echo "<td>";
                                    if ($currency == 'USD') {
                                        echo $row_InvoiceDetails->USD;
                                    }
                                    else {
                                        echo $row_InvoiceDetails->MMK;
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                            <tr>
                                <th colspan="2">Total in <? echo $currency; ?></th>
                                <th>
                                    <?php
                                    if ($currency == 'USD') {
                                        echo $total = $row_Invoices->USD;
                                    }
                                    elseif ($currency == 'MMK') {
                                        echo $total = $row_Invoices->MMK;
                                    }
                                    else {
                                        echo 'Please contact your administrator!';
                                    }
                                    ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        Amount in <? echo $currency." : ".ucwords(convert_number_to_words(round($total,0)))." ONLY."; ?>
                        <br>
                        Sales Person : <? echo $row_Users->Fullname; ?>
                        <br>
                        <span id="selectedMethod" class="invisible">
                            <?php
                            if (!empty($Method)) {
                                echo $Method;
                            }
                            ?>    
                        </span>

                        <form action="#" method="post" id="myForm">
                        Payment Method :
                            <select name="Method" id="Method" onchange="generateReceipt();">
                                <option value="0">Select One</option>
                                <option value="1">Cash</option>
                                <option value="2">UOB USD & SGD</option>
                                <option value="3">Visa/Master</option>
                                <option value="4">KBZ MMK</option>
                                <option value="5">CB MMK & USD</option>
                                <option value="6">Aya MMK</option>
                                <option value="7">DBS</option>
                                <option value="9">YOMA</option>
                                <option value="10">MAB</option>
                            </select>
                        </form>
                    </p>
                </div>
                <!-- end of InvoiceBody -->
            </div>
            <!-- end of Invoice -->
        </div>
        <!-- end of print -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
    <script type="text/javascript">
        var selectedMethod = document.getElementById('selectedMethod');
        if (selectedMethod.innerHTML != null) {
            var Method = document.getElementById('Method');
            Method.selectedIndex = selectedMethod.innerHTML;
        }
        else {
            Method.selectedIndex = '0';
        }
    </script>
</html>
