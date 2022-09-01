<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller

{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'alamat' => 'required',
            'jenis_identitas' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'jenis_identitas' => $request->jenis_identitas,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 401);
            }
            return response()
                ->json([
                    'data' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
        }
    }

    public function login(Request $request)
    {
        // if (!Auth::attempt($request->only('email', 'password')))
        if (Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json([
                    'message' => 'Gagal Login'
                ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function getProfile(Request $request)
    {
        return response()
            ->json([
                'Succes' => 'true',
                auth()->user(),
                'message' => 'Data Berhasil DItampilkan'
            ]);;
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required',
                'email'   => 'required',
                'alamat' => 'required',
                'jenis_identitas' => 'required',
            ],
            [
                'name.required' => 'Masukkan nama !',
                'email.required' => 'Masukkan email !',
                'alamat.required' => 'Masukkan alamat !',
                'jenis_identitas.required' => 'Masukkan jenis identitas !',
            ]
        );
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'gagal',
                'data'    => $validator->errors()
            ], 401);
        } else {
            // $auth = new auth();

            $name = $request->name;
            $email = $request->email;
            $alamat = $request->alamat;
            $jenis_identias = $request->jenis_identitas;

            $auth = auth()->user();
            $auth->name = $name;
            $auth->email = $email;
            $auth->alamat = $alamat;
            $auth->jenis_identitas = $jenis_identias;
            $auth->save();

            $valid = $auth;
            if ($valid) {
                return response()->json([
                    'success' => true,
                    // 'id' => $id,
                    'message' => 'sukses',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'gagal',
                ], 401);
            }
        }
        return "Data profil berhasil diubah";
    }
    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Berhasil Log Out'
        ];
    }
}
