<?php
session_destroy();
session_unset();
header("Location: ../views/login.php");
exit;