<?php 
    require dirname(__FILE__) . '/config.php';
    require dirname(__FILE__) . '/function.php';
    require dirname(__FILE__) . '/alert.php';
    require dirname(__FILE__) . '/user.php';

    // api with arrow function
    $api = (object) array(
        'sql' => new PDO('mysql:host=' . $config['db_host'] . '; dbname=' . $config['db_database'] . ';', $config['db_user'], $config['db_password']),
        'alert' => new Alert(),
        'user' => new User(),
        
    );
    
    // charset utf8
    $api->sql->exec('set names utf8');
?>
