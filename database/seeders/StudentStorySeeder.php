<?php

namespace Database\Seeders;

use App\Models\StudentStory;
use Illuminate\Database\Seeder;

class StudentStorySeeder extends Seeder
{
    public function run(): void
    {
        StudentStory::create([
            'student_name' => 'Ali Ahmed',
            'program' => 'BS Computer Science',
            'story_type' => 'image_text',
            'support_type' => 'Laptop Support',
            'story' => 'Receiving a laptop through the NUST Sharing Network made a meaningful difference in my academic journey. I can now complete assignments, attend online classes, and work on programming projects more effectively.',
            'image' => 'student-stories/ali-ahmed.jpg',
            'image_alt' => 'Ali Ahmed student story',
            'is_featured' => true,
            'is_active' => true,
            'display_order' => 1,
        ]);

        StudentStory::create([
            'student_name' => 'Ayesha Khan',
            'program' => 'BS Electrical Engineering',
            'story_type' => 'image_text',
            'support_type' => 'Educational Support',
            'story' => 'The assistance I received helped me continue my studies during a difficult period. It allowed me to focus on my academic responsibilities and continue working toward my goals.',
            'image' => 'student-stories/ayesha-khan.jpg',
            'image_alt' => 'Ayesha Khan student story',
            'is_featured' => true,
            'is_active' => true,
            'display_order' => 2,
        ]);

        StudentStory::create([
            'student_name' => 'Muhammad Hamza',
            'program' => 'BS Mechanical Engineering',
            'story_type' => 'text',
            'support_type' => 'Book Support',
            'story' => 'The books provided through the NUST Sharing Network helped me prepare for my courses and examinations without having to worry about purchasing expensive academic resources.',
            'image' => null,
            'image_alt' => null,
            'is_featured' => false,
            'is_active' => true,
            'display_order' => 3,
        ]);

        StudentStory::create([
            'student_name' => 'Fatima Noor',
            'program' => 'BS Economics',
            'story_type' => 'image',
            'support_type' => 'Community Support',
            'story' => null,
            'image' => 'student-stories/fatima-noor.jpg',
            'image_alt' => 'Fatima Noor supported through NUST Sharing Network',
            'is_featured' => false,
            'is_active' => true,
            'display_order' => 4,
        ]);

        StudentStory::create([
            'student_name' => 'Usman Tariq',
            'program' => 'BS Software Engineering',
            'story_type' => 'image_text',
            'support_type' => 'Device Support',
            'story' => 'The device support improved my ability to complete programming assignments and semester projects. It has had a positive impact on both my learning and academic performance.',
            'image' => 'student-stories/usman-tariq.jpg',
            'image_alt' => 'Usman Tariq student story',
            'is_featured' => false,
            'is_active' => true,
            'display_order' => 5,
        ]);

        StudentStory::create([
            'student_name' => 'Sara Malik',
            'program' => 'BS Social Sciences',
            'story_type' => 'text',
            'support_type' => 'Student Support',
            'story' => 'The NUST Sharing Network showed me how strongly our community supports students. The assistance gave me confidence and motivation to continue working toward my educational goals.',
            'image' => null,
            'image_alt' => null,
            'is_featured' => false,
            'is_active' => true,
            'display_order' => 6,
        ]);
    }
}