<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        $users = User::all();
        return view('user', [
            'title' => 'User',
            'users' => $users
        ]);
    }

    public function add()
    {
        return view('add-user', [
            'title' => 'Tambah user'
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'role.required' => 'Role wajib dipilih',
        ]);

        try {
            $password = Str::lower($validated['name'] . "123");
            DB::transaction(function () use ($validated, $password) {
                $user = User::create([
                    'name' => $validated['name'],
                    'password' => bcrypt($password)
                ]);
                $user->assignRole($validated['role']);
            });

            return redirect('/users')->with('success', 'User berhasil diinput');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {

        $user = User::where('id', $id)->firstOrFail();
        $user->delete();

        return redirect('/users')->with('success', "User berhasil dihapus");
    }

    public function update($id)
    {

        $user = User::where('id', $id)->firstOrFail();
        $roles = Role::all();
        return view('update-user', [
            'title' => 'update user',
            'roles' => $roles,
            'user' => $user
        ]);
    }

    public function edit(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi',
            'role.required' => 'Role wajib dipilih'
        ]);

        $user = User::where('id', $id)->firstOrFail();
        $user->name = $validated['name'];
        $user->syncRoles([$validated['role']]);
        $user->save();

        return redirect('/users')->with('success', 'User berhasil di update');
    }

    public function changePassword()
    {
        return view('barang.change-password', [
            'title' => 'change password'
        ]);
    }

    public function storePassword(Request $request)
    {


        try {
            $validated = $request->validate([
                'password' => 'required|min:5|confirmed',
                'password_confirmation' => 'required|min:5'
            ], [
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 5 karakter',
                'password.confirmed' => 'Password dan Konfirmasi berbeda',
                'password_confirmation.required' => 'Confirm Password wajib diisi',
                'password_confirmation.min' => 'Confirm password minimal 5 karakter'
            ]);

            $user = Auth::user();

            if (Hash::check($request->password, $user->password)) {
                throw new Exception('Password baru tidak boleh sama dengan password lama');
            }

            $request->user()->update([
                'password' => bcrypt($validated['password'])
            ]);

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('success','Mengubah password berhasil dilakukan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
