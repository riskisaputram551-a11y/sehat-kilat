<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $doctors = User::where('role', 'dokter')->latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:15',
            'specialist' => 'required|string|max:100',
            'license_number' => 'required|string|max:50|unique:users',
            'bio' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'dokter',
            'specialist' => $request->specialist,
            'license_number' => $request->license_number,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Dokter berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $doctor = User::where('role', 'dokter')->findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $doctor = User::where('role', 'dokter')->findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $doctor = User::where('role', 'dokter')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->id,
            'phone' => 'nullable|string|max:15',
            'specialist' => 'required|string|max:100',
            'license_number' => 'required|string|max:50|unique:users,license_number,' . $doctor->id,
            'bio' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'specialist', 'license_number', 'bio']);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $doctor->update($data);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Data dokter berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $doctor = User::where('role', 'dokter')->findOrFail($id);
        $doctor->delete();

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Dokter berhasil dihapus!');
    }
}