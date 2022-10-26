<?php 

namespace App\Http\Services;

use App\Models\Loja;

class LojaService{

    public function index(){
        return Loja::all();
    }

    public function findLoja($id){
        return Loja::find($id);
    }

    public function show($id){
        return Loja::with(['produtos'])->find($id);
    }

    public function store($data){
        return Loja::create($data);
    }

    public function update($id, $data){
        $loja = Loja::find($id);
        return $loja->update($request->all());
    }

    public function destroy($id){
        $loja = Loja::find($id);
        return $loja->delete();
    }
}

?>