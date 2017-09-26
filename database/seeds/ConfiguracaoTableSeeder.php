<?php

use Illuminate\Database\Seeder;

class ConfiguracaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Portal\Models\Configuracao::class, 1)->create();
    }
}
