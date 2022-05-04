<div class="sidebar" data-color="blue" data-image="assets/img/sidebar-5.jpg">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a class="simple-text">
                <?php 
                    echo $_SESSION['usr'];
                ?>
            </a>
        </div>
        <ul class="nav">
            <li>
                <a href="ventas.php">
                    <i class="pe-7s-news-paper"></i>
                    <p>Ventas</p>
                </a>
            </li>
            <li>
                <a href="reembolso.php">
                    <i class="pe-7s-news-paper"></i>
                    <p>Reembolsos</p>
                </a>
            </li>
            <?php 
                if($_SESSION['tipo']==1){
                    ?>
                        <li>
                            <a href="productos.php">
                                <i class="pe-7s-note2"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        <li>
                            <a href="usuarios.php">
                                <i class="pe-7s-user"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                    <?php 
                }
            ?>
            <li>
                <a href="reporte.php">
                    <i class="pe-7s-graph"></i>
                    <p>Reportes de Venta</p>
                </a>
            </li>
            <li>
                <!-- <a href="../session/login/cerrar.php"> -->
                <a onclick="limpiarNavegador()">
                    <i class="pe-7s-science"></i>
                    <p>Salir</p>
                </a>
            </li>
            <!-- <li>
                <a href="maps.html">
                    <i class="pe-7s-map-marker"></i>
                    <p>Maps</p>
                </a>
            </li>
            <li>
                <a href="notifications.html">
                    <i class="pe-7s-bell"></i>
                    <p>Notifications</p>
                </a>
            </li> -->
            <li class="active-pro">
                <!-- <a href="upgrade.html">
                    <i class="pe-7s-rocket"></i>
                    <p>Upgrade to PRO</p>
                </a> -->
            </li>
        </ul>
    </div>
</div>

<script>
    function limpiarNavegador() {
        localStorage.removeItem('tabla');
        localStorage.removeItem('tabla_reembolso');
        location.href = "../session/login/cerrar.php";
    }
</script>