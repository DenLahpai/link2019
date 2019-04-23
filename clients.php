<?php
require_once "functions.php";

//getting data from the table Clients
$rows_Clients = table_Clients ('select_all', NULL, NULL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Clients ('check_before_insert', NULL, NULL);
    if ($rowCount == 0) {
        table_Clients ('insert', NULL, NULL);
    }
    else {
        $error = "Duplicate entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Clients";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
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
                                <input type="text" name="LastName" id="LastName" placeholder="Last Name or Family Name">
                            </li>
                            <li>
                                Passport No:
                                <input type="text" name="PassportNo" id="PassportNo" placeholder="Passport Number">
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
                                <input type="text" name="FrequentFlyer" id="FrequentFlyer" placeholder="Frequent Flyer Card No">
                            </li>
                            <li>
                                Company:
                                <input type="text" name="Company" id="Company" placeholder="Company Name">
                            </li>
                            <li>
                                Phone:
                                <input type="text" name="Phone" id="Phone">
                            </li>
                            <li>
                                Email:
                                <input type="email" name="Email" id="Email" placeholder="email@email.com">
                            </li>
                            <li>
                                Website:
                                <input type="text" name="Website" id="Website" placeholder="www.website.com">
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
                <!-- end of clients form -->
                <!-- report table -->
                <div class="report-list">
                    <ul>
                        <?php
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
                        echo "<ul>";
                        // echo "<h3 id=\"modalClose\" onclick=\"modalClose();\">&times;</h3>";
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
                        echo "<li><button onclick=\"window.location.href='edit_clients.php?ClientsId=$row_Clients->Id'\">Edit</button></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of modalClient -->";
                    }
                    ?>
                </div>
                <!-- endo of modalClients -->
            </main>
        </div>
        <!-- end of content -->
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
