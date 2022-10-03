<?php
// Routes
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Produto;



$app->group('/api/v1', function() {

    // $this->get('/produtos/lista' , function($request, $response) {
    //     $produto = Produto::get();
    //     return $response->withJson([$produto]);
    // });

    $this->get('/produtos/lista[/{id}]' , function($request, $response, $args) {
       if(empty($args))
       {
           $produto = Produto::get();
           return $response->withJson([$produto]);
       }
       else
       {
            try{
                $produto = Produto::findOrFail($args['id']);
                return $response->withJson([$produto]);
            }catch(\Exception $e)
            {
                echo 'Produto nao encontrado.';
            };
       }
    });

    $this->post('/produtos/adiciona' , function($request, $response) {
        $dados = $request->getParsedBody();
        $produto = Produto::create($dados);
        return $response->withJson([$produto]);
    });

    $this->put('/produtos/atualiza[/{id}]' , function($request, $response,$args) {
        if(empty($args))
        {
            echo '<br><br>Lista de produtos : <pre>';
            $produto = Produto::get();
            return $response->withJson([$produto]);
        }
        else
        {
                try{
                    $produto = Produto::findOrFail($args['id']);
                    $dados = $request->getParsedBody();
                    $produto->update($dados);
                    echo '<br><br>Produto alterado com sucesso.';
                    return $response->withJson([$produto]);
                }catch(\Exception $e)
                {
                    echo 'Produto nao encontrado.';
                };
        }

    });

    $this->get('/produtos/remove[/{id}]' , function($request, $response,$args) {
        if(empty($args))
        {
            echo ' Lista de produtos : ';
            $produto = Produto::get();
            return $response->withJson([$produto]);
        }
        else
        {
                try{
                    $produto = Produto::findOrFail($args['id']);
                    echo ' Produto deletado.';
                    $produto->delete();
                    return $response->withJson([$produto]);
                }catch(\Exception $e)
                {
                    echo ' Produto nao encontrado.';
                };
        }
    });

});