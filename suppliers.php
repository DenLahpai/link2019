<?php
require_once "functions.php";

//getting data from the table Suppliers
$rows_Suppliers = table_Suppliers ('select', NULL, NULL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checking for duplicate entry
    $rowCount = table_Suppliers ('check', NULL, NULL);

    if ($rowCount == 0) {
        table_Suppliers ('insert', NULL, NULL);
    }
    else {
        $error = "Duplicate Entry!";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Suppliers";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/nav.html";
            include "includes/header.html";
            ?>
            <main>
                <!-- suppliers form -->
                <div class="suppliers form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Supplier Name:
                                <input type="text" name="Name" id="Name" placeholder="Supplier Name">
                            </li>
                            <li>
                                Address:
                                <input type="text" name="Address" id="Address" placeholder="Address">
                            </li>
                            <li>
                                City:
                                <input type="text" name="City" id="City" placeholder="City">
                            </li>
                            <li>
                                Email:
                                <input type="email" name="Email" id="Email" placeholder="email@email.com">
                            </li>
                            <li>
                                Phone:
                                <input type="text" name="Phone" id="Phone" placeholder="+95 9402590317">
                            </li>
                            <li>
                                Fax:
                                <input type="text" name="Fax" id="Fax" placeholder="+ 95 9224001">
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
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Name', 'City', 'Phone');">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of suppliers form -->
                <!-- report table -->
                <div class="report table">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Fax</th>
                                <th>Website</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows_Suppliers as $row_Suppliers) {
                                echo "<tr>";
                                echo "<td>".$row_Suppliers->Name."</td>";
                                echo "<td>".$row_Suppliers->Address."</td>";
                                echo "<td>".$row_Suppliers->City."</td>";
                                echo "<td>".$row_Suppliers->Email."</td>";
                                echo "<td>".$row_Suppliers->Phone."</td>";
                                echo "<td>".$row_Suppliers->Fax."</td>";
                                echo "<td>".$row_Suppliers->Website."</td>";
                                echo "<td><a href=\"edit_suppliers.php?SuppliersId=$row_Suppliers->Id\">Edit</a></td>";
                                echo "<tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of report table -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
