<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Locales;

class ProfileController extends Controller
{
    public function edit(){
        $user = auth()->user();
        $countries = Countries::getNames();
        $locales = Locales::getNames();
        return view('dashboard.profile.edit', compact('user', 'countries', 'locales'));
    }

    public function update(Request $request){
        $request->validate([
            'first_name' => 'required|max:100|string',
            'last_name' => 'required|max:100|string',
            'birthday' => 'nullable|date|before:today',
            'gender' => 'in:male,female',
            'country' => 'required|size:2|string',
        ]);

        $user = auth()->user();
        // dd($user);

        $user->profile->fill($request->all())->save();
        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile Edited Successeflly');
    }
}
