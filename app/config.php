<?php


chdir(dirname(__DIR__));
// Config Loader
\F3::instance()->config("config.ini");

//load app 
\F3::instance()->set('AUTOLOAD', 'app/');

//connect to SQL Database.
\F3::set('SYSTEM.DB', false);
if (\F3::instance()->exists('database')) {
    try {
        \F3::set(
            'DB',
            new \DB\SQL(
                \F3::get('database.dsn'),
                \F3::get('database.username'),
                \F3::get('database.password'),
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                ]
            )
        );
        \F3::set('SYSTEM.DB', true);
    } catch (\PDOException $e) {
        \F3::set('DB', null);
    }
}

    // \Chez14\Ilgar\Boot::now();