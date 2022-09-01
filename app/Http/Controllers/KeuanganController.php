<?php

namespace App\Http\Controllers;

use App\Http\Resources\keuangan as ResourcesKeuangan;
use App\Models\keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $keuangan = keuangan::orderBy('id')->paginate(15);
        $keuangan = keuangan::with('keuangan')->get();
        $response = [
            'message' => 'Data keuangan',
            'data' => $keuangan,
        ];
        if ($keuangan) {
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

    public function index_relasi()
    {
        $keuangan = keuangan::with('keuangan')->get();
        $response = [
            'message' => 'Data keuangan',
            'data' => $keuangan,
        ];
        if ($keuangan) {
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
     * Show the form for creating a new resource.
     * @param \Illuminate\Http\Request $name
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'uang_masuk'    => 'required',
                'uang_keluar'   => 'required',
            ],
            [
                'uang_masuk.required' => 'Masukkan nominal uang masuk !',
                'uang_keluar.required' => 'Masukkan nominal uang keluar !',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $keuangan = keuangan::create([
                'uang_masuk'    => $request->input('uang_masuk'),
                'uang_keluar'   => $request->input('uang_keluar')
            ]);
            if ($keuangan) {
                return response()->json([
                    'success' => true,
                    'id' => $keuangan->id,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 401);
            }
        }

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\keuangan  $keuangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id_users' => 'required',
                'uang_masuk'    => 'required',
                'uang_keluar'   => 'required',
            ],
            [
                'id_users.required' => 'Masukkan id_users !',
                'uang_masuk.required' => 'Masukkan nominal uang masuk !',
                'uang_keluar.required' => 'Masukkan nominal uang keluar !',
            ]
        );
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'gagal',
                'data'    => $validator->errors()
            ], 401);
        } else {
            $keuangan = new keuangan();

            $id_users = $request->id_users;
            $uang_masuk = $request->uang_masuk;
            $uang_keluar = $request->uang_keluar;

            $keuangan = keuangan::find($id);
            $keuangan->id_users = $id_users;
            $keuangan->uang_masuk = $uang_masuk;
            $keuangan->uang_keluar = $uang_keluar;
            $keuangan->save();
            $valid = $keuangan;
            if ($valid) {
                return response()->json([
                    'success' => true,
                    'id' => $id,
                    'message' => 'sukses',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    $id,
                    'message' => 'gagal',
                ], 401);
            }
        }
        return "Data keuangan berhasil diubah";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\keuangan  $keuangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(keuangan $keuangan)
    {
        //
    }
}
