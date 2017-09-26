<?php

use Illuminate\Database\Seeder;

class ContratacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $contratacao = factory(\Modules\Plano\Models\PlanoContratacao::class, 1)->create([
            'plano_id'=>1,
            'user_id'=>1,
            'numero_fatura'=>rand(100,5000),
            'data_inicio'=>\Carbon\Carbon::now(),
            'data_fim'=>\Carbon\Carbon::now()->addDay(7),
            'total'=>rand(126,1520),
            'desconto'=>rand(10,100),
            'plano_contratacaotable_id'=>4,
            'plano_contratacaotable_type'=>\Portal\Models\Anuncio::class,
        ]);

        factory(\Modules\Plano\Models\Lancamento::class, 1)->create([
            'forma_pagamento_id'=>rand(1,3),
            'plano_contratacao_id'=>$contratacao->id,
            'valor' =>$contratacao->total,
            'desconto' =>$contratacao->desconto,
            'data_do_pagamento'=>date('Y-m-d')
        ]);

    }
}
