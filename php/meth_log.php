<?php
session_start();

require_once('db_Connect.php');
$db = new ConectarBD();
$conn = $db->getConnection();

// Obtener datos del formulario
$formUsername = $_POST['username'];
$formPassword = $_POST['password'];
$recaptchaResponse = $_POST['g-recaptcha-response'];

// Verificar reCAPTCHA
$secretKey = '6LdFnykqAAAAAEIDDARsitw3AzhkQoCNar9qd74f';
$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
$response = file_get_contents($recaptchaUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
$responseKeys = json_decode($response, true);

if ($responseKeys['success']) {
    // Inicializar intentos fallidos si no están configurados
    if (!isset($_SESSION['attempts'])) {
        $_SESSION['attempts'] = 0;
    }

    // Buscar usuario en la base de datos
    $sql = "SELECT U.cod_usu, U.usuarme AS username, U.password, U.Estado, R.tipo_rol
            FROM tb_usuario U
            LEFT JOIN tb_rol R ON U.idrol = R.idrol
            WHERE U.usuarme = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $formUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar el estado del usuario
        if ($user['Estado'] === 'bloqueado') {
            header("Location: login.php?error=2"); // Usuario bloqueado
            exit();
        }

        // Verificar la contraseña cifrada
        if (password_verify($formPassword, $user['password'])) {
            // Reiniciar el contador de intentos fallidos al iniciar sesión correctamente
            $_SESSION['attempts'] = 0;

            $_SESSION['username'] = $user['username'];
            $_SESSION['cod_usu'] = $user['cod_usu']; // Establecer el código de usuario en la sesión

            // Registrar intento exitoso en auditoría
            $auditSql = "INSERT INTO tb_auditoria (cod_usu, fecha_evento, inicio_sesion) 
                         VALUES (?, NOW(), 'exitoso')";
            $auditStmt = $conn->prepare($auditSql);
            $auditStmt->bind_param("i", $user['cod_usu']);
            $auditStmt->execute();
            $auditStmt->close();

            if ($user['tipo_rol'] == 'Admin') {
                $_SESSION['role'] = 'Admin';
                header("Location: Admin.php");
            } else if ($user['tipo_rol'] == 'Docente') {
                $_SESSION['role'] = 'Docente';
                header("Location: Docente.php");
            } else if ($user['tipo_rol'] == 'Estudiante') {
                $_SESSION['role'] = 'Estudiante';
                header("Location: Estudiante.php");
            }
        } else {
            // Incrementar el contador de intentos fallidos
            $_SESSION['attempts'] += 1;
            
            // Registrar intento fallido en auditoría
            $auditSql = "INSERT INTO tb_auditoria (cod_usu, fecha_evento, inicio_sesion) 
                         VALUES (?, NOW(), 'fallido')";
            $auditStmt = $conn->prepare($auditSql);
            $auditStmt->bind_param("i", $user['cod_usu']);
            $auditStmt->execute();
            $auditStmt->close();

            // Verificar si se alcanzó el límite de intentos
            if ($_SESSION['attempts'] >= 3) {
                // Actualizar el estado del usuario a bloqueado en la base de datos
                $updateSql = "UPDATE tb_usuario SET Estado = 'bloqueado' WHERE cod_usu = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("i", $user['cod_usu']);
                $updateStmt->execute();
                $updateStmt->close();

                // Redirigir con mensaje de error de bloqueo
                header("Location: login.php?error=2");
                exit();
            } else {
                // Redirigir de vuelta al formulario de login con mensaje de error de contraseña incorrecta
                header("Location: login.php?error=1");
                exit();
            }
        }
    } else {
        // Redirigir de vuelta al formulario de login con mensaje de error de usuario no encontrado
        header("Location: login.php?error=1");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirigir de vuelta al formulario de login con mensaje de error de reCAPTCHA fallido
    header("Location: login.php?error=recaptcha");
    exit();
}
?>
