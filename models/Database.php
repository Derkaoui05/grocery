<?php

class Connection
{
    public static function Connect()
    {
        $envPath = __DIR__ . '/.env';
        $contenu_env = file($envPath);
        $server = trim(explode(":", $contenu_env[0])[1]);
        $user = trim(explode(":", $contenu_env[1])[1]);
        $password = trim(explode(":", $contenu_env[2])[1]);
        $db_name = trim(explode(":", $contenu_env[3])[1]);
        $pdo = new PDO('mysql:host=' . $server . '; dbname=' . $db_name, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}