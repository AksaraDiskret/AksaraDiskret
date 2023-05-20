<?php session_start();$_SESSION = [];session_unset();session_destroy();setcookie('signin', '', time() - 3600, '/');setcookie('secret', '', time() - 3600, '/');header("Location: ../");
