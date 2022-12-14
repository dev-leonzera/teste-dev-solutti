<?php 

namespace App\Http\Services;

use App\Models\Produto;

class ProdutoService{

    public function index(){
        return Produto::all();
    }

    public function show($id){
        return Produto::find($id);
    }

    public function store($data){
        return Produto::create($data);
    }

    public function update($id, $data){
        $produto = Produto::find($id);
        return $produto->update($data);
    }

    public function delete($id){
        $produto = Produto::find($id);
        return $produto->delete();
    }
}

?>