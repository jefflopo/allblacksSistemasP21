<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Torcedores;

class TorcedoresController extends Controller
{
    public function index(){
        
        $torcedores = Torcedores::paginate(4);
                
        
        return view('torcedores.index', array('torcedores'=>$torcedores, 'buscar' => null));
        
    }
    
    public function show($id){
        
        $torcedor = Torcedores::find($id);
        return view('torcedores.show', array('torcedor'=>$torcedor));
        
    }
    
    public function create(){
        
        return view('torcedores.create');
    }
    
    public function store(Request $request){
        
        $this->validate($request, [
            'nome' => 'required|min:5',
            'documento' => 'required',
            'cep' => 'numeric',
            'endereco' => 'string',
            'bairro' => 'string',
            'cidade' => 'string',
            'uf' => 'string|min:2|max:2',
            'telefone' => 'string',
            'email' => 'email',
            'ativo' => 'boolean'
        ]);
        
        $torcedor = new Torcedores();
        
        $torcedor->nome = $request->input('nome');
        $torcedor->documento = $request->input('documento');
        $torcedor->cep = $request->input('cep');
        $torcedor->endereco = $request->input('endereco');
        $torcedor->bairro = $request->input('bairro');
        $torcedor->cidade = $request->input('cidade');
        $torcedor->uf = $request->input('uf');
        $torcedor->telefone = $request->input('telefone');
        $torcedor->email = $request->input('email');
        $torcedor->ativo = (!$request->input('ativoCheck'))? 0 : 1;
        
        
        if($torcedor->save()){
            return redirect('torcedores/create')->with('success', 'Torcedor Cadastrado com Sucesso!!');
        }else{
            return redirect('torcedores/create')->with('danger', 'Erro! Torcedor não Cadastrado no sistema!!');
        }
        
    }
    
    public function edit($id){
        
        $torcedor = Torcedores::find($id);
        return view('torcedores.edit', compact('torcedor', 'id'));
        
    }
    
    public function update(Request $request, $id){
        
        $torcedor = Torcedores::find($id);
        
        $this->validate($request, [
            'nome' => 'required|min:5',
            'documento' => 'required',
            'cep' => 'numeric',
            'endereco' => 'string',
            'bairro' => 'string',
            'cidade' => 'string',
            'uf' => 'string|min:2|max:2',
            'telefone' => 'string',
            'email' => 'email',
            'ativo' => 'boolean'
        ]);
        
        $torcedor->nome = $request->get('nome');
        $torcedor->documento = $request->get('documento');
        $torcedor->cep = $request->get('cep');
        $torcedor->endereco = $request->get('endereco');
        $torcedor->bairro = $request->get('bairro');
        $torcedor->cidade = $request->get('cidade');
        $torcedor->uf = $request->get('uf');
        $torcedor->telefone = $request->get('telefone');
        $torcedor->email = $request->get('email');
        $torcedor->ativo = (!$request->get('ativoCheck'))? 0 : 1;
        
        
        if($torcedor->save()){
            return redirect('torcedores/' . $id . '/edit')->with('success', 'Torcedor Atualizado com Sucesso!!');
        }else{
            return redirect('torcedores/' . $id . '/edit')->with('danger', 'Erro! Torcedor não Atualizado no sistema!!');
        }
        
    }
    
    public function destroy($id)
    {
        $torcedor = Torcedores::find($id);
        
        $torcedor->delete();
        return redirect()->back()->with('success', 'Torcedor Deletado com Sucesso do Sistema!!');
    }
    
    public function busca(Request $request){
        
        $buscaInput = $request->input('busca');
        
        $torcedor = Torcedores::where('nome', 'LIKE', '%' . $buscaInput . '%')
                                ->orwhere('documento', 'LIKE', '%' . $buscaInput . '%')
                                ->orwhere('email', 'LIKE', '%' . $buscaInput . '%')
                                ->paginate(4);
        
        return view('torcedores.index', array('torcedores'=>$torcedor, 'buscar' => $buscaInput));
        
    }
}
