<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExport;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     */
    public function index()
    {
        $user = auth()->user();
        $tarefas = $user->tarefas()->paginate(10);
        return view('tarefa.index', ['tarefas' => $tarefas]);
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
        $dados = $request->all('tarefa', 'data_limite_conclusao');
        $dados['user_id'] = auth()->user()->id;
        $tarefa = Tarefa::create($dados);
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
     * @return View
     */
    public function edit(Tarefa $tarefa): View
    {
        $user_id = auth()->user()->id;

        if ($tarefa->user_id == $user_id) {
            return view('tarefa.edit', compact('tarefa'));
        }

        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Tarefa $tarefa
     * @return View|RedirectResponse
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        if (!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }

        $tarefa->update($request->all());

        return redirect()->route('tarefa.show', compact('tarefa'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tarefa $tarefa
     * @return RedirectResponse|View
     */
    public function destroy(Tarefa $tarefa)
    {
        if (!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }

        $tarefa->delete();
        return redirect()->route('tarefa.index');
    }

    /**
     * Export tasks to xlsx file
     *
     * @param $extensao
     * @return RedirectResponse|BinaryFileResponse
     */
    public function exportacao($extensao)
    {
        if (in_array($extensao, ['xlsx', 'csv', 'pdf'])) {
            return Excel::download(new TarefasExport, 'tarefas.' . $extensao);
        }
        return redirect()->route('tarefa.index');
    }
}
