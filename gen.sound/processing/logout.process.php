<?php
session_start();
session_destroy();

// Мы в папке processing, выходим в корень
header("Location: ../index.php");

exit();