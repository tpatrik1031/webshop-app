<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRegisterRequest;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $pets = $request->user()->pets()
            ->with('media')
            ->get();

        return Inertia::render('Pets/Index', [
            'pets' => $pets,
        ]);
    }

        /**
     * @param PetRegisterRequest $request
     * @param Pet $pet
     * @return RedirectResponse
     */
    public function store(PetRegisterRequest $request, Pet $pet): RedirectResponse
    {
        $data = $request->validated();

        $pet = Pet::create([
            'name' => $data['name'],
            'bio' => $data['bio'],
            'birth_year' => $data['birth_year'],
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            $pet->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return redirect(route('pets.index'))->with('success', 'Successfully registered the pet');
    }

    /**
     * @param PetRegisterRequest $request
     * @param Pet $pet
     * @return RedirectResponse
     */
    public function update(PetRegisterRequest $request, Pet $pet): RedirectResponse
    {
        $requestData = $request->validated();

        $pet->update([
            'name' => $requestData['name'],
            'bio' => $requestData['bio'],
            'birth_year' => $requestData['birth_year'],
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            $pet->clearMediaCollection('images');
            $pet->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return redirect(route('pets.index'))->with('success', 'Pet updated successfully');
    }


    /**
     * @param Pet $pet
     * @return RedirectResponse
     */
    public function delete(Pet $pet): RedirectResponse
    {
        $pet->delete();

        return redirect(route('pets.index'))->with('success', 'Pet deleted successfully');
    }
}
