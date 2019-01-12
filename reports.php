<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Reports";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Reports";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- links -->
                <div class="links">
                    <ul>
                        <li>
                            <a href="report_Bookings.php">Bookings</a>
                        </li>
                        <li>
                            <a href="report_Invoices.php">Invoices</a>
                        </li>
                        <li>
                            <a href="report_InvoiceDetails.php">Invoice Details</a>
                        </li>
                        <li>
                            <a href="report_Services.php">Services</a>
                        </li>
                        <li>
                            <a href="report_Online_Payers.php">Online Payers</a>
                        </li>
                    </ul>
                </div>
                <!-- end of links -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
