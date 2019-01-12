<?php
require_once "functions.php";

//getting data from the table Corporates
$rows_Corporates = table_Corporates('select', NULL, NULL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CorporatesId = $_REQUEST['CorporatesId'];
    $Status = $_REQUEST['Status'];
    $ArvDate1 = $_REQUEST['ArvDate1'];
    $ArvDate2 = $_REQUEST['ArvDate2'];
    $created1 = $_REQUEST['created1'];
    $created2 = $_REQUEST['created2'];
    $search = trim($_REQUEST['search']);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'Report: Bookings';
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- search -->
                <div class="search">
                    <form action="#" method="post">
                        <ul>
                            <li class="bold">Enter Search Criteria</li>
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
                                <select name="Status">
                                    <?php
                                    switch ($Status) {
                                        case 'Confirmed':
                                            echo "<option value=\"Confirmed\" selected>Confirmed</option>";
                                            echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                            break;

                                        case 'Not Confirmed':
                                            echo "<option value=\"Confirmed\">Confirmed</option>";
                                            echo "<option value=\"Not Confirmed\" selected>Not Confirmed</option>";
                                            break;

                                        default:
                                            echo "<option value=\"\">Select One</option>";
                                            echo "<option value=\"Confirmed\">Confirmed</option>";
                                            echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                            break;
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Arrival Date From:
                                <input type="date" name="ArvDate1" value="<? echo $ArvDate1; ?>">
                                &nbsp;
                                Until
                                <input type="date" name="ArvDate2" value="<? echo $ArvDate2; ?>">
                            </li>
                            <li>
                                Create Date From:
                                <input type="date" name="created1" value="<? echo $created1; ?>">
                                &nbsp;
                                Until:
                                <input type="date" name="created2" value="<? echo $created2; ?>">
                            </li>
                            <li>
                                <input type="text" name="search" placeholder="Search" value="<? if (!empty($search)) { echo $search; } ?>">
                            </li>
                            <li>
                                <button type="submit" class="button submit" name="buttonSubmit">Search</button>
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
                                <th>Reference</th>
                                <th>Name</th>
                                <th>Corporate</th>
                                <th>Arrival</th>
                                <th>Pax</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>User</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $rows_report_Bookings = report_Bookings();
                                foreach ($rows_report_Bookings as $row_report_Bookings) {
                                    echo "<tr>";
                                    echo "<td><a href=\"booking_summary.php?BookingsId=$row_report_Bookings->BookingsId\">$row_report_Bookings->Reference</a></td>";
                                    echo "<td>".$row_report_Bookings->BookingsName."</td>";
                                    echo "<td>".$row_report_Bookings->CorporatesName."</td>";
                                    echo "<td>".date('d-M-y', strtotime($row_report_Bookings->ArvDate))."</td>";
                                    echo "<td>".$row_report_Bookings->Pax."</td>";
                                    echo "<td>".$row_report_Bookings->Status."</td>";
                                    echo "<td>".$row_report_Bookings->Remark."</td>";
                                    echo "<td>".$row_report_Bookings->Username."</td>";
                                    echo "<td>".$row_report_Bookings->created."</td>";
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
