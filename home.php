<?php
require "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Booking";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = "New Booking";
            include "includes/header.html";
            ?>

            <main>
                <!-- booking form -->
                <div class="booking form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Booking Name:
                                <input type="text" name="Name" placeholder="Booking Name" required>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of booking form -->
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
