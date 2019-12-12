<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = "pelanggarans";

    public function poin_siswas(){
        return $this->hasMany('App\Poin', 'id_pelanggaran', 'id');
        }
}
