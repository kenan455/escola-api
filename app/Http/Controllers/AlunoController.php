<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use SimpleXMLElement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\AlunoRequest;
use App\Http\Resources\AlunoResource;
use App\Http\Resources\AlunoCollection;


class AlunoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/alunos",
     *     summary="Lista os alunos cadastrados",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * 
     * Display a listing of the resource.
     *
     * @return AlunoCollection
     */
    public function index(Request $request): AlunoCollection
    {
        if ($request->query('relacoes') === 'turma') {
            $alunos = Aluno::with('turma')->paginate(2);
        } else {
            $alunos = Aluno::paginate(2);
        }

        return new AlunoCollection($alunos);

        //Aluno::get()->makeVisible('created_at')
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AlunoRequest $request
     * @return Response
     */
    public function store(AlunoRequest $request): Response
    {
        $dadosAluno = $request->all();

        return response(Aluno::create($dadosAluno), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/alunos/{id}",
     *     summary="Mostra os detalhes de um aluno",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * 
     * Display the specified resource.
     *
     * @param  Aluno $aluno
     * @return AlunoResource
     */
    public function show(Aluno $aluno)
    {
        if (request()->header("Accept") === "application/xml") {
            return $this->pegarAlunoXMLResponse($aluno);
        }

        if (request()->wantsJson()) {
            return new AlunoResource($aluno);
        }

        return response('Formato de dado desconhecido');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AlunoRequest $request
     * @param  Aluno $aluno
     * @return Aluno
     */
    public function update(AlunoRequest $request, Aluno $aluno): Aluno
    {
        $aluno->update($request->all());

        return $aluno;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Aluno $aluno
     * @return array
     */
    public function destroy(Aluno $aluno)
    {
        $aluno->delete();

        return [];
    }

    private function pegarAlunoXMLResponse(Aluno $aluno): Response
    {
        $aluno = $aluno->toArray();

        $xml = new SimpleXMLElement('<aluno/>');

        array_walk_recursive($aluno, function ($valor, $chave) use ($xml) {
            $xml->addChild($chave, $valor);
        });

        return response($xml->asXML())
            ->header('Content-Type', 'application/xml');
    }
}
