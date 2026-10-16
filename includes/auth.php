<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';
function require_auth(): void { if (!is_logged_in()) redirect('login.php'); }
