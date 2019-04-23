<?php
require_once "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checking for duplicate entry
    $rowCount = table_Services ('check_before_insert_LT', NULL, NULL);
    if ($rowCount == 0) {
        table_Services ('insert_LT', NULL, NULL);
    }
    else {
        $error = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Service Land Transfer";
    include "includes/head.html";
    ?>
    <style media="screen">
        .MMK {
            display: none;
        }
        .USD {
            display: none;
        }
    </style>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Service: Land Tranfer";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- land transfer form -->
                <div class="land-transfer form">
                    <form  action="#" method="post">
                        <ul>
                            <li>
                                Supplier:
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
                                Service:
                                <input type="text" name="Service" id="Service" placeholder="Route">
                            </li>
                            <li>
                                Vehicle Type:
                                <input type="text" name="Additional" id="Additional" placeholder="Saloon / Hi-ace/ bus">
                            </li>
                            <li>
                                Valid From:
                                <input type="date" name="StartDate" id="StartDate">
                            </li>
                            <li>
                                Valid Until:
                                <input type="date" name="EndDate" id="EndDate">
                            </li>
                            <li>
                                Max Pax (Capacity):
                                <input type="number" name="MaxPax" id="MaxPax" value="2">
                            </li>
                            <li>
                                <select id="currency" name="currency" onchange="selectCurrency();">
                                    <option value="">Select One</option>
                                    <option value="USD">USD</option>
                                    <option value="MMK">MMK</option>
                                </select>
                            </li>
                            <li class="USD">
                                Cost in USD:
                                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD">
                            </li>
                            <li class="MMK">
                                Cost in MMK:
                                <input type="number" name="Cost1_MMK" id="Cost1_MMK">
                            </li>
                            <li class="error">
                                <?php if (!empty($error)) { echo $error; } ?>
                            </li>
                            <li>
                                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="insertServiceLandTransfer();">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of land transfer form -->
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_Services = table_Services ('select_all', 3, NULL);
                    foreach ($rows_Services as $row_Services) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li class=\"bold\">".$row_Services->SuppliersName."</li>";
                        echo "<li>Service: ".$row_Services->Service."</li>";
                        echo "<li>Vehicle: ".$row_Services->Additional."</li>";
                        echo "<li>Max Pers: ".$row_Services->MaxPax."</li>";
                        echo "<li>Valid From: ".date("d-M-Y", strtotime($row_Services->StartDate))."</li>";
                        echo "<li>Valid Until: ".date("d-M-Y", strtotime($row_Services->EndDate))."</li>";
                        echo "<li><a href=\"edit_services.php?ServicesId=$row_Services->ServicesId\">Edit</a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
    <script type="text/javascript">
        //function to check empty field(s) and submit the form
        function insertServiceLandTransfer () {
            var SupplierId = document.getElementById('SupplierId');
            var Service = document.getElementById('Service');
            var Additional = document.getElementById('Additional');
            var StartDate = document.getElementById('StartDate');
            var EndDate = document.getElementById('EndDate');
            var MaxPax = document.getElementById('MaxPax');
            var Cost1_USD = document.getElementById('Cost1_USD');
            var Cost1_MMK = document.getElementById('Cost1_MMK');
            var currency = document.getElementById('currency');
            var error = 0;

            if (SupplierId.value == "" || SupplierId.value == null) {
                SupplierId.style.background = 'red';
                error = 1;
            }
            if (Service.value == "" || Service.value == null) {
                Service.style.background = 'red';
                error = 1;
            }
            if (Additional.value == "" || Additional.value == null) {
                Additional.style.background = 'red';
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
                StartDate.style.background = 'brown';
                EndDate.style.background = 'brown';
                error = 2;
            }
            if (MaxPax.value == 0 || MaxPax.value == "" || MaxPax.value == null) {
                MaxPax.style.background = 'red';
                error = 1;
            }
            if (currency.value == "" || currency.value == null) {
                currency.style.background = 'red';
                error = 1;
            }
            if (currency.value == 'USD') {
                if (Cost1_USD.value == "" || Cost1_USD.value == null) {
                    Cost1_USD.style.background = 'red';
                    error = 1;
                }
            }
            if (currency.value == 'MMK') {
                if (Cost1_MMK.value == "" || Cost1_MMK.value == null) {
                    Cost1_MMK.style.background = 'red';
                    error = 1;
                }
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
