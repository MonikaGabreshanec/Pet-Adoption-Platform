<?php

namespace App\Http\Controllers;

use App\Models\Pets;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;
use Inertia\Inertia;

class PetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mainPage(): Response
    {
        $pets = Pets::with('user:id,name')->latest()->get();
        return Inertia::render('MainPage', [
            'pets' => $pets,
        ]);
    }


    public function index(): Response
    {
        $pets = Pets::with('user:id,name')
            ->where('adopted', null)
            ->latest()
            ->paginate(9);

        // Return paginated data to Inertia
        return Inertia::render('Pets/Pets', [
            'pets' => $pets
        ]);
    }

    public function create(): Response{
        return Inertia::render('Pets/Create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'years' => 'required|integer|min:0',
            'months' => 'required|integer',
            'location'=> 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'health'=> 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|image',
        ]);


        $imagePath = $request->file('image') ? $request->file('image')->store('pets', 'public') : null;

        Pets::create([
            'name'=> $request->name,
            'species' => $request->species,
            'breed' => $request->breed,
            'years' => $request->years,
            'months' => $request->months,
            'location'=> $request->location,
            'gender' => $request->gender,
            'size' => $request->size,
            'health' => $request->health,
            'description' => $request->description,
            'image' => $imagePath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('pets.index')->with('success', 'Pet added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pets  $pets
     * @return \Inertia\ResponseFactory|Response
     */
    public function show($id)
    {

        $pet = Pets::with('user','adopter')->findOrFail($id);


        return inertia('Pets/Show', [
            'pet' => $pet,
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pets  $pets
     * @return RedirectResponse|Response
     */
    public function edit($id)
    {
        $pet = Pets::query()->findOrFail($id);
        return Inertia::render('Pets/Edit', [
            'pet' => $pet
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
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
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }

        $pet = Pets::query()->findOrFail($id);
        $pet->update($validated);

        return redirect()->route('pets.index')->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pets  $pets
     * @return RedirectResponse
     */
    public function destroy($id)
    {

        $pet = Pets::query()->findOrFail($id);
        $pet->delete();

        // Optionally, you can redirect the user or return a response
        return redirect()->route('pets.index');
    }

    public function markAsAdopted($id, $appId): RedirectResponse
    {

        $pet = Pets::query()->findOrFail($id);
        $pet->adopted = true;

        $pet->adopted_by = $appId;

        $pet->save();

        return redirect()->route('pets.index');
    }


}
