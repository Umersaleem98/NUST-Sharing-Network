<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin User
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

        $electronics = Category::where(
            'name',
            'Electronics'
        )->first();


        $books = Category::where(
            'name',
            'Books'
        )->first();


        $clothing = Category::where(
            'name',
            'Clothing'
        )->first();


        $furniture = Category::where(
            'name',
            'Furniture'
        )->first();


        $stationery = Category::where(
            'name',
            'Stationery'
        )->first();


        $household = Category::where(
            'name',
            'Household Items'
        )->first();


        $sports = Category::where(
            'name',
            'Sports'
        )->first();


        $others = Category::where(
            'name',
            'Others'
        )->first();


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products = [

            [
                'category_id' =>
                    $electronics?->id,

                'name' =>
                    'Laptop',

                'description' =>
                    'Used laptop in working condition suitable for academic and educational use.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $electronics?->id,

                'name' =>
                    'Computer Monitor',

                'description' =>
                    'Working computer monitor suitable for study or office use.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $books?->id,

                'name' =>
                    'Programming Books',

                'description' =>
                    'Collection of programming and software development books for students.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $books?->id,

                'name' =>
                    'Engineering Textbooks',

                'description' =>
                    'Used engineering textbooks in good condition.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $clothing?->id,

                'name' =>
                    'Winter Jacket',

                'description' =>
                    'Warm winter jacket in reusable condition.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $furniture?->id,

                'name' =>
                    'Study Table',

                'description' =>
                    'Wooden study table suitable for students.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $furniture?->id,

                'name' =>
                    'Study Chair',

                'description' =>
                    'Comfortable chair suitable for studying or office work.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $stationery?->id,

                'name' =>
                    'Stationery Set',

                'description' =>
                    'Basic stationery set containing notebooks, pens and educational supplies.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $household?->id,

                'name' =>
                    'Electric Kettle',

                'description' =>
                    'Used electric kettle in working condition.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $sports?->id,

                'name' =>
                    'Cricket Bat',

                'description' =>
                    'Used cricket bat suitable for recreational sports activities.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],

            [
                'category_id' =>
                    $sports?->id,

                'name' =>
                    'Football',

                'description' =>
                    'Football in usable condition.',

                'image' =>
                    null,

                'status' =>
                    'inactive',
            ],

            [
                'category_id' =>
                    $others?->id,

                'name' =>
                    'Backpack',

                'description' =>
                    'Student backpack in good reusable condition.',

                'image' =>
                    null,

                'status' =>
                    'active',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | Insert Products
        |--------------------------------------------------------------------------
        */

        foreach ($products as $product) {

            if (!$product['category_id']) {
                continue;
            }


            Product::updateOrCreate(
                [
                    'name' =>
                        $product['name'],

                    'category_id' =>
                        $product['category_id'],
                ],
                [
                    'user_id' =>
                        $admin->id,

                    'description' =>
                        $product['description'],

                    'image' =>
                        $product['image'],

                    'status' =>
                        $product['status'],
                ]
            );
        }
    }
}