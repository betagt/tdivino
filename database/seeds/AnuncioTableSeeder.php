<?php

use Illuminate\Database\Seeder;

class AnuncioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Portal\Models\Caracteristica::class,5)->create();

        factory(\Portal\Models\Finalidade::class,3)->create()->each(function($finalidade) {
            $anuncio = factory(\Portal\Models\Anuncio::class,1)->create([
                'user_id' => 1,
                'finalidade_id' => $finalidade->id,
            ]);
            $anuncio->endereco()->save(factory(\Modules\Localidade\Models\Endereco::class)->make());
            $anuncio->precos()->save(factory(\Portal\Models\AnuncioPreco::class)->make());
            $anuncio->imagens()->save(factory(\Portal\Models\Imagem::class)->make([
                'principal'=>true
            ]));
            for($i=0; $i<5; $i++){
                $anuncio->imagens()->save(factory(\Portal\Models\Imagem::class)->make());
            }
            $anuncio->caracteristicas()->attach([1,2,3]);
            $finalidade->caracteristicas()->attach([1,2,3]);
        });
    }
}
