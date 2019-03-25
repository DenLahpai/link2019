<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Services";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Services";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <div class="form">
                    <ul>
                        <li>
                            Service Type:
                            <select id="type" name="type" onchange="selectType();">
                                <option value="">Select One</option>
                                <?php
                                $rows_ServiceType = table_ServiceType ('select', NULL, NULL);
                                foreach ($rows_ServiceType as $row_ServiceType) {
                                    echo "<option value=\"$row_ServiceType->Id\">".$row_ServiceType->Code."</option>";
                                }
                                ?>
                            </select>
                        </li>
                        <li class="error">
                            <?php
                            if (!empty($error)) {
                                echo $error;
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript">
        function selectType () {
            var type = document.getElementById('type');
            if (type.value == "" || type.value == null) {
                document.getElementsByClassName('error')[0].innerHTML = "Please select a service type!";
            }
            else {
                var typevalue = type.value;
                switch (type.value) {
                    case '1':
                        window.location.href='service_AC.php';
                        break;
                    case  '2':
                        window.location.href='service_FL.php';
                        break;
                    case '3':
                        window.location.href='service_LT.php';
                        break;
                    case '4':
                        window.location.href='service_BO.php';
                        break;
                    default:
                }
            }
        }
    </script>
</html>
