<?php

namespace App\Services;

class LinksGenerator
{
    /**
     * Guarda os links do hateoas
     * 
     * @var array
     */
    protected array $links = [];

    /**
     * Guarda um link no hateoas
     * 
     * @param string $tipo
     * @param string $url
     * @param string $rel
     * @return void
     */
    protected function add(string $tipo, string $url, string $rel): void
    {
        $this->links[] = [
            'type' => $tipo,
            'url' => $url,
            'rel' => $rel
        ];
    }


    /**
     * Adiciona um link do tipo GET
     * 
     * @param string $url
     * @param string $rel
     * @return void
     */
    public function get(string $url, string $rel): void
    {
        $this->add('GET', $url, $rel);
    }

    /**
     * Adiciona um link do tipo POST
     * 
     * @param string $url
     * @param string $rel
     * @return void
     */
    public function post(string $url, string $rel): void
    {
        $this->add('POST', $url, $rel);
    }

    /**
     * Adiciona um link do tipo PUT
     * 
     * @param string $url
     * @param string $rel
     * @return void
     */
    public function put(string $url, string $rel): void
    {
        $this->add('PUT', $url, $rel);
    }

    /**
     * Adiciona um link do tipo PATCH
     * 
     * @param string $url
     * @param string $rel
     * @return void
     */
    public function patch(string $url, string $rel): void
    {
        $this->add('PATCH', $url, $rel);
    }

    /**
     * Adiciona um link do tipo DELETE
     * 
     * @param string $url
     * @param string $rel
     * @return void
     */
    public function delete(string $url, string $rel): void
    {
        $this->add('DELETE', $url, $rel);
    }

    /**
     * Retorna uma array com os links do hateoas
     * 
     * @return array
     */
    public function toArray(): array
    {
        return $this->links;
    }
}
