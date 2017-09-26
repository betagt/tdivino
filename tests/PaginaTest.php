<?php

class PaginaTest extends TestCase
{

    private $uri = '/api/v1/admin/pagina/';

    public function testRetornoListagem()
    {
        $response = $this->json('GET',$this->uri,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());
    }

    public function testRetornoListagemFiltro()
    {
        $param = [
            'search' => 'iure',
            'searchFields' => 'titulo:like',
        ];

        $response = $this->json('GET',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());

    }

    public function testRetornoRegistro()
    {
        $response = $this->json('GET',$this->uri.'100',[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;
        $this->assertJson($response->getContent());

        $response = $this->json('GET',$this->uri.'1',[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());
    }

    public function testCadastrarRegistro()
    {

        //cadastro registro
        $param = [
            'titulo'    => 'titulo novo',
            'descricao' => 'descricao nova',
            'resumo'    => 'resumo novo',
            'status'    => '0',
        ];

        $response = $this->json('POST',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());

        $param['titulo'] = '';
        $this->json('POST',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['descricao'] = '';
        $this->json('POST',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['descricao'] = '';
        $this->json('POST',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['status'] = '';
        $this->json('POST',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;


        $response = $this->json('POST',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $this->assertJson($response->getContent());


    }

    public function testAlterarRegistro()
    {
        //cadastro registro
        $param = [
            'titulo'    => 'TITULANDO O TITULO',
            'descricao' => 'descricao nova',
            'resumo'    => 'resumo novo',
            'status'    => '0',
        ];

        $response = $this->json('PUT',$this->uri.'1', $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());

        $param['titulo'] = '';
        $this->json('PUT',$this->uri.'1', $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['descricao'] = '';
        $this->json('PUT',$this->uri.'1', $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['descricao'] = '';
        $this->json('PUT',$this->uri.'1', $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['status'] = '';
        $this->json('PUT',$this->uri.'1', $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;


        $response = $this->json('PUT',$this->uri.'1', $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $this->assertJson($response->getContent());


    }

    public function testDeletarRegistro()
    {
        $response = $this->json('DELETE',$this->uri.'123',[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;
        $this->assertJson($response->getContent());

        $response = $this->json('DELETE',$this->uri.'1',[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());
    }

}
