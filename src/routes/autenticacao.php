<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Produto;
use App\Models\Usuario;
use \Firebase\JWT\JWT;


// Rotas para geração de token
$app->post('/api/token', function(Request $request, Response $response){

	$dadosEmail = $request->getHeader('email');
	$dadosSenha = $request->getHeader('senha');

	$email = $dadosEmail[0] ?? null;
	$senha = $dadosSenha[0] ?? null;
	
	$usuario = Usuario::where('email', $email)->first();

	if( !is_null($usuario) && (md5($senha) === $usuario->senha ) ){

		//gerar token
		$secretKey   = $this->get('settings')['secretKey'];
		$chaveAcesso = JWT::encode([$usuario], $secretKey,'HS256');

		return $response->withJson([
			'chave' => $chaveAcesso
		]);

	}

	return $response->withJson([
		'status' => 'erro'
	]);

});
