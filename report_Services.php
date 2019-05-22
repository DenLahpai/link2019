<?php
require_once "functions.php";

//getting data from the table ServiceType
$rows_ServiceType = table_ServiceType('select', NULL, NULL);

//getting data from the table ServiceStatus
$rows_ServiceStatus = table_ServiceStatus('select_all', NULL, NULL);

//getting data from the table Corporates
$rows_Corporates = table_Corporates('select_all', NULL, NULL);

//getting date from the table Suppliers
$rows_Suppliers = table_Suppliers('select', NULL, NULL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ServiceDate1 = $_REQUEST['ServiceDate1'];
    $ServiceDate2 = $_REQUEST['ServiceDate2'];
    if (empty($ServiceDate2)) {
        $ServiceDate2 = $ServiceDate1;
    }
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];
    $StatusId = $_REQUEST['StatusId'];
    $SuppliersId = $_REQUEST['SuppliersId'];
    $search = trim($_REQUEST['search']);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Report: Service";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Report: Service";
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
                                Service From:
                                <input type="date" name="ServiceDate1" id="ServiceDate1" value="<? echo $ServiceDate1; ?>" onchange="autoFillSecondDate('ServiceDate1', 'ServiceDate2');">
                                &nbsp;
                                Until:
                                <input type="date" name="ServiceDate2" id="ServiceDate2" value="<? echo $ServiceDate2; ?>">
                            </li>
                            <li>
                                Service Type:
                                <select name="ServiceTypeId">
                                    <option value="">Select one</option>
                                    <?php
                                    foreach ($rows_ServiceType as $row_ServiceType) {
                                        if ($ServiceTypeId == $row_ServiceType->Id) {
                                            echo "<option value=\"$row_ServiceType->Id\" selected>".$row_ServiceType->Code." - ".$row_ServiceType->Type."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_ServiceType->Id\">".$row_ServiceType->Code." - ".$row_ServiceType->Type."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                &nbsp;
                                Status:
                                <select name="StatusId">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_ServiceStatus as $row_ServiceStatus) {
                                        if ($ServiceStatusId == $row_ServiceStatus->Id){
                                            echo "<option value=\"$row_ServiceStatus->Id\" selected>".$row_ServiceStatus->Code."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_ServiceStatus->Id\">".$row_ServiceStatus->Code."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Suppliers:
                                <select name="SuppliersId">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_Suppliers as $row_Suppliers) {
                                        if ($SuppliersId == $row_Suppliers->Id) {
                                            echo "<option value=\"$row_Suppliers->Id\" selected>".$row_Suppliers->Name."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_Suppliers->Id\">".$row_Suppliers->Name."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                <input type="text" name="search" placeholder="Search" value="<? if (!empty($search)) { echo $search; }?>">
                            </li>
                            <li>
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="compareDates('ServiceDate1', 'ServiceDate2');">Search</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of search -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
</html>
