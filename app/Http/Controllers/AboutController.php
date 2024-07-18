<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAboutRequest;
use App\Http\Requests\UpdateAboutRequest;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = About::paginate(10);
        return view('pages.admin.about.index', [
            'query' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAboutRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $newAbout = About::create($validated);

            if (!empty($validated['keypoints'])) {
                foreach ($validated['keypoints'] as $keypoint) {
                    $newAbout->keypoints()->create([
                        'keypoint' => $keypoint
                    ]);
                }
            }
        });
        return redirect()->route('about');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($about)
    {
        $about = About::findOrFail($about);

        return view('pages.admin.about.edit', [
            'about' => $about
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutRequest $request, $about)
    {
        DB::transaction(function () use ($request, $about) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }
            $about = About::findOrFail($about);
            $about->update($validated);

            if (!empty($validated['keypoints'])) {
                $about->keypoints()->delete();
                foreach ($validated['keypoints'] as $keypoint) {
                    $about->keypoints()->create([
                        'keypoint' => $keypoint
                    ]);
                }
            }
        });

        return redirect()->route('about');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($about)
    {
        $about = About::findOrFail($about);
        $about->delete();

        return redirect()->route('about');
    }
}
