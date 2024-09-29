<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\LostPets;
use App\Models\Pets;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():Response
    {

        $donations = Donation::with('user:id,name')->latest()->get();
        Log::info($donations);
        return Inertia::render('Donation/Donations', [
            'donations' => $donations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create():Response
    {
        return Inertia::render('Donation/AddDonation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location'=> 'required|string|max:255',
            'image' => 'nullable|image',
            'email'=> 'required|string|max:255',
            'transaction'=> 'required|string|max:255',
            'phone_number'=> 'required|string|max:255',
        ]);


        $imagePath = $request->file('image') ? $request->file('image')->store('pets', 'public') : null;

        Donation::create([
            'title'=> $request->title,
            'description' => $request->description,
            'location'=> $request->location,
            'image' => $imagePath,
            'email'=> $request->email,
            'transaction'=> $request->transaction,
            'phone_number'=> $request->phone_number,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('donations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function show(Donation $donation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return RedirectResponse|Response
     */
    public function edit($id)
    {
        $donation = Donation::query()->findOrFail($id);
        return Inertia::render('Donation/EditDonation', [
            'donation' => $donation
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location'=> 'required|string|max:255',
            'image' => 'nullable|image',
            'email'=> 'required|string|max:255',
            'transaction'=> 'required|string|max:255',
            'phone_number'=> 'required|string|max:255',
        ]);


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }


        $donation = Donation::query()->findOrFail($id);
        $donation->update($validated);

        return redirect()->route('donations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donation  $donation
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $donation = Donation::query()->findOrFail($id);

        $donation->delete();
        return redirect()->route('donations.index');
    }
}
