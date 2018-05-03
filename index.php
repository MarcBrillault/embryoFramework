<?php
header('Content-Type: text/html; charset=utf-8');

$name = $_GET['name'] ?: 'World';

printf('Hello, %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));