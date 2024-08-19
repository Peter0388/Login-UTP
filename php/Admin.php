
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/jam-icons/css/jam.min.css">
    <link rel="stylesheet" href="../css/home.css">
    <title>UTP</title>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">UTP Administración</div>
            <div class="navbar-menu" id="navbar-menu">
                <!-- <a href="#">Inicio</a> -->
                <!-- <a href="#">Perfil</a> -->
                <?php
                    session_start();
                    if (isset($_SESSION['username'])) {
                        echo '
                            <div>
                                <div>
                                    <span class="text-body"> Bienvenido, <strong>' . $_SESSION['username'] . '</strong> </span>
                                </div>
                                <div>
                                    <span class="text-body rol"> Rol: ' . $_SESSION['role'] . '</span>
                                </div>
                            </div>';
                    }
                ?>
                <button class="btn-cerrar-sesion" onclick="handleLogout()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 0.5rem;">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Cerrar Sesión
                </button>
            </div>
            <button class="navbar-toggle" id="navbar-toggle">
                <span class="jam jam-menu"></span>
            </button>
        </div> 
    </nav>

    <script src="../js/scripts.js"></script>
</body>
</html>