<?php
require_once "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //TODO function to insert
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Service Hotel";
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
            $header = "New Service: Hotel";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- hotel form -->
                <div class="hotel form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Supplier:
                                <select name="SupplierId" id="SupplierId">
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
                                Room Type:
                                <input type="text" name="Service" id="Service" required>
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
                                Currency:
                                <select name="currency" id="currency" onchange="selectCurrency();">
                                    <option value="">Select One</option>
                                    <option value="USD">USD</option>
                                    <option value="MMK">MMK</option>
                                </select>
                            </li>
                            <li class="bold">
                                Cost for Double / Twin Room
                            </li>
                            <li class="USD">
                                USD: <input type="number" name="Cost1_USD" id="Cost1_USD" step="0.01">
                            </li>
                            <li class="MMK">
                                MMK: <input type="number" name="Cost1_MMK" id="Cost1_MMK">
                            </li>
                            <li class="bold">
                                Cost for Single Room
                            </li>
                            <li class="USD">
                                USD: <input type="number" name="Cost2_USD" id="Cost2_USD" step="0.01">
                            </li>
                            <li class="MMK">
                                MMK: <input type="number" name="Cost2_MMK" id="Cost2_MMK">
                            </li>
                            <li class="bold">
                                Cost for Triple Room
                            </li>
                            <li class="USD">
                                USD: <input type="number" name="Cost3_USD" id="Cost3_USD" step="0.01">
                            </li>
                            <li class="MMK">
                                MMK: <input type="number" name="Cost3_MMK" id="Cost3_MMK">
                            </li>
                            <li class="error">
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </li>
                            <li>
                                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="insertServiceHotel();">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of hotel form -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript">
        var currency = document.getElementById('currency');
        var USD = document.getElementsByClassName('USD');
        var MMK = document.getElementsByClassName('MMK');

        // function to display selected Currency
        function selectCurrency() {
            if (currency.value === 'USD') {
                var m = 0;
                var u = 0;
                //showing the USD
                while (u < USD.length) {
                    USD[u].style.display = 'block';
                    u++;
                }
                //hiding the MMK
                while (m < MMK.length) {
                    MMK[m].style.display = 'none';
                    m++;
                }
            }
            else if (currency.value === 'MMK') {
                var m = 0;
                var u = 0;
                // showing the MMK
                while (m < MMK.length) {
                    MMK[m].style.display = 'block';
                    m++;
                }
                //hiding the USD
                while (u < USD.length) {
                    USD[u].style.display = 'none';
                    u++;
                }
            }
            else {
                var m = 0;
                var u = 0;
                //hiding the USD
                while (u < USD.length) {
                    USD[u].style.display = 'none';
                    u++;
                }
                //hiding the MMK
                while (m < MMK.length) {
                    MMK[m].style.display = 'none';
                    m++;
                }
            }
        }

        //function to check empty field and submit the form
        function insertServiceHotel () {
            var SupplierId = document.getElementById('SupplierId');
            var Service = document.getElementById('Service');
            var StartDate = document.getElementById('StartDate');
            var EndDate = document.getElementById('EndDate');
            var Cost1_USD = document.getElementById('Cost1_USD');
            var Cost1_MMK = document.getElementById('Cost1_MMK');
            var Cost2_USD = document.getElementById('Cost2_USD');
            var Cost2_MMK = document.getElementById('Cost2_MMK');
            var Cost3_USD = document.getElementById('Cost3_USD');
            var Cost3_MMK = document.getElementById('Cost3_MMK');
            var error = 0;

            if (SupplierId.value == "" || SupplierId.value == null) {
                SupplierId.style.background = 'red';
                error = 1;
            }
            if (Service.value == "" || Service.value == null) {
                Service.style.background = 'red';
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
            if (currency.value == "" || currency.value == null) {
                currency.style.background = 'red';
                error = 1;
            }
            if (currency.value == 'USD') {
                if (Cost1_USD.value == "" || Cost1_USD == null) {
                    Cost1_USD.style.background = 'red';
                    error = 1;
                }
                if (Cost2_USD.value == "" || Cost2_USD == null) {
                    Cost2_USD.style.background = 'red';
                    error = 1;
                }
                if (Cost3_USD.value == "" || Cost3_USD == null) {
                    Cost3_USD.style.background = 'red';
                    error = 1;
                }
            }
            if (currency.value == "MMK") {
                if (Cost1_MMK.value == "" || Cost1_MMK.value == null) {
                    Cost1_MMK.style.background = 'red';
                    error = 1;
                }
                if (Cost2_MMK.value == "" || Cost2_MMK.value == null) {
                    Cost2_MMK.style.background = 'red';
                    error = 1;
                }
                if (Cost3_MMK.value == "" || Cost3_MMK.value == null) {
                    Cost3_MMK.style.background = 'red';
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
