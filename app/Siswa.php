<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = "siswas";

    public function poins(){
        return $this->hasMany('App\Poin', 'id_siswa', 'id');
        }
}
