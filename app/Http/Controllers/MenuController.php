<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Menu::paginate(10);
        return view('pages.admin.menu.index', [
            'query' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $newMenu = Menu::create($validated);
        });
        return redirect()->route('menu');
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
    public function edit($menu)
    {
        $menu = Menu::findOrFail($menu);
        return view('pages.admin.menu.edit', [
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request,  $menu)
    {
        DB::transaction(function () use ($request, $menu) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $menu = Menu::findOrFail($menu);
            $menu->update($validated);
        });
        return redirect()->route('menu');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($menu)
    {
        $menu = Menu::findOrFail($menu);
        $menu->delete();

        return redirect()->route('menu');
    }
}
