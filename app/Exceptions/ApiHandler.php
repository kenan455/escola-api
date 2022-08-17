<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

trait ApiHandler
{
    /**
     * Trata os erros personalizados
     * 
     * @param Throwable $exception
     * @return response
     */
    public function tratarErros(Throwable $exception): Response|false
    {
        if ($exception instanceof ModelNotFoundException) {
            return $this->modelNotFoundException();
        };

        if ($exception instanceof ValidationException) {
            return $this->validationException($exception);
        }

        return false;
    }

    /**
     * Retorna o erro quando não encontrado o registro
     * 
     * @return Response
     *  */
    public function modelNotFoundException(): Response
    {
        return $this->respostaPadrao(
            'registro-nao-encontrado',
            'O sistema não encontrou o registro que você está buscando',
            404
        );
    }

    /**
     * Retorna o erro quando  os dados não são validos
     * 
     * @param ValidationException $e
     * @return Response
     *  */
    public function validationException(ValidationException $e)
    {
        return $this->respostaPadrao(
            'erro-validacao',
            'Os dados enviados são inválidos',
            404,
            $e->errors()
        );
    }

    /**
     * Retorna uma resposta padrão para os erros da API
     * 
     * @param string $code
     * @param string $mensagem
     * @param int $status
     * @param array $erros
     * @return Response
     *  */
    public function respostaPadrao(
        string $code,
        string $mensagem,
        int $status,
        array $erros = null
    ): Response {
        $dadosResposta =  [
            'code' => $code,
            'message' => $mensagem,
            'status' => $status,
        ];

        if ($erros) {
            $dadosResposta = $dadosResposta + ['erros' => $erros];
        }

        return response(
            $dadosResposta,
            $status
        );
    }
}
