<?php
require_once "functions.php";

//gettint ClientsId
$ClientsId = trim($_REQUEST['ClientsId']);

//getting data from the table Clients
$rows_Clients = table_Clients ('select_one', $ClientsId, NULL);

foreach ($rows_Clients as $row_Clients) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Clients('check_before_update', $ClientsId, NULL);
    if ($rowCount == 0) {
        table_Clients('update_one', $ClientsId, NULL);
    }
    else {
        $error = 'Duplicate Entry!';
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Clients";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Clients";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- Clients form -->
                <div class="clients form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Title:
                                <select name="Title" id="Title">
                                    <?php
                                    switch ($row_Clients->Title) {
                                        case 'Mr.':
                                            echo "<option value=\"Mr.\" selected>Mr.</option>";
                                            echo "<option value=\"Ms.\">Ms.</option>";
                                            echo "<option value=\"Mrs.\">Mrs.</option>";
                                            break;
                                        case 'Ms.':
                                            echo "<option value=\"Mr.\">Mr.</option>";
                                            echo "<option value=\"Ms.\" selected>Ms.</option>";
                                            echo "<option value=\"Mrs.\">Mrs.</option>";
                                            break;
                                        case 'Mrs.':
                                            echo "<option value=\"Mr.\">Mr.</option>";
                                            echo "<option value=\"Ms.\">Ms.</option>";
                                            echo "<option value=\"Mrs.\" selected>Mrs.</option>";
                                            break;
                                        default:
                                            // code...
                                            break;
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                First Name:
                                <input type="text" name="FirstName" id="FirstName" value="<? echo $row_Clients->FirstName; ?>">
                            </li>
                            <li>
                                Last Name:
                                <input type="text" name="LastName" id="LastName" value="<? echo $row_Clients->LastName; ?>">
                            </li>
                            <li>
                                Passport No:
                                <input type="text" name="PassportNo" id="PassportNo" value="<? echo $row_Clients->PassportNo; ?>">
                            </li>
                            <li>
                                Passport Expiry:
                                <input type="date" name="PassportExpiry" id="PassportExpiry" value="<? echo $row_Clients->PassportExpiry; ?>">
                            </li>
                            <li>
                                NRC No:
                                <input type="text" name="NRCNo" id="NRCNo" value="<? echo $row_Clients->NRCNo; ?>">
                            </li>
                            <li>
                                DOB:
                                <input type="date" name="DOB" id="DOB" value="<? echo $row_Clients->DOB; ?>">
                            </li>
                            <li>
                                Country:
                                <input type="text" name="Country" id="Country" value="<? echo $row_Clients->Country; ?>">
                            </li>
                            <li>
                                Frequent Flyer:
                                <input type="text" name="FrequentFlyer" id="FrequentFlyer" value="<? echo $row_Clients->FrequentFlyer; ?>">
                            </li>
                            <li>
                                Company:
                                <input type="text" name="Company" id="Company" value="<? echo $row_Clients->Company; ?>">
                            </li>
                            <li>
                                Phone:
                                <input type="text" name="Phone" id="Phone" value="<? echo $row_Clients->Phone; ?>">
                            </li>
                            <li>
                                Email:
                                <input type="text" name="Email" id="Email" value="<? echo $row_Clients->Email; ?>">
                            </li>
                            <li>
                                Website:
                                <input type="text" name="Website" id="Website" value="<? echo $row_Clients->Website; ?>">
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
