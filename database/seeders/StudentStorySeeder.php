<?php

namespace Database\Seeders;

use App\Models\StudentStory;
use Illuminate\Database\Seeder;

class StudentStorySeeder extends Seeder
{
    /*
    |--------------------------------------------------------------------------
    | Run Seeder
    |--------------------------------------------------------------------------
    */

    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Clear Existing Dummy Stories
        |--------------------------------------------------------------------------
        |
        | Remove this line if you want to keep existing stories.
        |--------------------------------------------------------------------------
        */

        StudentStory::query()->delete();


        /*
        |--------------------------------------------------------------------------
        | Student Stories
        |--------------------------------------------------------------------------
        */

        $stories = [

            /*
            |--------------------------------------------------------------------------
            | Story 01
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Ali Raza',

                'program' =>
                    'BS Computer Science',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Laptop Support',

                'story' =>
                    'During my studies, access to a personal laptop became one of my biggest academic challenges. I was frequently dependent on university laboratories and borrowed devices to complete programming assignments. Through the NUST Sharing Network, I received a laptop that allowed me to work independently, complete projects on time, and participate more confidently in my coursework. This support made a meaningful difference in my academic routine and helped me focus more effectively on learning.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    true,

                'is_active' =>
                    true,

                'display_order' =>
                    1,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 02
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Ayesha Khan',

                'program' =>
                    'BS Electrical Engineering',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Educational Resources',

                'story' =>
                    'Engineering education requires continuous access to reference books, laboratory resources, and digital learning material. At a difficult point in my academic journey, I received essential study resources through the NUST Sharing Network. The support reduced my financial pressure and allowed me to concentrate on my semester work. Having the right academic resources improved my preparation and gave me greater confidence throughout the semester.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    true,

                'is_active' =>
                    true,

                'display_order' =>
                    2,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 03
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Hassan Ahmed',

                'program' =>
                    'BS Mechanical Engineering',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Hostel Essentials',

                'story' =>
                    'Moving away from home for university was both exciting and challenging. Managing accommodation and basic hostel requirements added additional financial pressure to my family. Through the Sharing Network, I received essential items that helped me settle into hostel life more comfortably. The support may appear simple, but it helped create a stable environment where I could focus on classes, assignments, and university activities.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    false,

                'is_active' =>
                    true,

                'display_order' =>
                    3,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 04
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Fatima Noor',

                'program' =>
                    'BS Economics',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Books & Study Material',

                'story' =>
                    'Access to textbooks was becoming difficult for me because purchasing multiple course books every semester was expensive. Through the NUST Sharing Network, I received books donated by members of the university community. These resources helped me prepare for lectures, assignments, and examinations without additional financial stress. I also hope to pass these materials forward so that another student can benefit from them in the future.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    false,

                'is_active' =>
                    true,

                'display_order' =>
                    4,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 05
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Usman Tariq',

                'program' =>
                    'BS Software Engineering',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Technology Support',

                'story' =>
                    'As a software engineering student, regular access to a reliable computer is essential. My previous device was no longer able to support the software required for development work. Through the NUST Sharing Network, I received technology support that enabled me to continue practicing programming, building projects, and preparing coursework. It gave me the ability to learn beyond the classroom and strengthened my confidence in my technical skills.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    true,

                'is_active' =>
                    true,

                'display_order' =>
                    5,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 06
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Maryam Siddiqui',

                'program' =>
                    'BS Psychology',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Academic Support',

                'story' =>
                    'There was a period when financial challenges made it difficult for me to manage my academic needs alongside other university expenses. Receiving support through the NUST Sharing Network helped reduce that burden. More importantly, it reminded me that there is a community willing to support students during difficult situations. The assistance helped me remain focused on my education and continue working toward my academic goals.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    false,

                'is_active' =>
                    true,

                'display_order' =>
                    6,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 07
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Muhammad Hamza',

                'program' =>
                    'BS Civil Engineering',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Stationery Support',

                'story' =>
                    'Civil engineering requires regular use of drawing materials, stationery, and technical supplies. Managing these expenses alongside tuition and living costs was difficult for me. The Sharing Network provided useful academic supplies that supported my coursework during the semester. This assistance allowed me to complete my work properly and showed me how practical contributions can have a direct impact on a student’s academic experience.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    false,

                'is_active' =>
                    true,

                'display_order' =>
                    7,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 08
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Zainab Malik',

                'program' =>
                    'BS Biotechnology',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Learning Resources',

                'story' =>
                    'My degree requires extensive reading, research, and preparation outside regular classroom hours. At times, limited access to the necessary learning resources affected how efficiently I could prepare. With support from the NUST Sharing Network, I received educational material that became extremely useful for my studies. The experience also encouraged me to contribute to the same initiative whenever I am able to support another student.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    false,

                'is_active' =>
                    true,

                'display_order' =>
                    8,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 09
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Ahmed Bilal',

                'program' =>
                    'BS Mathematics',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Community Support',

                'story' =>
                    'University life becomes much easier when students know that support is available during difficult periods. I benefited from a donated item through the NUST Sharing Network at a time when purchasing it myself was difficult. The process was simple, respectful, and helpful. Beyond the material support, the experience gave me a stronger sense of belonging to the NUST community and encouraged me to help others whenever possible.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    false,

                'is_active' =>
                    true,

                'display_order' =>
                    9,
            ],


            /*
            |--------------------------------------------------------------------------
            | Story 10
            |--------------------------------------------------------------------------
            */

            [
                'student_name' =>
                    'Sara Imran',

                'program' =>
                    'BS Business Administration',

                'story_type' =>
                    'text',

                'support_type' =>
                    'Student Support',

                'story' =>
                    'Balancing academic responsibilities with financial limitations can sometimes become overwhelming. The assistance I received through the NUST Sharing Network helped me manage an important academic need without adding further pressure on my family. The initiative demonstrates how small contributions from donors can create meaningful opportunities for students. I am grateful for the support and hope that this culture of sharing continues to grow across the university.',

                'image' =>
                    null,

                'image_alt' =>
                    null,

                'is_featured' =>
                    true,

                'is_active' =>
                    true,

                'display_order' =>
                    10,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | Insert Stories
        |--------------------------------------------------------------------------
        */

        foreach ($stories as $story) {

            StudentStory::create(
                $story
            );
        }
    }
}