<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Admin";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = $page_title;
            include "includes/header.html";
            ?>
            <main>
                <!-- links -->
                <div class="links">
                    <ul>
                        <li>
                            <a href="countries.php">Countries</a>
                        </li>
                        <li>
                            <a href="cities.php">Cities</a>
                        </li>
                        <li>
                            <a href="suppliers.php">Suppliers</a>
                        </li>
                    </ul>
                </div>
                <!-- end of links -->
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
