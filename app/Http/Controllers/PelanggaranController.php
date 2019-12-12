<?php

namespace App\Http\Controllers;

use App\Pelanggaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit = 10 , $offset = 0)
    {
        $data["count"] = Pelanggaran::count();
        $pelanggaran = array();

        foreach (Pelanggaran::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id"                 => $p->id,
                "nama_pelanggaran"   => $p->nama_pelanggaran,
                "kategori"           => $p->kategori,
                "poin"    	         => $p->poin,
                "created_at"         => $p->created_at,
                "updated_at"         => $p->updated_at
            ];

            array_push($pelanggaran, $item);
        }
        $data["Pelanggaran"] = $pelanggaran;
        $data["status"] = 1;
        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = new Pelanggaran();
            $data->nama_pelanggaran = $request->input('nama_pelanggaran');
            $data->kategori = $request->input('kategori');
            $data->poin = $request->input('poin');
            $data->save();
            return response()->json([
                'status' => '1',
                'message' => 'Data Pelanggaran berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '0',
                'message' => 'Data Pelanggaran gagal ditambahkan'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pelanggaran  $pelanggaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggaran $pelanggaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pelanggaran  $pelanggaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggaran $pelanggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pelanggaran  $pelanggaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $siswa = Pelanggaran::where('id', $request->id)->first();
		$siswa->nama_pelanggaran	= $request->nama_pelanggaran;
		$siswa->kategori 	        = $request->kategori;
        $siswa->poin                = $request->poin;
		$siswa->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Data pelanggaran berhasil diubah'
		], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pelanggaran  $pelanggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            Pelanggaran::where("id", $id)->delete();

            return response([
            	"status"	=> 1,
                "message"   => "Data Pelanggaran berhasil dihapus."
            ]);
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
