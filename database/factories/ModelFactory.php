<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\Modules\Core\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_alternativo' => $faker->unique()->safeEmail,
        'sexo' => 1,
        'imagem' => $faker->imageUrl(250, 250),
        'password' => 'secret',
        'status' => 'ativo',
        'remember_token' => str_random(10),
        'disponivel' => true,
    ];
});

$factory->define(\Portal\Models\Pagina::class, function (Faker\Generator $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'titulo' => $faker->text(40),
        'resumo' => $faker->unique()->text,
        'descricao' => $faker->unique()->text(50),
        'status' => True,
//        'parent_id' => 1
    ];
});

$factory->define(\Modules\Core\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'slug' => strtolower($faker->name),
        'description' => $faker->word,
    ];
});
$factory->define(\Modules\Core\Models\Permission::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'slug' => [          // pass an array of permissions.
            'store' => true,
            'view' => true,
            'show' => true,
            'update' => true,
            'delete' => true,
        ],
        'description' => $faker->word,
    ];
});
$factory->define(\Portal\Models\Configuracao::class, function (Faker\Generator $faker) {
    return [
        'titulo' => $faker->name,
        'email' => $faker->email,
        'url_site' => $faker->url,
        'telefone' => $faker->phoneNumber,
        'horario_atendimento' => $faker->date('H:i'),
        'endereco' => $faker->address,
        'rodape' => $faker->word,
        'facebook' => null,
        'twitter' => null,
        'google_plus' => null,
        'youtube' => null,
        'instagram' => null,
        'palavra_chave' => null,
        'descricao_site' => null,
        'og_tipo_app' => null,
        'og_titulo_site' => null,
        'od_url_site' => null,
        'od_autor_site' => null,
        'facebook_id' => null,
        'token' => null,
        'analytcs_code' => null,
    ];
});
$factory->define(\Modules\Localidade\Models\Pais::class, function (Faker\Generator $faker) {
    return [
        'titulo' => "Brasil",
        'sigla' => "BR",
    ];
});

$factory->define(\Modules\Localidade\Models\Estado::class, function (Faker\Generator $faker) {
    return [
        'pais_id' => 1,
        'titulo' => "Tocantins",
        'uf' => "TO",
    ];
});

$factory->define(\Modules\Localidade\Models\Cidade::class, function (Faker\Generator $faker) {
    return [
        'estado_id' => 1,
        'titulo' => "Palmas",
        'capital' => true,
    ];
});

$factory->define(\Modules\Localidade\Models\Bairro::class, function (Faker\Generator $faker) {
    return [
        'cidade_id' => 1,
        'titulo' => "Centro",
    ];
});

$factory->define(\Modules\Plano\Models\FormaPagamento::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->word,
        'taxa' => random_int(1, 5),
        'status' => true
    ];
});

$factory->define(\Modules\Plano\Models\Plano::class, function (Faker\Generator $faker) {
    return [
        'nome' => 'PLANO 1',
        'dias' => 7,
        'qtde_destaque' => 1,
        'qtde_anuncio' => 1,
        'valor' => 100,
        'tipo' => 'anunciante',
        'status' => 1,
    ];
});

