<?php

namespace App\Http\Controllers;

use App\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Siswa::count();
        $siswa = array();

        foreach (Siswa::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id"          => $p->id,
                "nis"         => $p->nis,
                "nama_siswa"  => $p->nama_siswa,
                "kelas"    	  => $p->kelas,
                "created_at"  => $p->created_at,
                "updated_at"  => $p->updated_at
            ];

            array_push($siswa, $item);
        }
        $data["siswa"] = $siswa;
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
            $data = new Siswa();
            $data->nis = $request->input('nis');
            $data->nama_siswa = $request->input('nama_siswa');
            $data->kelas = $request->input('kelas');
            $data->save();
            return response()->json([
                'status' => '1',
                'message' => 'Data Siswa berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '0',
                'message' => 'Data Siswa gagal ditambahkan'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $siswa = Siswa::where('id', $request->id)->first();
		$siswa->nis 	= $request->nis;
		$siswa->nama_siswa 	= $request->nama_siswa;
        $siswa->kelas     = $request->kelas;
		$siswa->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Data siswa berhasil diubah'
		], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            Siswa::where("id", $id)->delete();

            return response([
            	"status"	=> 1,
                "message"   => "Data siswa berhasil dihapus."
            ]);
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
