<?php

use App\Exceptions\Exc404;
use App\Router;

require_once('vendor/autoload.php');

$dotenv = new Dotenv\Dotenv($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

const BASE_URL = '/index';
const BASE_SPACE = '\App';
const CONTROLLERS_SPACE = '\Controllers\\';
const MODELS_SPACE = '\Models\\';
const SESSION_TIMEOUT = 3600 ; //seconds
define("DB_DRIVER", getenv('DATABASE'));
define("DB_HOST", getenv('MYSQL_HOST'));
define("DB_NAME", getenv('MYSQL_DATABASE'));
define("DB_USER", getenv('MYSQL_USER'));
define("DB_PASS", getenv('MYSQL_PASSWORD'));

try {
    Router::start();
} catch (Exc404 $e) {
    echo 'Ошибка 404. Старница не найдена';
}