<?php

require_once 'MyLogger.php';
require_once 'PDOAdapter.php';
require_once 'init.php';

$logger = new MyLogger($logFile);
$pdo = new PDOAdapter($dsn, $username, $password, $logger);

$maxAge = $pdo->execute('selectOne', 'select * from person order by age DESC')->age;
$personWihNoMother = $pdo->execute('selectOne', 'select * from person where mother_id IS NULL and age < :age', [':age' => $maxAge]);
$personWihNoMother = $pdo->execute('execute', "update person set age = {$maxAge} where id = {$personWihNoMother->id}");
$personsWithMaxAge = $pdo->execute('selectAll', 'select firstname, lastname, age from person where age = :age ', [':age' => $maxAge]);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="p-3">
        <h2 class="text-center">Инлайн. Тестовое задание. Мошкин Николай</h2>
    </div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Фамилия</th>
            <th scope="col">Имя</th>
            <th scope="col">Возраст</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($personsWithMaxAge as $person): ?>
            <tr>
                <td><?= $person->lastname ?></td>
                <td><?= $person->firstname ?></td>
                <td><?= $person->age ?></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>




