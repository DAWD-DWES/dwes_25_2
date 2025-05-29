<?php

/**
 *  --- Lógica del script --- 
 * 
 * Establece conexión a la base de datos PDO
 * Si el usuario ya está validado
 *   Si se solicita cerrar la sesión
 *     Destruyo la sesión
 *     Invoco la vista del formulario de login
 *    Sino redirección a juego para jugar una partida
 *  Si no 
 *   Si se pide procesar los datos del formulario
 *       Lee los valores del formulario
 *       Si los credenciales son correctos
 *       Redirijo al cliente al script de juego con una nueva partida
 *        Sino Invoco la vista del formulario de login con el flag de error
 *   Si no (En cualquier otro caso)
 *      Invoco la vista del formulario de login
 */
require "../vendor/autoload.php";
require "../src/error_handler.php";

use eftec\bladeone\BladeOne;
use App\BD\BD;
use App\Modelo\Usuario;
use App\DAO\UsuarioDAO;
use App\Modelo\Nivel;

session_start();

// Funciones de validación de datos del formulario de registro
// Validación del nombre con expresión regular
function esNombreValido(string $nombre): bool {
    return preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,15}$/", $nombre);
}

// 
function esPasswordValido(string $clave): bool {
    return preg_match('/^(?=.*\d).{6,}$/', $clave);
}

function esEmailValido(string $email): bool {
    return empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL));
}

// Inicializa el acceso a las variables de entorno

$vistas = __DIR__ . '/../vistas';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($vistas, $cache, BladeOne::MODE_DEBUG);

// Establece conexión a la base de datos PDO
try {
    $bd = BD::getConexion();
} catch (Exception $error) {
    echo $blade->run("cnxbderror", compact('error'));
    die;
}

$usuarioDAO = new UsuarioDAO($bd);
// Si el usuario ya está validado
if (isset($_SESSION['usuario'])) {
// Si se solicita cerrar la sesión
    if (filter_has_var(INPUT_GET, 'botonlogout')) {
// Destruyo la sesión
        session_unset();
        session_destroy();
        setcookie(session_name(), '', 0, '/');
// Invoco la vista del formulario de login
        echo $blade->run("formlogin");
    } elseif (filter_has_var(INPUT_GET, 'botonperfil')) {
        $usuario = $_SESSION['usuario'];
        $nivelOpciones = array_map(fn($nivel) => $nivel->value, Nivel::cases());
        echo $blade->run("formperfil", ['usuario' => $usuario, 'nivelOpciones' => $nivelOpciones,
            'nombre' => $usuario->getNombre(), 'clave' => $usuario->getClave(), 'email' => $usuario->getEmail(),
            'nivel' => $usuario->getNivel()]);
    } elseif (filter_has_var(INPUT_POST, 'botonprocperfil')) {
        $usuario = $_SESSION['usuario'];
        $nivelOpciones = array_map(fn($nivel) => $nivel->value, Nivel::cases());
        $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW));
        $clave = trim(filter_input(INPUT_POST, 'clave', FILTER_UNSAFE_RAW));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW));
        $nivel = trim(filter_input(INPUT_POST, 'nivel', FILTER_UNSAFE_RAW));
        $errorNombre = empty($nombre) || !esNombreValido($nombre);
        $errorPassword = empty($clave) || !esPasswordValido($clave);
        $errorEmail = empty($email) || !esEmailValido($email);
        if ($errorNombre || $errorPassword || $errorEmail) {
            echo $blade->run("formperfil", compact('usuario', 'nivelOpciones', 'nombre', 'clave', 'email', 'nivel', 'errorNombre', 'errorPassword', 'errorEmail'));
        } else {
            $usuario->setNombre($nombre);
            $usuario->setClave($clave);
            $usuario->setEmail($email);
            $usuario->setNivel($nivel);
            $_SESSION['usuario'] = $usuario;
            try {
                $usuarioDAO->modifica($usuario);
                $perfilModificado = true;
                echo $blade->run("formperfil", compact('usuario', 'perfilModificado', 'nivelOpciones', 'nombre', 'clave', 'email', 'nivel', 'errorNombre', 'errorPassword', 'errorEmail'));
            } catch (PDOException $e) {
                $perfilModificado = false;
                echo $blade->run("formperfil", compact('usuario', 'perfilModificado', 'nivelOpciones', 'nombre', 'clave', 'email', 'nivel', 'errorNombre', 'errorPassword', 'errorEmail'));
            }
        }
    } elseif (isset($_SESSION['partida'])) {
        header("Location:juego.php");
        die;
    } else {
// Redirijo al cliente al script de gestión del juego
        header("Location:juego.php?botonnuevapartida");
        die;
    }

// Sino 
} else {
    if (filter_has_var(INPUT_POST, 'botonproclogin')) {
// Lee los valores del formulario
        $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW));
        $clave = trim(filter_input(INPUT_POST, 'clave', FILTER_UNSAFE_RAW));
        $usuario = $usuarioDAO->recuperaPorCredencial($nombre, $clave);
// Si los credenciales son correctos
        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
// Redirijo al cliente al script de juego con una nueva partida
            header("Location:juego.php?botonnuevapartida");
            die;
        }
// Si los credenciales son incorrectos
        else {
// Invoco la vista del formulario de login con el flag de error activado
            echo $blade->run("formlogin", ['error' => true]);
        }
// En cualquier otro caso
    } else {
// Invoco la vista del formulario de login
        echo $blade->run("formlogin");
    }
}