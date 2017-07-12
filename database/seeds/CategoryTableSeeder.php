<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::forceCreate([
        	'name' => 'Laravel',
        	'slug' => 'laravel'
        ]);

        Category::forceCreate([
        	'name' => 'PHP',
        	'slug' => 'php'
        ]);

        Category::forceCreate([
        	'name' => 'Vue.js',
        	'slug' => 'vue-js'
        ]);

        Category::forceCreate([
        	'name' => 'JavaScript',
        	'slug' => 'javascript'
        ]);

        Category::forceCreate([
        	'name' => 'CSS',
        	'slug' => 'css'
        ]);

        Category::forceCreate([
        	'name' => 'Git',
        	'slug' => 'git'
        ]);
    }
}
