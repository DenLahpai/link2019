<?php
require_once "functions.php";
//getting data from the table bookings
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // code...
}

//Inserting data to the tables
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //getting the currency;
    $currency = $_REQUEST['currency'];

    // generating the InvoiceNo
    $InvoiceNo = table_Invoices('generate_InvoiceNo', NULL, NULL);
    table_InvoiceHeader('insert', $InvoiceNo, NULL);
    table_InvoiceDetails('insert', $InvoiceNo, $currency);
    table_Invoices('insert', $InvoiceNo, $BookingsId);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Invoice: $row_Bookings->Reference";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = "Invoice : $row_Bookings->Reference";
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
                                                <input type="text" name="Addressee" id="Addressee" placeholder="Addressee" required>
                                            </li>
                                            <li>
                                                Address:
                                                <input type="text" name="Address" placeholder="Address">
                                            </li>
                                            <li>
                                                City:
                                                <input type="text" name="City" placeholder="City">
                                            </li>
                                            <li>
                                                Attn:
                                                <input type="text" name="Attn" placeholder="Attn">
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                Invoice Date:
                                                <input type="text" name="InvoiceDate" id="InvoiceDate" value="<? echo date('Y-m-d'); ?>">
                                            </li>
                                            <li>
                                                Invoice No:
                                                <input type="text" name="InvoiceNo" value="2019-XXXX" readonly>
                                            </li>
                                            <li>
                                                Reference:
                                                <input type="text" name="Reference" value="<? echo $row_Bookings->Reference; ?>" readonly>
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
                                    <th>Amount</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                $i = 1;
                                while ($i <= 20) {
                                    include "includes/invoice_details.php";
                                    $i++;
                                }
                                ?>
                                <tr>
                                    <th colspan="4">
                                        <select name="currency" id="currency">
                                            <option value="">Select One</option>
                                            <option value="USD">USD</option>
                                            <option value="MMK">MMK</option>
                                        </select>
                                        <button type="button" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Addressee', 'InvoiceDate', 'currency');">Submit</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- end of table invoice -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html";  ?>
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
