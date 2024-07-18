<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreHeroSectionRequest;
use App\Http\Requests\UpdateHeroSectionRequest;

class HeroSectionController extends Controller
{
    public function index()
    {
        $query = HeroSection::paginate(10);
        return view('pages.admin.hero.index', [
            'query' => $query
        ]);
    }

    public function create()
    {
        return view('pages.admin.hero.create');
    }

    public function store(StoreHeroSectionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('banner')) {
                $bannerPath = $request->file('banner')->store('banners', 'public');
                $validated['banner'] = $bannerPath;
            }

            $newHero = HeroSection::create($validated);
        });
        return redirect()->route('herosection');
    }

    public function edit($hero)
    {
        $hero = HeroSection::findOrFail($hero);
        return view('pages.admin.hero.edit', [
            'hero' => $hero
        ]);
    }

    public function update(UpdateHeroSectionRequest $request, $hero)
    {
        DB::transaction(function () use ($request, $hero) {
            $validated = $request->validated();

            if ($request->hasFile('banner')) {
                $bannerPath = $request->file('banner')->store('banners', 'public');
                $validated['banner'] = $bannerPath;
            }

            $hero = HeroSection::findOrFail($hero);
            $hero->update($validated);
        });
        return redirect()->route('herosection');
    }

    public function destroy($hero)
    {
        $hero = HeroSection::findOrFail($hero);
        $hero->delete();

        return redirect()->route('herosection');
    }
}
