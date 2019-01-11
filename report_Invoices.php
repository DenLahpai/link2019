<?php
require_once "functions.php";

//getting data from the table Corporates
$rows_Corporates = table_Corporates('select', NULL, NULL);


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'Report: Invoices';
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = 'Report Invoices';
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- search -->
                <div class="search">
                    <form action="#" method="post">
                        <ul>
                            <li class="bold">
                                Enter Search Criteria
                            </li>
                            <li>
                                Invoice From:
                                <input type="date" name="InvoiceDate1" value="">
                                &nbsp;
                                Until:
                                <input type="date" name="InvoiceDate2" value="">
                            </li>
                            <li>
                                Corporates:
                                <select name="CorporatesId">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_Corporates as $row_Corporates) {
                                        if ($CorporatesId == $row_Corporates->Id) {
                                            echo "<option value=\"$row_Corporates->Id\" selected>".$row_Corporates->Name."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_Corporates->Id\">".$row_Corporates->Name."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                &nbsp;
                                Status:
                                <select name="InvoicesStatus">
                                    <option value="">Select One</option>
                                    <option value="Invoiced">Invoiced</option>
                                    <option value="Paid">Paid</option>
                                </select>
                            </li>
                            <li>
                                <input type="text" name="search" placeholder="Search">
                            </li>
                            <li>
                                <button type="submit" class="button submit" name="buttonSubmit">Search</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of search -->
                <!-- report table -->
                <div class="report table">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Invoice Date</th>
                                <th>USD</th>
                                <th>MMK</th>
                                <th>Status</th>
                                <th>Method</th>
                                <th>Invoice No</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $rows_report_Invoices =  report_Invoices();
                                foreach ($rows_report_Invoices as $row_report_Invoices) {
                                    echo "<tr>";
                                    echo "<td><a href=\"edit_booking_invoice.php?InvoiceNo=$row_report_Invoices->InvoiceNo\" target=\"_blank\">Edit</a></td>";
                                    echo "<td>".$row_report_Invoices->Reference."</td>";
                                    echo "<td>".$row_report_Invoices->BookingsName."</td>";
                                    echo "<td>".$row_report_Invoices->CorporatesName."</td>";
                                    echo "<td>".date('d-M-y', strtotime($row_report_Invoices->InvoiceDate))."</td>";
                                    echo "<td>".$row_report_Invoices->USD."</td>";
                                    echo "<td>".$row_report_Invoices->MMK."</td>";
                                    echo "<td>".$row_report_Invoices->Status."</td>";
                                    echo "<td>".$row_report_Invoices->Method."</td>";
                                    echo "<td>".$row_report_Invoices->InvoiceNo."</td>";
                                    echo "<td><a href=\"receipt_booking_invoice.php?InvoiceNo=$row_report_Invoices->InvoiceNo\" target=\"_blank\">Receipt</a></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of report table -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
