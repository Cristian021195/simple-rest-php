<?php 
    $_ENV['DB_HOST'] = 'localhost';
    $_ENV['DB_PORT'] = '5432';
    $_ENV['DB_USER'] = 'postgres';
    $_ENV['DB_PASS'] = 'admin';
    $_ENV['DB_NAME'] = 'ejemplo';
    $_ENV['DB_OPT'] = '--client_encoding=UTF8';

    /*
        $this->conn = pg_connect(
        "host='localhost'
        port='5432'
        user='postgres'
        password='admin'
        dbname='ejemplo'
        options='--client_encoding=UTF8'") or die('No pudo conectarse: ' . pg_last_error());
    */
?>