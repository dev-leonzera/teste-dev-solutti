<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Services\ProdutoService;
use App\Http\Resources\ProdutoResource;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Mail\ProdutoNotificationMail;

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

        $novoProduto = $this->produtoService->store($data);
        if($novoProduto){
            $dadosEmail = [
                'nome' => $data['nome'],
                'valor' => $data['valor'],
                'loja_id' => $data['loja_id'],
                'ativo' => $data['ativo'],
                'tipo' => "create"
            ];
            try {
                Mail::to('leonandrade22@gmail.com')->send(new ProdutoNotificationMail($dadosEmail));
            } catch (\Exception $e){
                return response($e->getMessage(), 422);
            }
            
            return response()->json(['message' => 'Produto cadastrado com sucesso!'], 201);
        }
        
        return response()->json(['message' => 'Erro no cadastro do produto. Verifique os dados inseridos!'], 400);
    }

    public function update($id, UpdateProdutoRequest $request){
        $produto = $this->produtoService->show($id);
        if(!$produto){
            return response()->json(['message' => 'Produto não encontrado'], 400);
        }

        $data = $request->validated();

        $updatedProduto = $this->produtoService->update($id, $data);

        if($updatedProduto){
            $dadosEmail = [
                'nome' => $data['nome'],
                'valor' => $data['valor'],
                'loja_id' => $data['loja_id'],
                'ativo' => $data['ativo'],
                'tipo' => "update"
            ];
    
            try {
                Mail::to('leonandrade22@gmail.com')->send(new ProdutoNotificationMail($dadosEmail));
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

        $this->produtoService->delete($id);

        return response()->json(['message' => 'Produto removido com sucesso!'], 204);
    }
}
