<?php
require_once "functions.php";

//getting SuppliersId
$SuppliersId = trim($_REQUEST['SuppliersId']);

//getting data from the table Suppliers
$rows_Suppliers = table_Suppliers ('select_one', $SuppliersId, NULL);
foreach ($rows_Suppliers as $row_Suppliers) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Suppliers ('check_before_update', $SuppliersId, NULL);

    if ($rowCount == 0) {
        table_Suppliers ('update', $SuppliersId, NULL);
    }
    else {
        $error = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'Edit Suppliers';
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class=$error = "Duplicate Entry!";"content">
            <?php
            $header = $page_title;
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- Suppliers form -->
                <div class="Suppliers form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Supplier Name:
                                <input type="text" name="Name" id="Name" value="<? echo $row_Suppliers->Name; ?>">
                            </li>
                            <li>
                                Address:
                                <input type="text" name="Address" id="Address" value="<? echo $row_Suppliers->Address; ?>">
                            </li>
                            <li>
                                City:
                                <input type="text" name="City" id="City" value="<? echo $row_Suppliers->City; ?>">
                            </li>
                            <li>
                                Email:
                                <input type="email" name="Email" id="Email" value="<? echo $row_Suppliers->Email; ?>">
                            </li>
                            <li>
                                Phone:
                                <input type="text" name="Phone" id="Phone" value="<? echo $row_Suppliers->Phone; ?>">
                            </li>
                            <li>
                                Fax:
                                <input type="text" name="Fax" id="Fax" value="<? echo $row_Suppliers->Fax; ?>">
                            </li>
                            <li>
                                Website:
                                <input type="text" name="Website" id="Website" value="<? echo $row_Suppliers->Website; ?>">
                            </li>
                            <li class="error">
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </li>
                            <li>
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Name', 'City', 'Phone');">Update</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of Suppliers form -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
