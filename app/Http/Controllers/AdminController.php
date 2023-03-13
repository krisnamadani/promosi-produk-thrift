<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data['data'] = Admin::all();

        return view('admin', $data);
    }

    public function store(Request $request)
    {
        $photo = $request->file('photo');
        $photo_name = time() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('admin'), $photo_name);
        
        $data = [
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo' => $photo_name,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];

        Admin::create($data);

        return response()->json([
            'status' => 'success',
            'title' => 'Tersimpan!',
            'message' => 'Data telah disimpan.',
            'icon' => 'success',
        ]);
    }

    public function edit(Request $request)
    {
        $data = Admin::find($request->id);

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = Admin::where('id', $request->id)->first();

        if ($request->file('photo')) {
            $photo = $request->file('photo');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('admin'), $photo_name);

            $data->photo = $photo_name;
        }

        $data->name = $request->name;
        $data->email = $request->email;

        if ($request->password) {
            $data->password = bcrypt($request->password);
        }

        $data->description = $request->description;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;

        $data->save();

        return response()->json([
            'status' => 'success',
            'title' => 'Diperbarui!',
            'message' => 'Data telah diperbarui.',
            'icon' => 'success',
        ]);
    }

    public function delete(Request $request)
    {
        $data = Admin::find($request->id);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'title' => 'Terhapus!',
            'message' => 'Data telah dihapus.',
            'icon' => 'success',
        ]);
    }
}
