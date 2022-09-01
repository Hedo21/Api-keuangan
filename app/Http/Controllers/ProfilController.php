<?php

namespace App\Http\Controllers;

use App\Models\profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class profilController extends Controller
{
    /**
     * Fungsi index untuk menampilkan semua data profil
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profil = profil::orderBy('id')->paginate(15);
        $response = [
            'message' => 'Data Profil',
            'data' => $profil,
        ];
        if ($profil) {
            return response()->json([
                'success' => true,
                $response,
                'message' => 'Data Berhasil Ditampilkan!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                $response,
                'message' => 'Data Gagal Ditampilkan!',
            ], 401);
        }
    }
    /**
     * Fungsi untuk menambahkan profil baru
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $profil = new profil();
        $validator = Validator::make(
            $request->all(),
            [
                'nama'     => 'required',
                'alamat'   => 'required',
            ],
            [
                'nama.required' => 'Masukkan nama Post !',
                'alamat.required' => 'Masukkan alamat Post !',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $profil = profil::create([
                'nama'     => $request->input('nama'),
                'alamat'   => $request->input('alamat')
            ]);
            if ($profil) {
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
        }
    }
    /**
     * Fungsi Update untuk merubah data profil
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama'     => 'required',
                'alamat'   => 'required',
            ],
            [
                'nama.required' => 'Masukkan nama !',
                'alamat.required' => 'Masukkan alamat !',
            ]
        );
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'gagal',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $profil = new profil();

            $nama = $request->nama;
            $alamat = $request->alamat;

            $profil = profil::find($id);
            $profil->nama = $nama;
            $profil->alamat = $alamat;
            $profil->save();

            $valid = $profil;
            if ($valid) {
                return response()->json([
                    'success' => true,
                    'id' => $id,
                    'message' => 'sukses',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'id' => $id,
                    'message' => 'gagal',
                ], 401);
            }
        }
        return "Data profil berhasil diubah";
    }

    /**
     * Fungsi untuk menghapus data profil
     *
     * @param  \App\Models\profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function delete($id_profil)
    {
        $profil = profil::find($id_profil);
        $profil->delete();

        return "Data profil berhasil dihapus";
    }
}
