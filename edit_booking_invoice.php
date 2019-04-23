<?php
require_once "functions.php";

//getting invoice data
$InvoiceNo = trim($_REQUEST['InvoiceNo']);

//Updating the table Invoices, InvoiceHeader and InvoiceDetails
//when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_InvoiceHeader('update', $InvoiceNo, NULL);
    table_InvoiceDetails('update', $InvoiceNo, NULL);
    table_Invoices('update', $InvoiceNo, NULL);
}

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

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Invoice: ".$row_Bookings->Reference;
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = $page_title;
            include "includes/header.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <!-- table invoice -->
                <div class="table invoice">
                    <form action="#" method="post">
                        <table>
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>
                                        <ul>
                                            <li>
                                                Addressee:
                                                <input type="text" name="Addressee" id="Addressee" value="<? echo $row_InvoiceHeader->Addressee; ?>" required>
                                            </li>
                                            <li>
                                                Address:
                                                <input type="text" name="Address" value="<? echo $row_InvoiceHeader->Address; ?>">
                                            </li>
                                            <li>
                                                City:
                                                <input type="text" name="City" value="<? echo $row_InvoiceHeader->City; ?>">
                                            </li>
                                            <li>
                                                Attn:
                                                <input type="text" name="Attn" value="<? echo $row_InvoiceHeader->Attn; ?>">
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                Invoice Date:
                                                <input type="date" name="InvoiceDate" id="InvoiceDate" value="<? echo $row_Invoices->InvoiceDate; ?>" required>
                                            </li>
                                            <li>
                                                Invoice No:
                                                <input type="text" name="InvoiceNo" value="<? echo $InvoiceNo; ?>" readonly>
                                            </li>
                                            <li>
                                                Reference:
                                                <input type="text" name="Reference" value="<? echo $row_Bookings->Reference?>" readonly>
                                            </li>
                                            <li>
                                                Booking Name:
                                                <input type="text" name="Name" value="<? echo $row_Bookings->Name; ?>" readonly>
                                            </li>
                                        </ul>
                                    </td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Date</th>
                                    <th colspan="2">Service</th>
                                    <th>Amount in <? echo $currency; ?></th>
                                </tr>
                                <?php
                                $i = 1;
                                foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
                                    echo "<tr>";
                                    echo "<td><input type=\"number\" name=\"Id$i\" value=\"$row_InvoiceDetails->Id\" class=\"invisible\">";
                                    echo "<input type=\"date\" name=\"Date$i\" value=\"$row_InvoiceDetails->Date\"></td>";
                                    echo "<td colspan=\"2\"><input type=\"text\" name=\"Description$i\" value=\"$row_InvoiceDetails->Description\" style=\"width: 90%;\"></td>";
                                    if ($currency == 'USD') {
                                        echo "<td><input type=\"number\" step=\"0.01\" name=\"amount$i\" value=\"$row_InvoiceDetails->USD\"></td>";
                                    }
                                    else {
                                        echo "<td><input type=\"number\" name=\"amount$i\" value=\"$row_InvoiceDetails->MMK\"></td>";
                                    }
                                    echo "</tr>";
                                    $i++;
                                }
                                ?>
                                <tr>
                                    <th colspan="4">
                                        <input type="text" class="invisible" name="currency" value="<? echo $currency;?>">
                                        <button type="button" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Addressee', 'InvoiceDate', 'Addressee')">Update</button>
                                        <a href="<? echo "print_invoice.php?InvoiceNo=$InvoiceNo"; ?>" target="_blank"><button type="button" class="link button" name="button">Print</button></a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- end of table invoice -->
            </main>
            <?php include "includes/footer.html"; ?>            
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
