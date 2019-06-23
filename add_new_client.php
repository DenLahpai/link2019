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

//adding Clients to the table Clients and then adding it to the table Booking_Clients
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Clients ('check_before_insert', NULL, NULL);
    if ($rowCount == 0) {
        table_Clients ('insert', NULL, NULL);
        // TODO review required
        // $rows_newClients = table_Bookings_Clients ('get_new_client', NULL, NULL);
        // foreach ($rows_newClients as $row_newClients) {
        //     // code...
        // }
        // table_Bookings_Clients ('insert', $BookingsId, $row_newClients->Id);
    }
    else {
        $error = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Add New Client";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Client";
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <!-- Clients form -->
                <div class="Clients form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Title:
                                <select id="Title" name="Title">
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mrs.">Mrs.</option>
                                </select>
                            </li>
                            <li>
                                First Name:
                                <input type="text" name="FirstName" id="FirstName" placeholder="First Name">
                            </li>
                            <li>
                                Last Name:
                                <input type="text" name="LastName" id="LastName" placeholder="Last Name">
                            </li>
                            <li>
                                Passport No:
                                <input type="text" name="PassportNo" id="PassportNo" placeholder="Passport Nos">
                            </li>
                            <li>
                                Passport Expiry:
                                <input type="date" name="PassportExpiry" id="PassportExpiry">
                            </li>
                            <li>
                                NRC No:
                                <input type="text" name="NRCNo" id="NRCNo" placeholder="NRC No">
                            </li>
                            <li>
                                DOB:
                                <input type="date" name="DOB" id="DOB">
                            </li>
                            <li>
                                Country:
                                <input type="text" name="Country" id="Country" value="Myanmar">
                            </li>
                            <li>
                                Frequent Flyer:
                                <input type="text" name="FrequentFlyer" id="FrequentFlyer" placeholder="Frequent Flyer Numbers">
                            </li>
                            <li>
                                Company:
                                <input type="text" name="Company" id="Company" placeholder="Company Name">
                            </li>
                            <li>
                                Phone:
                                <input type="text" name="Phone" id="Phone" placeholder="Phone Number">
                            </li>
                            <li>
                                Email:
                                <input type="text" name="Email" id="Email" placeholder="Email">
                            </li>
                            <li>
                                Website:
                                <input type="text" name="Website" id="Website" placeholder="Website">
                            </li>
                            <li class="error">
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </li>
                            <li>
                                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkThreeFields('FirstName', 'Title', 'Country')">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of Clients form -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
