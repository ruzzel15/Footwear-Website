<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'solemates');
define('DB_USER', 'root');       // Change to your MySQL username
define('DB_PASS', '');           // Change to your MySQL password
define('DB_CHARSET', 'utf8mb4');

// public base URL path to the project. adjust if you move the folder
// the workspace is in htdocs/Ecom_Final_Proj/solemates-php
// e.g. http://localhost/Ecom_Final_Proj/solemates-php
//
define('BASE_URL', '/Ecom_Final_Proj/solemates-php/');

function get_db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            die('<div style="font-family:sans-serif;padding:2rem;color:#b91c1c;">
                <h2>Database Connection Error</h2>
                <p>Could not connect to MySQL. Please check your credentials in <code>includes/config.php</code>.</p>
                <p><em>' . htmlspecialchars($e->getMessage()) . '</em></p>
            </div>');
        }
    }
    return $pdo;
}