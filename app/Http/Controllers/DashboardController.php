<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Siswa;
use App\User;
use App\Pelanggaran;
use App\Poin;

class DashboardController extends Controller
{
    public function dashboard() {
        $data["Jumlah Siswa"] = Siswa::count();
        $data["Jumlah Petugas"] = User::count();
        $data["Jumlah Data Pelanggaran"] = Pelanggaran::count();
        $data["Jumlah Pelanggaran hari ini"] = Poin::count();

        return response($data);
    }
}
