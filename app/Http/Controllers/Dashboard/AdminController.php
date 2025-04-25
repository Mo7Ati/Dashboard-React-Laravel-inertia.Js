<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::paginate();
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin = new Admin();
        return view('dashboard.admins.create', compact('admin'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'phone_number' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('password');
        $data['password'] = Hash::make($request->post('password'));

        $admin = Admin::create($data);
        return redirect()->route('dashboard.admins.index')->with('success', 'Admin Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('dashboard.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'phone_number' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('password');
        $data['password'] = Hash::make($request->post('password'));


        $admin->update($data);
        return redirect()->route('dashboard.admins.index')
            ->with('success', 'Admin Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('dashboard.admins.index')
            ->with('success', 'Admin Deleted Successfully');

    }
}
