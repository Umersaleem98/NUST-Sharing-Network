<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminStoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $stories = StudentStory::query()
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view(
            'pages.admin.story.index',
            compact('stories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('pages.admin.story.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
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
                'nullable',
                'string',
                'required_if:story_type,text,image_text',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                'required_if:story_type,image,image_text',
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
        ]);


        /*
        |--------------------------------------------------------------------------
        | Image Upload
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName =
                time()
                . '-'
                . Str::slug($validated['student_name'])
                . '-'
                . Str::random(6)
                . '.'
                . $image->getClientOriginalExtension();

            $destinationPath = public_path('admins/story');

            if (!File::exists($destinationPath)) {
                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }

            $image->move(
                $destinationPath,
                $imageName
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Story
        |--------------------------------------------------------------------------
        */

        StudentStory::create([
            'student_name' =>
                trim($validated['student_name']),

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
                    : null,

            'image' =>
                $imageName,

            'image_alt' =>
                !empty($validated['image_alt'])
                    ? trim($validated['image_alt'])
                    : null,

            'is_featured' =>
                $request->boolean('is_featured'),

            'is_active' =>
                $request->boolean('is_active'),

            'display_order' =>
                $validated['display_order'] ?? 0,
        ]);


        return redirect()
            ->route('admin.student.stories.index')
            ->with(
                'success',
                'Student story created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(StudentStory $story)
    {
        return view(
            'pages.admin.story.edit',
            compact('story')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        StudentStory $story
    ) {
        $validated = $request->validate([
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
                'nullable',
                'string',
                'required_if:story_type,text,image_text',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
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
        ]);


        /*
        |--------------------------------------------------------------------------
        | Image Required Check
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $validated['story_type'],
                ['image', 'image_text']
            )
            && !$story->image
            && !$request->hasFile('image')
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

        $imageName = $story->image;


        /*
        |--------------------------------------------------------------------------
        | Upload New Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $oldImagePath = public_path(
                'admins/story/' . $story->image
            );

            if (
                $story->image &&
                File::exists($oldImagePath)
            ) {
                File::delete($oldImagePath);
            }


            $image = $request->file('image');

            $imageName =
                time()
                . '-'
                . Str::slug($validated['student_name'])
                . '-'
                . Str::random(6)
                . '.'
                . $image->getClientOriginalExtension();

            $destinationPath = public_path('admins/story');

            if (!File::exists($destinationPath)) {
                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }

            $image->move(
                $destinationPath,
                $imageName
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Image For Text Story
        |--------------------------------------------------------------------------
        */

        if ($validated['story_type'] === 'text') {

            $oldImagePath = public_path(
                'admins/story/' . $imageName
            );

            if (
                $imageName &&
                File::exists($oldImagePath)
            ) {
                File::delete($oldImagePath);
            }

            $imageName = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Story
        |--------------------------------------------------------------------------
        */

        $story->update([
            'student_name' =>
                trim($validated['student_name']),

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
                    : null,

            'image' =>
                $imageName,

            'image_alt' =>
                !empty($validated['image_alt'])
                    ? trim($validated['image_alt'])
                    : null,

            'is_featured' =>
                $request->boolean('is_featured'),

            'is_active' =>
                $request->boolean('is_active'),

            'display_order' =>
                $validated['display_order'] ?? 0,
        ]);


        return redirect()
            ->route('admin.student.stories.index')
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

    public function destroy(StudentStory $story)
    {
        if ($story->image) {

            $imagePath = public_path(
                'admins/story/' . $story->image
            );

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }


        $story->delete();


        return redirect()
            ->route('admin.story.index')
            ->with(
                'success',
                'Student story deleted successfully.'
            );
    }
}