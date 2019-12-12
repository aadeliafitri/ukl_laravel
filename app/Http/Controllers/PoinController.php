<?php

namespace App\Http\Controllers;

use App\Poin;
use App\Siswa;
use App\Pelanggaran; 

use Illuminate\Http\Request;

class PoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit = 10, $offset = 0)
    {
        $data["count"] = Poin::count();
        $poin = array();

        foreach (Poin::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id"              => $p->id,
                "nama_siswa"      => $p->siswas->nama_siswa,
                "kelas"           => $p->siswas->kelas,
                "nis"             => $p->siswas->nis,
                "nama_pelanggaran"=> $p->pelanggarans->nama_pelanggaran,
                "kategori"        => $p->pelanggarans->kategori,
                "poin_siswa"      => $p->pelanggarans->poin,
                "tanggal"         => $p->tanggal,
            ];

            array_push($poin, $item);
        }
        $data["poin"] = $poin;
        $data["status"] = 1;
        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {
        $find = $request->find;
        $poin_siswa = Poin::with('pelanggarans')->whereHas('siswas',function ($query) use($find){
            $query->where("nama_siswa", "like", "%$find%");
        });
        $poin = array();
        foreach ($poin_siswa->get() as $p) {
          $item = [
            "tanggal" => $p->tanggal,
            "nama_pelanggaran" => $p->pelanggarans->nama_pelanggaran,
            "kategori" => $p->pelanggarans->kategori,
            "keterangan" => $p->keterangan,
            "poin" => $p->pelanggarans->poin,
          ];
          array_push($poin,$item);
        }
        $data = $poin_siswa->first();
        $nama_siswa = $data->siswas->nama_siswa;
        $nis = $data->siswas->nis;
        $kelas = $data->siswas->kelas;
        $status= 1;
        return response()->json(compact('nama_siswa','nis','kelas','poin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
            $data = new Poin();
            $data->id_siswa = $request->input('id_siswa');
            $data->id_pelanggaran = $request->input('id_pelanggaran');
            $data->tanggal = now();
            $data->keterangan = $request->input('keterangan');
            $data->id_petugas = $request->input('id_petugas');
            $data->save();
            return response()->json([
                'status' => '1',
                'message' => 'Data Poin Siswa berhasil ditambahkan'
            ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poin  $poin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poin = Poin::where('id', $id)->get();
        $poin_siswa = array();
        foreach ($poin as $p) {
            $item = [
                "id"              => $p->id,
                "id_siswa"        => $p->id_siswa,
                "id_pelanggaran"  => $p->id_pelanggaran,
                "tanggal"         => $p->tanggal,
                "keterangan"      => $p->keterangan,
                "poin_siswa"      => $p->pelanggarans->poin,
                "kategori"        => $p->pelanggarans->kategori,
            ];
            array_push($poin_siswa, $item);
        }
        $data["poinSiswa"] = $poin_siswa;
        $data["status"] = 1;
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poin  $poin
     * @return \Illuminate\Http\Response
     */
    // public function detail($id)
    // {
    //     $poin = Poin::where('id_siswa', $id)->get();
    //     $poin_siswa = array();
    //     $total = 0;
    //     foreach ($poin as $p) {
    //         $total += $p->pelanggarans->poin;
    //         $item = [
    //             "id"              => $p->id_siswa,
    //             "nama_siswa"      => $p->siswas->nama_siswa,
    //             "kelas"           => $p->siswas->kelas,
    //             "nis"             => $p->siswas->nis,
    //             "nama_pelanggaran"=> $p->pelanggarans->nama_pelanggaran,
    //             "kategori"        => $p->pelanggarans->kategori,
    //             "poin_siswa"      => $p->pelanggarans->poin,
    //             "tanggal"         => $p->tanggal,
    //         ];
    //         array_push($poin_siswa, $item);
    //     }
    //     $data['total'] = $total;
    //     $data["poinSiswa"] = $poin_siswa;
    //     $data["status"] = 1;
    //     return response($data);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poin  $poin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $poin = Poin::where('id', $request->id)->first();
		$poin->id_siswa 	    = $request->id_siswa;
		$poin->id_pelanggaran 	= $request->id_pelanggaran;
        $poin->tanggal         = now();
        $poin->keterangan      = $request->keterangan;
		$poin->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Data poin pelanggaran berhasil diubah'
		], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poin  $poin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            Siswa::where("id", $id)->delete();

            return response([
            	"status"	=> 1,
                "message"   => "Data poin pelanggaran berhasil dihapus."
            ]);
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
