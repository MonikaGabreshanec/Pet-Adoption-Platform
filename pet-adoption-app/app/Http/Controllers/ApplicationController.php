<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\LostPets;
use App\Models\Pets;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse|Response
     */
    public function create($petId)
    {
        $pet = Pets::query()->findOrFail($petId);
        return Inertia::render('Applications/Form', [
            'pet' => $pet
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request, $petId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'reason' => 'required|string',
        ]);

        Application::create([
            'pet_id' => $petId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'reason' => $request->reason,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('pets.show', ['id' => $petId])
            ->with('success', 'Your application has been successfully submitted!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return
     */
    public function show($id,$appId): Response|\Inertia\ResponseFactory
    {
        $pet = Pets::with('user')->findOrFail($id);
        $applicant= Application::with('user')->findOrFail($appId);
        return inertia('Pets/Show', [
            'pet' => $pet,
            'applicant' => $applicant,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }

    public function showApplications()
    {
        $applications = Application::with(['user', 'pet'])->get();

        return Inertia::render('Applications/PetApplications', [
            'applications' => $applications
        ]);
    }
    public function inbox()
    {
        $applications = Application::with(['user', 'pet'])
            ->whereHas('pet', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return Inertia::render('Applications/Inbox', [
            'applications' => $applications
        ]);
    }

}
