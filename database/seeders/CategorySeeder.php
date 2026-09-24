<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Get Admin User
        |--------------------------------------------------------------------------
        */

        $admin = User::where(
            'role',
            'admin'
        )->first();


        if (!$admin) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = [

            [
                'name' => 'Electronics',

                'description' =>
                    'Electronic devices, accessories and related items.',

                'status' =>
                    'active',
            ],

            [
                'name' => 'Books',

                'description' =>
                    'Academic books, general reading books and educational material.',

                'status' =>
                    'active',
            ],

            [
                'name' => 'Clothing',

                'description' =>
                    'Clothes and wearable items suitable for donation.',

                'status' =>
                    'active',
            ],

            [
                'name' => 'Furniture',

                'description' =>
                    'Home, office and study furniture items.',

                'status' =>
                    'active',
            ],

            [
                'name' => 'Stationery',

                'description' =>
                    'Educational and office stationery items.',

                'status' =>
                    'active',
            ],

            [
                'name' => 'Household Items',

                'description' =>
                    'Useful household products and daily-use items.',

                'status' =>
                    'active',
            ],

            [
                'name' => 'Sports',

                'description' =>
                    'Sports equipment and fitness-related products.',

                'status' =>
                    'active',
            ],

            [
                'name' => 'Others',

                'description' =>
                    'Products that do not fall under the available categories.',

                'status' =>
                    'active',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | Insert Categories
        |--------------------------------------------------------------------------
        */

        foreach ($categories as $category) {

            Category::updateOrCreate(
                [
                    'name' =>
                        $category['name'],
                ],
                [
                    'user_id' =>
                        $admin->id,

                    'description' =>
                        $category['description'],

                    'status' =>
                        $category['status'],
                ]
            );
        }
    }
}