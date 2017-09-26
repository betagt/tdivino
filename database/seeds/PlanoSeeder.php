<?php

use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Portal\Models\Plano::class)->create();

        factory(\Portal\Models\Plano::class)->create([
            'nome'            => 'PLANO 2',
            'dias'            => 1,
            'qtde_destaque'   => 1,
            'qtde_anuncio'    => 1,
            'valor'           => 150,
            'tipo'            => 'anunciante',
            'status'          => 1,
        ]);
        factory(\Portal\Models\PlanoTabelaPreco::class)->create();

        factory(\Portal\Models\PlanoTabelaPreco::class)->create([
            'plano_id' => 1,
            'estado_id' => 1,
            'cidade_id' => 2,
            'valor' => 130,
        ]);
        factory(\Portal\Models\PlanoTabelaPreco::class)->create([
            'plano_id' => 1,
            'estado_id' => 2,
            'cidade_id' => 3,
            'valor' => 160,
        ]);
        factory(\Portal\Models\PlanoTabelaPreco::class)->create([
            'plano_id' => 1,
            'estado_id' => 2,
            'cidade_id' => 4,
            'valor' => 150,
        ]);

        factory(\Portal\Models\PlanoTabelaPreco::class)->create([
            'plano_id' => 2,
            'estado_id' => 1,
            'cidade_id' => 1,
            'valor' => 170,
        ]);

        factory(\Portal\Models\PlanoTabelaPreco::class)->create([
            'plano_id' => 2,
            'estado_id' => 1,
            'cidade_id' => 2,
            'valor' => 160,
        ]);
        factory(\Portal\Models\PlanoTabelaPreco::class)->create([
            'plano_id' => 2,
            'estado_id' => 2,
            'cidade_id' => 3,
            'valor' => 180,
        ]);
        factory(\Portal\Models\PlanoTabelaPreco::class)->create([
            'plano_id' => 1,
            'estado_id' => 2,
            'cidade_id' => 4,
            'valor' => 170,
        ]);
    }
}
