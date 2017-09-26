<?php

use Illuminate\Database\Seeder;

class PaginaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Portal\Models\Pagina::class, 10)->create();
    }
}
