<?php

namespace App\Http\Controllers;

use App\Models\LostPets;
use App\Models\Pets;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LostPetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():Response
    {
        $lost_pets = LostPets::with('user:id,name')->latest()->paginate(9);
        return Inertia::render('Pets/LostPet/LostPets', [
            'lost_pets' => $lost_pets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create():Response{
        return Inertia::render('Pets/LostPet/AddLostPet');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'years' => 'nullable|integer|min:0',
            'months' => 'nullable|integer',
            'location'=> 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|image',
            'phone_number'=> 'required|string|max:255',
        ]);


        $imagePath = $request->file('image') ? $request->file('image')->store('pets', 'public') : null;

        LostPets::create([
            'species' => $request->species,
            'breed' => $request->breed,
            'years' => $request->years,
            'months' => $request->months,
            'location'=> $request->location,
            'gender' => $request->gender,
            'description' => $request->description,
            'phone_number'=> $request->phone_number,
            'image' => $imagePath,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('lost-pets.index')->with('success', 'Pet added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LostPets  $lostPets
     * @return \Inertia\ResponseFactory|Response
     */
    public function show($id)
    {
        $pet = LostPets::with('user')->findOrFail($id);

        return inertia('Pets/LostPet/ShowLostPet', [
            'pet' => $pet,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LostPets  $lostPets
     * @return RedirectResponse|Response
     */
    public function edit($id)
    {
        $pet = LostPets::query()->findOrFail($id);
        return Inertia::render('Pets/LostPet/EditLost', [
            'pet' => $pet
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LostPets  $lostPets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'species' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'years' => 'required|integer|min:0',
            'months' => 'required|integer',
            'location' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'phone_number'=> 'required|string|max:255',
            'image' => 'nullable|image',
        ]);


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }


        $pet = LostPets::query()->findOrFail($id);
        $pet->update($validated);

        return redirect()->route('lost-pets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LostPets  $lostPets
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $pet = LostPets::query()->findOrFail($id);

        $pet->delete();
        return redirect()->route('lost-pets.index');
    }
}
