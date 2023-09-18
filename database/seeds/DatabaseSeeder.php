<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RoleTableSeeder::class);
         $this->call(UserTablesSeeder::class);
         $this->call(CicloescolarTablesSeeder::class);
         $this->call(NivelescolarTablesSeeder::class);
         $this->call(GrupoTablesSeeder::class);
         $this->call(AlumnoTablesSeeder::class);
         $this->call(ConceptocobroTableSeeder::class);
         $this->call(PlanpagosTableSeeder::class);
    }
}