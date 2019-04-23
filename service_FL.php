<?php
require_once "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Services ('check_before_insert_FL', NULL, NULL);

    if ($rowCount == 0) {
        table_Services ('insert_FL', NULL, NULL);
    }
    else {
        $error = 'Duplicate entry!';
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Service Flight";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Serivce: Flight";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- flight form -->
                <div class="flight form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Airline:
                                <select id="SupplierId" name="SupplierId">
                                    <option value="">Select One</option>
                                    <?php
                                    $rows_Suppliers = table_Suppliers ('select', NULL, NULL);
                                    foreach ($rows_Suppliers as $row_Suppliers) {
                                        echo "<option value=\"$row_Suppliers->Id\">".$row_Suppliers->Name."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Sector:
                                <input type="text" name="Service" id="Service" value="Manual Entry" readonly>
                            </li>
                            <li>
                                Valid From:
                                <input type="date" name="StartDate" id="StartDate" required>
                            </li>
                            <li>
                                Valid Until:
                                <input type="date" name="EndDate" id="EndDate" required>
                            </li>
                            <li>
                                Note: The cost would have to be entered manually in booking.
                            </li>
                            <li class="error">
                                <?php if (!empty($error)) { echo $error ;} ?>
                            </li>
                            <li>
                                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="insertServiceFlight();">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of flight form -->
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_Services = table_Services ('select_all', 2, NULL);
                    foreach ($rows_Services as $row_Services) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li class=\"bold\">".$row_Services->SuppliersName."</li>";
                        echo "<li>".$row_Services->Service."</li>";
                        echo "<li>Valid From:".date("d-M-Y", strtotime($row_Services->StartDate))."</li>";
                        echo "<li>Valid Until:".date("d-M-Y", strtotime($row_Services->EndDate))."</li>";
                        echo "<li><a href=\"edit_services.php?ServicesId=$row_Services->ServicesId\">Edit</a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid item -->";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scritps.js"></script>
    <script type="text/javascript">
        //function to insert Service flight
        function insertServiceFlight () {
            var SupplierId = document.getElementById('SupplierId');
            var StartDate = document.getElementById('StartDate');
            var EndDate = document.getElementById('EndDate');
            var error = 0;

            if (SupplierId.value === null || SupplierId.value === "") {
                SupplierId.style.background = 'red';
                error = 1;
            }

            if (StartDate.value == "" || StartDate.value == null) {
                StartDate.style.background = 'red';
                error = 1;
            }

            if (EndDate.value == "" || EndDate.value == null) {
                EndDate.style.background = 'red';
                error = 1;
            }

            if (StartDate.value > EndDate.value) {
                error = 2;
                StartDate.style.background = 'brown';
                EndDate.style.background = 'brown';
            }

            if (error == 1) {
                document.getElementsByClassName('error')[0].innerHTML = 'Please fill out all the filed(s) in red!';
            }
            else if (error == 2) {
                document.getElementsByClassName('error')[0].innerHTML = 'The date in the field Valid From cannot be later than the date in the field Valid Until!';
            }
            else if (error == 0) {
                document.getElementById('buttonSubmit').type = 'submit';
            }
            else {
                document.getElementsByClassName('error')[0].innerHTML = 'Please contact the developer!';
            }
        }
    </script>
</html>
