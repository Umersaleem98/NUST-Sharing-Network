<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminStudentStoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $stories = StudentStory::query()
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {

                    $search = trim(
                        $request->search
                    );

                    $query->where(
                        function ($query) use ($search) {

                            $query
                                ->where(
                                    'student_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'program',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'support_type',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'story',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->when(
                $request->status === 'active',
                function ($query) {

                    $query->where(
                        'is_active',
                        true
                    );
                }
            )
            ->when(
                $request->status === 'inactive',
                function ($query) {

                    $query->where(
                        'is_active',
                        false
                    );
                }
            )
            ->when(
                $request->filled('story_type'),
                function ($query) use ($request) {

                    $query->where(
                        'story_type',
                        $request->story_type
                    );
                }
            )
            ->ordered()
            ->paginate(12)
            ->withQueryString();


        $totalStories =
            StudentStory::count();


        $activeStories =
            StudentStory::where(
                'is_active',
                true
            )->count();


        $inactiveStories =
            StudentStory::where(
                'is_active',
                false
            )->count();


        $featuredStories =
            StudentStory::where(
                'is_featured',
                true
            )->count();


        return view(
            'pages.admins.student-stories.index',
            compact(
                'stories',
                'totalStories',
                'activeStories',
                'inactiveStories',
                'featuredStories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'pages.admins.student-stories.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'student_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'program' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'story_type' => [
                    'required',
                    'in:text,image,image_text',
                ],

                'support_type' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'story' => [
                    'required_if:story_type,text,image_text',
                    'nullable',
                    'string',
                ],

                'image' => [
                    'required_if:story_type,image,image_text',
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:1024',
                ],

                'image_alt' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'display_order' => [
                    'nullable',
                    'integer',
                    'min:0',
                ],
            ],
            [
                'student_name.required' =>
                    'Student name is required.',

                'story_type.required' =>
                    'Please select a story type.',

                'story.required_if' =>
                    'Story text is required for this story type.',

                'image.required_if' =>
                    'An image is required for this story type.',

                'image.image' =>
                    'The selected file must be an image.',

                'image.mimes' =>
                    'Only JPG, JPEG, PNG and WEBP images are allowed.',

                'image.max' =>
                    'Image size must not exceed 1 MB.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $imageName = null;


        if ($request->hasFile('image')) {

            $directory =
                public_path(
                    'admins/story'
                );


            File::ensureDirectoryExists(
                $directory
            );


            $image =
                $request->file('image');


            $imageName =
                Str::uuid() .
                '.' .
                $image->getClientOriginalExtension();


            $image->move(
                $directory,
                $imageName
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        StudentStory::create([
            'student_name' =>
                trim(
                    $validated['student_name']
                ),

            'program' =>
                !empty($validated['program'])
                    ? trim($validated['program'])
                    : null,

            'story_type' =>
                $validated['story_type'],

            'support_type' =>
                !empty($validated['support_type'])
                    ? trim($validated['support_type'])
                    : null,

            'story' =>
                !empty($validated['story'])
                    ? trim($validated['story'])
                    : '',

            'image' =>
                $imageName,

            'image_alt' =>
                !empty($validated['image_alt'])
                    ? trim($validated['image_alt'])
                    : null,

            'is_featured' =>
                $request->boolean(
                    'is_featured'
                ),

            'is_active' =>
                $request->boolean(
                    'is_active'
                ),

            'display_order' =>
                $validated['display_order']
                ?? 0,
        ]);


        return redirect()
            ->route(
                'admin.student-stories.index'
            )
            ->with(
                'success',
                'Student story created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(
        StudentStory $studentStory
    ) {
        return view(
            'pages.admins.student-stories.show',
            compact(
                'studentStory'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(
        StudentStory $studentStory
    ) {
        return view(
            'pages.admins.student-stories.edit',
            compact(
                'studentStory'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        StudentStory $studentStory
    ) {
        $validated = $request->validate(
            [
                'student_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'program' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'story_type' => [
                    'required',
                    'in:text,image,image_text',
                ],

                'support_type' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'story' => [
                    'required_if:story_type,text,image_text',
                    'nullable',
                    'string',
                ],

                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:1024',
                ],

                'image_alt' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'display_order' => [
                    'nullable',
                    'integer',
                    'min:0',
                ],
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Existing Image
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $validated['story_type'],
                [
                    'image',
                    'image_text',
                ],
                true
            )
            &&
            !$request->hasFile('image')
            &&
            empty($studentStory->image)
        ) {

            return back()
                ->withErrors([
                    'image' =>
                        'An image is required for this story type.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Current Image
        |--------------------------------------------------------------------------
        */

        $imageName =
            $studentStory->image;


        /*
        |--------------------------------------------------------------------------
        | Upload New Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $directory =
                public_path(
                    'admins/story'
                );


            File::ensureDirectoryExists(
                $directory
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if (
                $studentStory->image
                &&
                File::exists(
                    public_path(
                        'admins/story/' .
                        $studentStory->image
                    )
                )
            ) {

                File::delete(
                    public_path(
                        'admins/story/' .
                        $studentStory->image
                    )
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Store New Image
            |--------------------------------------------------------------------------
            */

            $image =
                $request->file(
                    'image'
                );


            $imageName =
                Str::uuid() .
                '.' .
                $image->getClientOriginalExtension();


            $image->move(
                $directory,
                $imageName
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Image
        |--------------------------------------------------------------------------
        */

        if (
            $request->boolean(
                'remove_image'
            )
            &&
            $validated['story_type'] === 'text'
        ) {

            if (
                $studentStory->image
                &&
                File::exists(
                    public_path(
                        'admins/story/' .
                        $studentStory->image
                    )
                )
            ) {

                File::delete(
                    public_path(
                        'admins/story/' .
                        $studentStory->image
                    )
                );
            }


            $imageName = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Story
        |--------------------------------------------------------------------------
        */

        $studentStory->update([
            'student_name' =>
                trim(
                    $validated['student_name']
                ),

            'program' =>
                !empty($validated['program'])
                    ? trim($validated['program'])
                    : null,

            'story_type' =>
                $validated['story_type'],

            'support_type' =>
                !empty($validated['support_type'])
                    ? trim($validated['support_type'])
                    : null,

            'story' =>
                !empty($validated['story'])
                    ? trim($validated['story'])
                    : '',

            'image' =>
                $imageName,

            'image_alt' =>
                !empty($validated['image_alt'])
                    ? trim($validated['image_alt'])
                    : null,

            'is_featured' =>
                $request->boolean(
                    'is_featured'
                ),

            'is_active' =>
                $request->boolean(
                    'is_active'
                ),

            'display_order' =>
                $validated['display_order']
                ?? 0,
        ]);


        return redirect()
            ->route(
                'admin.student-stories.index'
            )
            ->with(
                'success',
                'Student story updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(
        StudentStory $studentStory
    ) {
        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if (
            $studentStory->image
            &&
            File::exists(
                public_path(
                    'admins/story/' .
                    $studentStory->image
                )
            )
        ) {

            File::delete(
                public_path(
                    'admins/story/' .
                    $studentStory->image
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Record
        |--------------------------------------------------------------------------
        */

        $studentStory->delete();


        return redirect()
            ->route(
                'admin.student-stories.index'
            )
            ->with(
                'success',
                'Student story deleted successfully.'
            );
    }
}