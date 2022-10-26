<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ProdutoService;
use App\Http\Resources\ProdutoResource;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;

class ProdutoController extends Controller
{
    private $produtoService;

    public function __construct(ProdutoService $produtoService){
        $this->produtoService = $produtoService;
    }

    public function index(){
        return ProdutoResource::collection($this->produtoService->index());
    }

    public function show($id){
        $produto = $this->produtoService->show($id);
        if(!$produto){
            return response()->json(['message' => 'Produto não encontrado'], 400);
        }
        return response()->json($produto, 200);
    }

    public function store(StoreProdutoRequest $request){
        $data = $request->validated();

        $novoProduto = $this->produtoService->create($data);
        if($novoProduto){
            $dadosEmail = [
                'nome' => $data['nome'],
                'valor' => $data['valor'],
                'loja_id' => $data['loja_id'],
                'ativo' => $data['ativo']
            ];
            try {
                Mail::to('insira o email aqui')->send(new ProdutoNotificationMail($dadosEmail));
            } catch (\Exception $e){
                return response($e->getMessage(), 422);
            }
            
            return response()->json(['message' => 'Produto cadastrado com sucesso!'], 201);
        }
        
        return response()->json(['message' => 'Erro no cadastro do produto. Verifique os dados inseridos!'], 400);
    }

    public function update($id, UpdateStoreRequest $request){
        $produto = $this->produtoService->show($id);
        if(!$produto){
            return response()->json(['message' => 'Produto não encontrado'], 400);
        }

        $updatedProduto = $this->produtoService->update($id, $request->validated());

        if($updatedProduto){
            $data = [
                'nome' => $dadosProduto['nome'],
                'valor' => $dadosProduto['valor'],
                'loja_id' => $dadosProduto['loja_id'],
                'ativo' => $dadosProduto['ativo']
            ];
    
            try {
                Mail::to('insira o email aqui')->send(new ProdutoNotificationMail($mailData));
            } catch (\Exception $e){
                return response($e->getMessage(), 422);
            }
    
            return response()->json(['message' => 'Produto atualizado com sucesso!'], 201);
        }
        
        return response()->json(['message' => 'Erro ao atualizar o produto. Verifique os dados inseridos!'], 400);
    }

    public function delete($id){
        $produto = $this->produtoService->show($id);
        if(!$produto){
            return response()->json(['message' => 'Produto não encontrado'], 400);
        }

        return response()->json(['message' => 'Produto removido com sucesso!'], 204);
    }
}
