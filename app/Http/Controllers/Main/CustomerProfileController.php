<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        if ($user->role !== 'Customer') {
            return redirect()->route('main.dashboard.index');
        }
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('main.profile.edit', [
            'user' => $user,
            'categories' => $categories,
            'pageTitle' => 'Profile - Glorious Computer',
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'Customer') {
            return redirect()->route('main.dashboard.index');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone ?? $user->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('customer.profile.edit')->with('success', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'Customer') {
            return redirect()->route('main.dashboard.index');
        }

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('customer.profile.edit')->with('success', 'Password berhasil diubah.');
    }
}
