<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\petugas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PengaduanController extends Controller
{
    function index()
    {
        $masyarakat =DB::table('masyarakat')->count('nama');
        $pengaduan = DB::table('pengaduan')->count('isi_laporan');
        $petugas = DB::table('petugas')->count('nama_petugas');
        $tanggapan = DB::table('tanggapan')->count('tanggapan');

        return view('/home', ['tanggapan'=>$tanggapan,'petugas'=>$petugas,'masyarakat' =>  $masyarakat, 'pengaduan' => $pengaduan]);
       
    }

    function pengaduan(){
        $pengaduan = DB::table('pengaduan')->get();
        return view('/pengaduan',['pengaduan'=>$pengaduan]);
    }

    function tampil_pengaduan()
    {
        $judul = "selamat datang";

        return view('isi-pengaduan', ['TextJudul' =>  $judul,]);
    }

    function proses_tambah_pengaduan(Request $request)
    {
        $nama_foto=$request->foto->getClientOriginalName();
        
        $request->validate([
            'isi_laporan' => 'required|min:5'
        ]);
      
        $request->foto->storeAs('public/image',$nama_foto);

        $isi_pengaduan = $request->isi_laporan;
        $nik = $request->nik;
        
        DB::table('pengaduan')->insert([
            'tgl_pengaduan' => date('y-m-d'),
            'nik' => auth::user()->nik,
            'isi_laporan' => $isi_pengaduan,
            'foto' => $request->foto->getClientOriginalName(),
            'status' => '0'
        ]);

        
        return redirect('/pengaduan')->with('info','Pengaduan Anda Telah Dibuat Silah Tunggu Balasan Dari Kami');
    }

    function hapus($id)
    {
        echo $id;
        $deleted = DB::table('pengaduan')->where('id_pengaduan', $id)->delete();
        if ($deleted) {
            return redirect('/pengaduan')->with('info2','laporan anda berhasil dihapus');
        }
    }

    function detail_pengaduan($id)
    {
        $pengaduan = DB::table('pengaduan')->where('id_pengaduan', $id)->first();
            $detail = DB::table('pengaduan')
            ->join('masyarakat', 'masyarakat.nik', '=', 'pengaduan.nik')
            ->get();

            $tanggapan = DB::table('tanggapan')
            ->join('pengaduan', 'pengaduan.id_pengaduan', '=', 'tanggapan.id_pengaduan')
            ->where('pengaduan.id_pengaduan','=',$id)
            ->get();

        return view('detail-pengaduan', ['tanggapan'=>$tanggapan,'detail'=>$detail,'pengaduan' => $pengaduan]);

    }

    function update_pengaduan($id)
    {
        $pengaduan = DB::table('pengaduan')->where('id_pengaduan', $id)->first();
        return view('update-pengaduan', ['pengaduan' => $pengaduan]);

    }

    function proses_update_pengaduan(Request $request, $id){
        $isi_laporan = $request->isi_laporan;
        $nama_foto=$request->foto->getClientOriginalName();
        $request->foto->storeAs('public/image',$nama_foto);

        DB::table('pengaduan')
        ->where('id_pengaduan', $id)
        ->update([
            'isi_laporan' => $isi_laporan,
            'foto' => $request->foto->getClientOriginalName()
    ]);

    return redirect('/pengaduan')->with('info','Laporan Anda berhasil Di Ganti');
    }
}
