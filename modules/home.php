<?php
session_start();
if($_SESSION["logueado"]==TRUE){
    // session_destroy();
    ?>
    <!doctype html>
    <html lang="en">
        <?php
            require("head.php");
        ?>
        <div class="wrapper">
            <?php
                require("menu.php");
            ?>
            <div class="main-panel">
                <nav class="navbar navbar-default navbar-fixed">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="#">Inicio</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </html>
<?php
}else{
    header("Location: ../");
}
?>