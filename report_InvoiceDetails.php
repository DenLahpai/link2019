<?php
require_once "functions.php";

//getting data from the table Corporates
$rows_Corporates = table_Corporates('select', NULL, NULL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Date1 = $_REQUEST['Date1'];
    $Date2 = $_REQUEST['Date2'];
    $CorporatesId = $_REQUEST['CorporatesId'];
    $InvoicesStatus = $_REQUEST['InvoicesStatus'];
    $search = trim($_REQUEST['search']);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Report: Invoice Details";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = 'Report Invoice Details';
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- search  -->
                <div class="search">
                    <form action="#" method="post">
                        <ul>
                            <li class="bold">
                                Enter Search Criteria
                            </li>
                            <li>
                                Invoice Details From:
                                <input type="date" name="Date1" id="Date1" onchange="autoFillSecondDate('Date1','Date2');" value="<? echo $Date1; ?>">
                                &nbsp;
                                Until:
                                <input type="date" name="Date2" id="Date2" value="<? echo $Date2; ?>">
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
                                    <?php
                                    switch ($InvoicesStatus) {
                                        case 'Invoiced':
                                            echo "<option value=\"Invoiced\" selected>Invoiced</option>";
                                            echo "<option value=\"Paid\">Paid</option>";
                                            break;
                                        case 'Paid':
                                            echo "<option value=\"Invoiced\">Invoiced</option>";
                                            echo "<option value=\"Paid\" selected>Paid</option>";
                                            break;

                                        default:
                                        echo "<option value=\"\">Select One</option>";
                                        echo "<option value=\"Invoiced\">Invoiced</option>";
                                        echo "<option value=\"Paid\">Paid</option>";
                                            break;
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                <input type="text" name="search" placeholder="Search" value="<? if (!empty($search)) { echo $search; } ?>">
                            </li>
                            <li>
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="compareDates('Date1', 'Date2');">Search</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of search -->
                <!-- report table  -->
                <div class="report table">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>USD</th>
                                <th>MMK</th>
                                <th>Invoice No</th>
                                <th>Invoice Status</th>
                                <th>Reference</th>
                                <th>Name</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $rows_report_InvoiceDetails = report_Invoice_Details();
                                foreach ($rows_report_InvoiceDetails as $row_report_InvoiceDetails) {
                                    $thisYear = 2019;
                                    $year = date('Y', strtotime($row_report_InvoiceDetails->Date));
                                    if ($year >= 2019) {
                                        echo "<tr>";
                                        echo "<td><a href=\"edit_booking_invoice.php?InvoiceNo=$row_report_InvoiceDetails->InvoiceNo\">View</a></td>";
                                        echo "<td>".date('d-M-y', strtotime($row_report_InvoiceDetails->Date))."</td>";
                                        echo "<td>".$row_report_InvoiceDetails->Description."</td>";
                                        echo "<td>".$row_report_InvoiceDetails->USD."</td>";
                                        echo "<td>".$row_report_InvoiceDetails->MMK."</td>";
                                        echo "<td>".$row_report_InvoiceDetails->InvoiceNo."</td>";
                                        echo "<td>".$row_report_InvoiceDetails->Status."</td>";
                                        echo "<td>".$row_report_InvoiceDetails->Reference."</td>";
                                        echo "<td>".$row_report_InvoiceDetails->Name."</td>";
                                        echo "<td>".$row_report_InvoiceDetails->Method."</td>";
                                        echo "</tr>";
                                    }
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
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
