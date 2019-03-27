<?php
require_once "functions.php";
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
                                <select name="SupplierId">
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
                            <li>
                                <button type="button" name="buttonSubmit" id="buttonSubmit">Submit</button>
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
    </script>
</html>
