<?php

use Illuminate\Support\Facades\Schema;
use Slim\Handlers\NotFound;

if (PHP_SAPI != 'cli') {
    exit('Rodar via CLI');
}

require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);
require __DIR__ . '/src/dependencies.php';

$db = $container->get('db');
$schema = $db->schema();

$tabela = 'produtos';

$schema->dropIfExists( $tabela );
$schema->create($tabela, function($table) {
    $table->increments('id');
    $table->string('titulo',100); // nome da variavel no bd e tamamho
    $table->text('descricao');
    $table->decimal('preco',11,2);
    $table->string('fabricante',60);
    $table->timestamps();
});

$tabela2 = 'usuarios';

$schema->dropIfExists( $tabela2 );
$schema->create($tabela2, function($table2)
{
    $table2->increments('id');
    $table2->string('nome',150);
    $table2->string('email',100);
    $table2->string('senha',32);
});

$hoje = date('Y-m-d');

$db->table($tabela)->insert([
    'titulo' => 'Motorola moto g6',
    'descricao' => 'Android Oreo',
    'preco' => 899.00,
    'fabricante' => 'motorola',
    'created_at' => '2022-09-21',
    'updated_at' => $hoje]
);

$db->table($tabela)->insert([
    'titulo' => 'Iphone 8',
    'descricao' => 'Ios',
    'preco' => 1799.00,
    'fabricante' => 'apple',
    'created_at' => '2022-08-21',
    'updated_at' => $hoje]
);

$db->table($tabela2)->insert([
    'nome' => 'Adriano',
    'email' => 'adriano.ocf@hotmail.com',
    'senha' => md5('123456')]
);