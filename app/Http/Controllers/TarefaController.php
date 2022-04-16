<?php

namespace App\Http\Controllers;

use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TarefaController extends Controller
{
    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(): string
    {

        return 'Chegamos até aqui';
//            $id = Auth::user()->id;
//            $nome = Auth::user()->name;
//            $email = Auth::user()->email;
//
//            return "Id: $id | Nome: $nome | Email: $email";

        /*
         * auth()->check() retorna true para usuário autenticado
         * Todos os atributos contidos na tabela users podem ser recuperados através do helper auth
         */
        /*
         * if(auth()->check()) {
               $id = auth()->user()->id;
               $nome = auth()->user()->name;
               $email = auth()->user()->email;
               return "Id: $id | Nome: $nome | Email: $email";
           } else {
               return ('Você não está logado no sistema');
           }
         */

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $tarefa = Tarefa::create($request->all());
        $destinatario = auth()->user()->email; //e-mail do usuário logado (autenticado)
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param Tarefa $tarefa
     * @return View
     */
    public function show(Tarefa $tarefa): View
    {
       return view('tarefa.show', compact('tarefa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tarefa $tarefa
     * @return void
     */
    public function edit(Tarefa $tarefa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Tarefa $tarefa
     * @return void
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tarefa $tarefa
     * @return void
     */
    public function destroy(Tarefa $tarefa)
    {
        //
    }
}
