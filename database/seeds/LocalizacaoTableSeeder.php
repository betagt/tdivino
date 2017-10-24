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
        factory(\Modules\Localidade\Models\Pais::class)->create();
        factory(\Modules\Localidade\Models\Estado::class)->create();

        factory(\Modules\Localidade\Models\Estado::class)->create([
                'pais_id' => 1,
                'titulo' => "Goiais",
                'uf' => "GO",

        ]);
        factory(\Modules\Localidade\Models\Estado::class)->create([
                'pais_id' => 1,
                'titulo' => "Para",
                'uf' => "PA",
        ]);

        factory(\Modules\Localidade\Models\Cidade::class)->create();

        factory(\Modules\Localidade\Models\Cidade::class)->create([
                'estado_id' => 1,
                'titulo' => "Araguaina",
                'capital' => false,
        ]);
        factory(\Modules\Localidade\Models\Cidade::class)->create([
                'estado_id' => 2,
                'titulo' => "Goiania",
                'capital' => true,
        ]);
        factory(\Modules\Localidade\Models\Cidade::class)->create([
                'estado_id' => 2,
                'titulo' => "Anapolis",
                'capital' => false,
        ]);
        factory(\Modules\Localidade\Models\Bairro::class)->create( [
            'cidade_id' => 1,
            'titulo' => "Centro",
        ]);
    }
}
