<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poin extends Model
{
    protected $table = "poins";

    protected $fillable = ['id_siswa', 'id_pelanggaran', 'tanggal', 'keterangan'];
    
    public function siswas(){
    	return $this->belongsTo('App\Siswa', 'id_siswa', 'id');
    }
    public function users(){
    	return $this->belongsTo('App\User', 'id_petugas', 'id');
    }
    public function pelanggarans(){
    	return $this->belongsTo('App\Pelanggaran', 'id_pelanggaran', 'id');
    }
}
