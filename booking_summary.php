<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // codes...
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Summary: $row_Bookings->Reference";
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
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_Invoices = table_Invoices('select_by_BookingsId', $BookingsId, NULL);
                    foreach ($rows_Invoices as $row_Invoices) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li class=\"bold\">Invoice No: ".$row_Invoices->InvoiceNo."</li>";
                        echo "<li>Invoice Date: ".date("d-M-y", strtotime($row_Invoices->InvoiceDate))."</li>";
                        echo "<li>Amount: ".$row_Invoices->USD." USD</li>";
                        echo "<li>Amount: ".$row_Invoices->MMK." MMK</li>";
                        echo "<li>Status: ";
                        if ($row_Invoices->Status == 'Paid') {
                            echo "Paid on ".date("d-M-y", strtotime($row_Invoices->PaidOn));
                        }
                        else {
                            echo $row_Invoices->Status;
                        }
                        echo "</li>";
                        echo "<li><a href=\"booking_invoices_edit.php?InvoiceNo=$row_Invoices->InvoiceNo\">Edit</a>";
                        echo "<li><a href=\"booking_invoices_receipt.php?InvoiceNo=$row_Invoices->InvoiceNo\">Receipt</a>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
