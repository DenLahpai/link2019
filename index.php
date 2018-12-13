<?php
require "conn.php";

function getUsers() {
    $database = new Database();
    $query = "SELECT * FROM Users ;";
    $database->query($query);
    return $r = $database->resultset();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'Welcome';
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <main>
                <!-- login -->
                <div class="login">
                    <form class="login" action="login.php" method="post">
                        <h1>Log in</h1>
                        <input type="text" name="Username" placeholder="Username" autofocus autocomplete="none" required>
                        <input type="password" name="Password" placeholder="Password" required>
                        <button type="submit" name="button_login">Log in</button>
                    </form>
                </div>
                <!-- end of login -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
