<?php

class PlanoTest extends TestCase
{
    private $uri = '/api/v1/admin/plano/';
    private $param_fields;
    private $param_fields_tabela_preco;

    public function setUp()
    {
        parent::setUp();
        $this->param_fields =  [
            'nome'            => 'PLANO GOLD',
            'dias'            => 30,
            'qtde_destaque'   => 3,
            'qtde_anuncio'    => 5,
            'valor'           => 189,
            'tipo'            => 'anunciante',
            'status'          => 1,
        ];

        $registro = \Portal\Models\Plano::all()->last();
        if($registro) {
            $this->param_fields_tabela_preco = [
                'plano_id' => $registro->id,
                'estado_id' => null,
                'cidade_id' => null,
                'valor' => 80.70,
            ];
        }
    }

    public function testRetornoListagem()
    {
        $response = $this->json('GET',$this->uri,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());
    }

    public function testRetornoListagemFiltro()
    {
        $param_filter = [
            'search' => 'nome_plano',
            'searchFields' => 'nome:like',
        ];

        $response = $this->json('GET',$this->uri, $param_filter, $this->getMyHeader())
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
        $response = $this->json('POST',$this->uri, $this->param_fields, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());

        foreach ($this->param_fields as $key => $val){
            $this->param_fields[$key] = '';
            $this->json('POST',$this->uri, $this->param_fields, $this->getMyHeader())
                ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;
        }
        $response = $this->json('POST',$this->uri, $this->param_fields, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;
        $this->assertJson($response->getContent());

    }

    public function testAlterarRegistro()
    {
        $registro = \Portal\Models\Plano::all()->last();
        $this->json('PUT',$this->uri.$registro->id, $this->param_fields, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;

        foreach ($this->param_fields as $key => $val){
            $this->param_fields[$key] = '';
            $this->json('PUT',$this->uri.$registro->id, $this->param_fields, $this->getMyHeader())
                ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;
        }
        $this->json('PUT',$this->uri.$registro->id+100, $this->param_fields, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;
    }


    public function testDeletarRegistro()
    {
        $registro = \Portal\Models\Plano::all()->last();
        $this->json('DELETE',$this->uri.$registro->id+100,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;

        $this->json('DELETE',$this->uri.$registro->id,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
    }

    public function testCadastrarRegistroTabelaPreco()
    {
        $response = $this->json('POST',$this->uri.'tabela_preco', $this->param_fields_tabela_preco, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;

        $this->assertJson($response->getContent());

        foreach ($this->param_fields_tabela_preco as $key => $val){
            $this->param_fields_tabela_preco[$key] = '';
            $this->json('POST',$this->uri.'tabela_preco', $this->param_fields_tabela_preco, $this->getMyHeader())
                ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;
        }
        $response = $this->json('POST',$this->uri.'tabela_preco', $this->param_fields_tabela_preco, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;
        $this->assertJson($response->getContent());

    }

    public function testCadastrarRegistroTabelaPrecoEstado()
    {
        $this->param_fields_tabela_preco['estado_id'] = 1;
        $response = $this->json('POST',$this->uri.'tabela_preco', $this->param_fields_tabela_preco, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;

        $this->assertJson($response->getContent());

    }

    public function testCadastrarRegistroTabelaPrecoCidade()
    {
        $this->param_fields_tabela_preco['cidade_id'] = 2;
        $this->param_fields_tabela_preco['estado_id'] = 2;
        $this->param_fields_tabela_preco['plano_id'] = 1;
        $this->param_fields_tabela_preco['valor'] = 135;
        $response = $this->json('POST',$this->uri.'tabela_preco', $this->param_fields_tabela_preco, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());

    }

    public function testAlterarRegistroTabelaPreco()
    {
        $this->param_fields_tabela_preco['valor'] = 169.16;
        $this->param_fields_tabela_preco['estado_id'] = 1;
        $this->param_fields_tabela_preco['cidade_id'] = null;
        $this->param_fields_tabela_preco['plano_id'] = 9;
        $registro = \Portal\Models\PlanoTabelaPreco::all()->last();
        $this->json('PUT',$this->uri.'tabela_preco/'.$registro->id, $this->param_fields_tabela_preco, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;

        $this->json('PUT',$this->uri.'tabela_preco/'.$registro->id+100, $this->param_fields_tabela_preco, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;
    }

    public function testDeletarRegistroTabelaPreco()
    {
        $registro = \Portal\Models\PlanoTabelaPreco::all()->last();
        $this->json('DELETE',$this->uri.'tabela_preco/'.$registro->id+100,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;

        $this->json('DELETE',$this->uri.'tabela_preco/'.$registro->id,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;

    }

    public function testRetornoListagemTabelaPreco()
    {
        $registro = \Portal\Models\Plano::all()->first();
        $response = $this->json('GET',$this->uri.'tabela_preco/'.$registro->id, [], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());
    }

    public function testRetornoListagemConsulta(){
        $uri = '/api/v1/front/plano/';
        $response = $this->json('GET',$uri.'consulta/anunciante/TO/Araguaina/', [], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());
    }
}
