<?php
require_once "functions.php";

//getting data from the table Clients
$rows_Clients = table_Clients ('select_all', NULL, NULL);
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
                                <select name="Title">
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
                        </ul>
                    </form>
                </div>
                <!-- end of clients form -->
            </main>

        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
