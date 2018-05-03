<?php

$name = $request->get('name', 'World');
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$response->setContent(sprintf('Hello, %s !', $name));
