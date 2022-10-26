<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\LojaService;
use App\Http\Resources\LojaResource;
use App\Http\Requests\StoreLojaRequest;
use App\Http\Requests\UpdateLojaRequest;

class LojaController extends Controller
{
    private $lojaService;
    private $storeLojaRequest;
    private $updateLojaRequest;

    public function __construct(LojaService $lojaService){
        $this->lojaService = $lojaService;
    }

    public function index(){
        return LojaResource::collection($this->lojaService->index())->response();
    }

    public function show($id){
        $loja = $this->lojaService->show($id);
        if(!$loja){
            return response()->json(['message' => 'Loja não encontrada'], 400);
        }
        return response()->json($loja, 200);
    }

    public function store(StoreLojaRequest $request){
        $inputs = $request->validated();
        if($inputs){
            $novaLoja = $this->lojaService->create();

            if(!$novaLoja){
                return response()->json(['message' => 'Erro no cadastro da loja. Verifique os dados inseridos!'], 400);
            }
            return response()->json(['message' => 'Loja cadastrada com sucesso!'], 201);
        }
        return response()->json(['message' => 'Erro na validação dos dados. Verifique os dados inseridos!'], 400);
    }

    public function update($id, UpdateStoreRequest $request){
        $loja = $this->lojaService->findLoja($id);
        if(!$loja){
            return response()->json(['message' => 'Loja não encontrada'], 400);
        }

        $updatedLoja = $this->lojaService->update($id, $request->validated());

        if(!$updatedLoja){
            return response()->json(['message' => 'Erro ao atualizar a loja. Verifique os dados inseridos!'], 400);
        }
        return response()->json(['message' => 'Loja atualizada com sucesso!'], 201);
    }

    public function destroy($id){
        $loja = $this->lojaService->findLoja($id);
        if(!$loja){
            return response()->json(['message' => 'Loja não encontrada'], 400);
        }

        return response()->json(['message' => 'Loja removida com sucesso!'], 204);
    }
}
