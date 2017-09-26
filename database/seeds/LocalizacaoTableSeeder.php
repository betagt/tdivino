<?php

use Illuminate\Database\Seeder;

class LocalizacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Portal\Models\Pais::class)->create();
        factory(\Portal\Models\Estado::class)->create();

        factory(\Portal\Models\Estado::class)->create([
                'pais_id' => 1,
                'titulo' => "Goiais",
                'uf' => "GO",

        ]);
        factory(\Portal\Models\Estado::class)->create([
                'pais_id' => 1,
                'titulo' => "Para",
                'uf' => "PA",
        ]);

        factory(\Portal\Models\Cidade::class)->create();

        factory(\Portal\Models\Cidade::class)->create([
                'estado_id' => 1,
                'titulo' => "Araguaina",
                'capital' => false,
        ]);
        factory(\Portal\Models\Cidade::class)->create([
                'estado_id' => 2,
                'titulo' => "Goiania",
                'capital' => true,
        ]);
        factory(\Portal\Models\Cidade::class)->create([
                'estado_id' => 2,
                'titulo' => "Anapolis",
                'capital' => false,
        ]);
        factory(\Portal\Models\Bairro::class)->create( [
            'cidade_id' => 1,
            'titulo' => "Centro",
        ]);
    }
}
