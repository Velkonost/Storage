<?php


error_reporting(E_ALL);

define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', 'root');
define('DB', 'storage');
$CONNECT = mysqli_connect(HOST, USER, PASSWORD, DB);
    
    try {
        $listener = new ../dotzero/amocrm/src/Webhooks/Listener();

        // Добавление обработчика на уведомление contacts->add
        $listener->on('add_lead', function ($domain, $id, $data) {
            // $domain Поддомен amoCRM
            // $id Id объекта связанного с уведомлением
            // $data Поля возвращаемые уведомлением
                mysqli_query($CONNECT, "INSERT INTO `things` VALUES ('test2', 'artun3', '1', '1', '1', '1', '1', '1', '1', '1', 'name')");
        });
    
        // Вызов обработчика уведомлений
        $listener->listen();

} catch (\AmoCRM\Exception $e) {
    printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}



