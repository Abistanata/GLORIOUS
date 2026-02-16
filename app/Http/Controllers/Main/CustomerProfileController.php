<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'name'    => ['required', 'string', 'max:255'],
            // Nomor telepon wajib unik (setelah dinormalisasi di mutator User::setPhoneAttribute)
            'phone'   => ['required', 'string', 'max:20', 'unique:users,phone,'.$user->id],
            'address' => ['required', 'string', 'max:500'],
            'photo'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'phone.unique' => 'Nomor telepon sudah digunakan oleh akun lain.',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

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
