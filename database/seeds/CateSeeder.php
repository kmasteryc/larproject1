<?php

use Illuminate\Database\Seeder;
use \App\Cate;
class CateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		foreach (range(1,10) as $i)
		{
			$faker = Faker\Factory::create();
			$a = new Cate;
			$a->cate_title = $faker->name;
			$a->cate_parent = rand(0,1);
			$a->save();
		}
    }
}
