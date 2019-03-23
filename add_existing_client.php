<?php
require_once "functions.php";
//getting data from the table BookingsId
$BookingsId = trim($_REQUEST['BookingsId']);
if (!is_numeric($BookingsId)) {
    echo "There has been a problem! Please go back and try again!";
    die();
}
$rows_Bookings = table_Bookings ('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // code...
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Bookings_Clients ('check_before_insert', $BookingsId, NULL);
    if ($rowCount == 0) {
        table_Bookings_Clients ('insert_existing_client', $BookingsId, NULL);
    }
    else {
        header("location: booking_clients.php?BookingsId=$BookingsId");
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Add Existing Client";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Existing Clients";
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <!-- report table -->
                <div class="report-list">
                    <ul>
                        <li class="error">
                            <?php
                            if (!empty($error)) {
                                echo $error;
                            }
                            ?>
                        </li>
                        <?php
                        $rows_Clients = table_Clients ('select_all', NULL, NULL);
                        foreach ($rows_Clients as $row_Clients) {
                            echo "<li>";
                            echo "<button onclick=\"openClientModal('modalClient$row_Clients->Id');\">View</button>";
                            echo "&nbsp;".$row_Clients->Title;
                            echo "&nbsp;".$row_Clients->FirstName;
                            echo "&nbsp;".$row_Clients->LastName;
                            echo "&nbsp;| ".$row_Clients->Company;
                            echo "</li>";
                        }
                        ?>
                </div>
                <!-- end of report-list -->
                <!-- modalClients -->
                <div id="modalClients" class="modalClients">
                    <h3 id="modalClose" onclick="modalClose();" title="Close">&times;</h3>
                    <?php

                    foreach ($rows_Clients as $row_Clients) {
                        echo "<!-- modalClient -->";
                        echo "<div id=\"modalClient$row_Clients->Id\" class=\"modalClient\">";
                        echo "<form action=\"#\" method=\"post\">";
                        echo "<ul>";
                        echo "<li><input class=\"invisible\" type=\"number\" name=\"ClientsId\" id=\"ClientsId\" value=\"$row_Clients->Id\"></li>";
                        echo "<li class=\"bold\">".$row_Clients->Title." ".$row_Clients->FirstName." ".$row_Clients->LastName."</li>";
                        echo "<li>Passport: ".$row_Clients->PassportNo."</li>";
                        echo "<li>Passport Expiry: ".$row_Clients->PassportExpiry."</li>";
                        echo "<li>NRC No: ".$row_Clients->NRCNo."</li>";
                        echo "<li>DOB: ".$row_Clients->DOB."</li>";
                        echo "<li>Country: ".$row_Clients->Country."</li>";
                        echo "<li>Frequent Flyers:".$row_Clients->FrequentFlyer."</li>";
                        echo "<li>Company:".$row_Clients->Company."</li>";
                        echo "<li>Phone:".$row_Clients->Phone."</li>";
                        echo "<li>Email:".$row_Clients->Email."</li>";
                        echo "<li>Wedsite:".$row_Clients->Website."</li>";
                        echo "<li><button type=\"submit\">Add to Booking</button></li>";
                        echo "</ul>";
                        echo "</form>";
                        echo "</div>";
                        echo "<!-- end of modalClient -->";
                    }
                    ?>
                </div>
                <!-- endo of modalClients -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript">
        var modal = document.getElementById('modalClients');

        //function to open modal
        function openClientModal(modalToOpen) {
            modal.style.display = 'block';
            var modalToOpen = document.getElementById(modalToOpen);
            modalToOpen.style.display = 'block';
        }

        //function to close modal
        function modalClose() {
            modal.style.display = 'none';
        }
    </script>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
