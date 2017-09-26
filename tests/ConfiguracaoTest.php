<?php

class ConfiguracaoTest extends TestCase
{
    private $uri = '/api/v1/admin/configuracao/';


    public function testRetornoRegistro()
    {

        $response = $this->json('GET',$this->uri,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());
    }


    public function testAlterarRegistro()
    {
        //cadastro registro
        $param = [
            'titulo'                => 'titulo',
            'email'                 => 'qimob@qative.com.br',
            'url_site'              => 'http://www.portalqimob.com.br',
            'telefone'              => 'telefone',
            'horario_atendimento'   => 'horario_atendimento',
            'endereco'              => 'endereco',
            'rodape'                => 'rodape',
            'facebook'              => 'facebook',
            'twitter'               => 'twitter',
            'google_plus'           => 'google_plus',
            'youtube'               => 'youtube',
            'instagram'             => 'instagram',
            'palavra_chave'         => 'palavra_chave',
            'descricao_site'        => 'descricao_site',
            'og_tipo_app'           => 'og_tipo_app',
            'og_titulo_site'        => 'og_titulo_site',
            'od_url_site'           => 'http://www.portalqimob.com.br',
            'od_autor_site'         => 'od_autor_site',
            'facebook_id'           => 'facebook_id',
            'token'                 => 'token',
            'analytcs_code'         => 0,

        ];

        $response = $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;

        $this->assertJson($response->getContent());

        $param['titulo'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['email'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['url_site'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['telefone'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['horario_atendimento'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['endereco'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['rodape'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['facebook'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['twitter'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['google_plus'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['youtube'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['instagram'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['palavra_chave'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['descricao_site'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['og_tipo_app'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['og_titulo_site'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['od_url_site'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['od_autor_site'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['facebook_id'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['token'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $param['analytcs_code'] = '';
        $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;


        $response = $this->json('PUT',$this->uri, $param, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $this->assertJson($response->getContent());


    }

}
