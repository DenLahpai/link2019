<?php
require_once "functions.php";

//getting data from the table Bookings
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // codes...
}

// getting data from the table ServiceType
$rows_ServiceType = table_ServiceType('select', NULL, NULL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //getting ServiceTypeId
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];

    //getting data from the table Suppliers that have the Service Type $ServiceType
    $rows_Suppliers = table_Suppliers ('select_distinct_Suppliers', $ServiceTypeId, NULL);
}

if (isset($_REQUEST['buttonSubmit'])) {
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];
    $SupplierId = $_REQUEST['SupplierId'];
    $Date_in = $_REQUEST['Date_in'];
    $rows_Services = table_Services('select_to_add', $ServiceTypeId, $SupplierId);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = $row_Bookings->Reference.": New Service";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <!-- service form -->
                <div class="service form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Service Type:
                                <select name="ServiceTypeId" onchange="this.form.submit();">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_ServiceType as $row_ServiceType) {
                                        if ($ServiceTypeId == $row_ServiceType->Id) {
                                            echo "<option value=\"$row_ServiceType->Id\" selected>".$row_ServiceType->Type."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_ServiceType->Id\">".$row_ServiceType->Type."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Supplier:
                                <select name="SupplierId">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_Suppliers as $row_Suppliers) {
                                        if ($SupplierId == $row_Suppliers->SupplierId) {
                                            echo "<option value=\"$row_Suppliers->SupplierId\" selected>".$row_Suppliers->Name."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_Suppliers->SupplierId\">".$row_Suppliers->Name."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Date:
                                <input type="date" name="Date_in" id="Date_in" value="<? echo $Date_in; ?>">
                            </li>
                            <li>
                                <button type="submit" name="buttonSubmit" id="buttonSubmit">Search</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of service form -->
                <!-- list services -->
                <div class="list service">
                    <ul>
                        <?php
                        if (!empty($rows_Services)) {
                            foreach ($rows_Services as $row_Services) {
                                echo "<li>";
                                echo "<a href=\"adding_services_booking.php?BookingsId=$BookingsId&ServicesId=$row_Services->Id&Date_in=$Date_in\"><button>Add</button></a>";
                                echo "&nbsp;".$row_Services->Service.", ";
                                echo $row_Services->Additional."&nbsp;";
                                echo "Valid From: ".date("d-M-y", strtotime($row_Services->StartDate))."&nbsp;";
                                echo "Valid Until: ".date("d-M-y", strtotime($row_Services->EndDate))."&nbsp; | ";
                                echo "Max Pax: ".$row_Services->MaxPax;
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!-- end of list service -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