$factory->define(\Modules\Plano\Models\PlanoTabelaPreco::class, function (Faker\Generator $faker) {
    return [
        'plano_id' => 1,
        'estado_id' => 1,
        'cidade_id' => 1,
        'valor' => 140,
    ];
});
$factory->define(\Modules\Localidade\Models\Endereco::class, function (Faker\Generator $faker) {
    return [
        'estado_id' => 1,
        'cidade_id' => 1,
        'bairro_id' => 1,
        'cep' => '77600000',
        /*'enderecotable_id'    => 1,
        'enderecotable_type'    => 'Portal\Models\Anuncio',*/
        'numero' => random_int(1, 200),
        'endereco' => $faker->address,
        'complemento' => 'casa'
    ];
});
/*$factory->define(Finalidade::class, function (Faker\Generator $faker) {
    return [
        'titulo' => $faker->word,
    ];
});*/
$factory->define(\Portal\Models\Imagem::class, function (Faker\Generator $faker) {
    return [
        'img' => $faker->imageUrl(),
        /*'imagemtable_id' => 1,
        'imagemtable_type_id' => 'Portal\Models\Anuncio',*/
    ];
});
/*$factory->define(\Portal\Models\Anuncio::class, function (Faker\Generator $faker) {
    return [
        'situacao' => $faker->randomElements(['na-planta', 'em-obras', 'pronto'])[0],
        'tipo' => $faker->randomElements(['imovel', 'empreendimento'])[0],
        'user_id' => 1,
        'finalidade_id' => 1,
        'pretensao' => 'Alugar',
        'valor' => (double)$faker->randomFloat(2, 2000, 200000),
        'valor_condominio' => (double)$faker->randomFloat(2, 100, 2000),
        'codigo' => rand(1, 260),
        'descricao' => $faker->paragraph,
        'ano_construcao' => 2007,
        'observacao' => $faker->paragraph,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'area_util' => (double)50.65,
        'area_total' => (double)100.35,
        'qtde_dormitorio' => rand(1, 3),
        'qtde_suite' => rand(1, 3),
        'qtde_banheiro' => rand(1, 3),
        'qtde_vaga' => rand(1, 3),
        'qtde_sala' => rand(1, 3),
        'possui_divida' => false,
        'saldo_divida' => (double)$faker->randomFloat(2, 50000, 70000),
        'valor_mensalidade_divida' => (double)$faker->randomFloat(2, 1000, 10000),
        'data_vencimento_divida' => $faker->date('Y-m-d'),
        'data_ultima_parcela_divida' => $faker->date('Y-m-d', '+10 years'),
        'qtde_parcela_restante_divida' => rand(1, 24),
        'titulo' => $faker->word,
        'titulo_reduzido' => $faker->word,
        'subtitulo' => $faker->word,
        'descricao_curta' => $faker->paragraph,
        'qtde_area_minimo' => (double)rand(15, 35),
        'qtde_area_maximo' => (double)rand(40, 100),
        'qtde_dormitoario_minimo' => 1,
        'qtde_dormitoario_maximo' => rand(2, 4),
        'qtde_suite_minimo' => 1,
        'qtde_suite_maximo' => rand(2, 4),
        'qtde_andar' => rand(3, 20),
        'qtde_elevador' => rand(1, 3),
        'qtde_unidade_andar' => rand(1, 10),
    ];
});

$factory->define(\Portal\Models\AnuncioPreco::class, function (Faker\Generator $faker) {
    return [
        'anuncio_id' => 1,
        'valor' => (double)$faker->randomFloat(2, 2000, 200000),
        'valor_condominio' => (double)$faker->randomFloat(2, 100, 2000),
    ];
});

$factory->define(\Portal\Models\Caracteristica::class, function (Faker\Generator $faker) {
    return [
        'titulo' => (string)substr($faker->paragraph,0,80),
        'tipo' => $faker->randomElements(['Privativa', 'Comum'])[0],
    ];
});*/

$factory->define(\Modules\Core\Models\RotaAcesso::class, function (Faker\Generator $faker){
    return [
        'parent_id' => null,
        'text' => $faker->word,
        'rota' => '',
        'icon' => '',
        'disabled' => false,
     ];
});

$factory->define(\Modules\Plano\Models\PlanoContratacao::class, function (\Faker\Generator $faker){
    return [
        'plano_id'=>1,
        'user_id'=>1,
        'numero_fatura'=>rand(100,5000),
        'data_inicio'=>\Carbon\Carbon::now(),
        'data_fim'=>\Carbon\Carbon::now()->addDay(7),
        'total'=>500.62,
        'desconto'=>5.63,/*
        'plano_contratacaotable_id'=>1,
        'plano_contratacaotable_type'=>\Portal\Models\Anuncio::class,*/
    ];
});

$factory->define(\Modules\Plano\Models\Lancamento::class, function (\Faker\Generator $faker){
    return [
        'forma_pagamento_id'=>rand(1,3),
        'plano_contratacao_id'=>1,
        'valor' =>100,
        'desconto' =>2,
        'data_do_pagamento'=>date('Y-m-d')
    ];
});