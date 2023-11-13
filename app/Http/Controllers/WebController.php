<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Users;
use App\Models\Provinsi;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\IRS;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\KHS;

class WebController extends Controller
{
    function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $users = Users::all();

        foreach ($users as $user) {
            if ($user->user == $email && $user->password == $password && $user->peran == "mahasiswa") {
                if ($user->mahasiswa->email != NULL) {
                    // Authentication successful
                    Session::put("email", $email);
                    Session::keep("email"); // Memastikan data sesi "email" tetap ada
                    return redirect("/dashboard/mahasiswa/{$user->NIM}");
                } else {
                    return redirect("/dashboard/mahasiswa/{$user->NIM}/updateAcc");
                }
            } else if ($user->user == $email && $user->password == $password && $user->peran == "dosen") {
                // Authentication successful
                Session::put("email", $email);
                Session::keep("email"); // Memastikan data sesi "email" tetap ada
                return redirect("/dashboard/dosen/{$user->NIP}");
            } else if ($user->user == $email && $user->password == $password && $user->peran == "operator") {
                // Authentication successful
                Session::put("email", $email);
                Session::keep("email"); // Memastikan data sesi "email" tetap ada
                return redirect("/dashboard/operator/{$user->NIP}");
            }
        }

        // Authentication failed
        return "Username atau password salah";
    }


    function masukMahasiswa($nim)
    {
        $user = Users::where('NIM', $nim)->first();

        if ($user) {
            return view("dashboard.mahasiswa")->with("user", $user);
        } else {
            return view('updateAcc')->with("user", $user); // You can change this message as needed
        }
    }

    function masukKaryawan($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();

        if ($user->peran == 'dosen') {
            return view("dashboard.dosen")->with("user", $user)->with("mahasiswa", $mahasiswa);
        } else if ($user->peran == 'operator') {
            return view("dashboard.operator")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function profile($nim)
    {
        $user = Users::where('NIM', $nim)->first();

        if ($user) {
            return view("profile.mahasiswa")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function edit(Request $request, $nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $phone_number = $request->input("hp");
        $user->mahasiswa->no_HP = $phone_number;
        $user->mahasiswa->save(); // Use "->save()" to save the changes to the database

        return view("dashboard.mahasiswa")->with("user", $user)->with('success', 'Profil berhasil diedit');
    }

    function register()
    {
        $prov = Provinsi::all();
        $kotaKabData = DB::table('kota_kab')
            ->join('provinsi', 'kota_kab.kode_prov', '=', 'provinsi.kode_prov')
            ->select('kota_kab.kode_kota_kab', 'kota_kab.nama_kota_kab', 'provinsi.kode_prov')
            ->get()
            ->groupBy('kode_prov')
            ->map(function ($kotaKab) {
                return $kotaKab->pluck('nama_kota_kab', 'kode_kota_kab');
            });
        return view('updateAcc')->with("prov", $prov)->with("kotaKabData", $kotaKabData);
    }

    function addMahasiswa(Request $request)
    {
        $doswal = Dosen::all();
        $randomDosen = $doswal->random();
        $mahasiswa = new Mahasiswa();
        $user = new Users();
        $randomNumber = str_pad(mt_rand(1, 99999999999999), 14, '0', STR_PAD_LEFT);
        $mahasiswa->NIM = $randomNumber;
        $user->NIM = $randomNumber;
        $user->password = $request->input('password');
        $user->peran = "mahasiswa";
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->email = $request->input('email');
        $user->email = $request->input('email');
        $mahasiswa->kode_kota_kab = $request->input('kotakab');
        $mahasiswa->alamat = $request->input('alamat');
        $mahasiswa->no_HP = $request->input('noHP');
        $mahasiswa->jalur_masuk = $request->input('jalur_masuk');
        $mahasiswa->nama_doswal = $randomDosen->nama_doswal;
        $mahasiswa->persetujuan = "Belum Disetujui";
        $mahasiswa->status = "AKTIF";
        $mahasiswa->foto = "";
        $mahasiswa->save();
        $user->save();
        return redirect('/')->with('success', 'Data Mahasiswa Berhasil Diregister');
    }

    function akademik($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $irs = IRS::all();
        $khs = KHS::all();

        if ($user) {
            return view("academic")->with("user", $user)->with("irs", $irs)->with("khs", $khs);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function addIRS($nim)
    {
        $user = Users::where('NIM', $nim)->first();

        if ($user) {
            return view("entry.irs")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function validasi($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();
        $irs = IRS::all();
        $khs = KHS::all();

        if ($user->peran == 'dosen') {
            return view("validation")->with("user", $user)->with("mahasiswa", $mahasiswa)->with("irs", $irs)->with("khs", $khs);
        } else if ($user->peran == 'operator') {
            return view("dashboard.operator")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function getMahasiswa($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();

        return view("operation.operation")->with("user", $user)->with("mahasiswa", $mahasiswa);
    }

    function addAccount()
    {
        $lectures = Dosen::all();
        $prov = Provinsi::all();
        $kotaKabData = DB::table('kota_kab')
            ->join('provinsi', 'kota_kab.kode_prov', '=', 'provinsi.kode_prov')
            ->select('kota_kab.kode_kota_kab', 'kota_kab.nama_kota_kab', 'provinsi.kode_prov')
            ->get()
            ->groupBy('kode_prov')
            ->map(function ($kotaKab) {
                return $kotaKab->pluck('nama_kota_kab', 'kode_kota_kab');
            });
        return view("operation.addAccount")->with('prov', $prov)->with('kotaKabData', $kotaKabData)->with('lectures', $lectures);
    }

    function confirmAddAccount(Request $request)
    {
        $user = new Users();
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nama = $request->nama;
        $mahasiswa->NIM = $request->nim;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->status = $request->status;
        $mahasiswa->NIP = $request->doswal;
        $mahasiswa->save();

        $user->NIM = $mahasiswa->NIM;
        $user->peran = 'mahasiswa';
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        $user->password = $password;
        $nama = $request->nama;
        $nim = $request->nim;

        // Ambil first name dari nama
        $namaParts = explode(' ', $nama);
        $firstName = $namaParts[0];

        // Ambil 5 angka terakhir dari NIM
        $nimLast5 = substr($nim, -5);

        // Gabungkan first name dan 5 angka terakhir dari NIM
        $username = $firstName . $nimLast5;
        $user->user =$username;
        $user->save();

        return redirect()->back();
    }

    function updatePage($nim){
        $user = Users::where('NIM', $nim)->first();
        $prov = Provinsi::all();
        $kotaKabData = DB::table('kota_kab')
            ->join('provinsi', 'kota_kab.kode_prov', '=', 'provinsi.kode_prov')
            ->select('kota_kab.kode_kota_kab', 'kota_kab.nama_kota_kab', 'provinsi.kode_prov')
            ->get()
            ->groupBy('kode_prov')
            ->map(function ($kotaKab) {
                return $kotaKab->pluck('nama_kota_kab', 'kode_kota_kab');
            });
        return view('updateAcc')->with("prov", $prov)->with("kotaKabData", $kotaKabData)->with("user", $user);
    }

    function updateAcc(Request $request, $nim){
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $user = Users::where('NIM', $nim)->first();
        $pkl = new PKL();
        $skripsi = new Skripsi();
        $username = $request->input('username');
        $mahasiswa->email = $username.'@students.undip.ac.id';
        $mahasiswa->alamat = $request->input('alamat');
        $mahasiswa->no_HP = $request->input('noHP');
        $mahasiswa->jalur_masuk = $request->input('jalur_masuk');
        $mahasiswa->kode_kota_kab = $request->input('kotakab');
        $user->password = $request->input('password');
        $user->user = $request->input('username');
        $pkl->NIM = $nim;
        $pkl->status_pkl = 'belum ambil';
        $skripsi->NIM = $nim;
        $skripsi->status_skripsi = 'belum ambil';
        $mahasiswa->save();
        $user->save();
        $pkl->save();
        $skripsi->save();
        return redirect("/dashboard/mahasiswa/{$user->NIM}");
    }

    public function confirmAddIRS(Request $request, $nim) {
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $irs = new IRS();
        $irs->NIM = $nim;
        $irs->smst_aktif = $request->input('smst_aktif');
        $irs->jumlah_sks = $request->input('jumlah_sks');
        
        $filename = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_irs', $filename);

            // Simpan path file dalam database
            $irs->berkas_irs = $filename;
        }

    
        $angkatan = substr($mahasiswa->angkatan, -2);
        $semester = $request->input('smst_aktif');
        $formattedSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);
        $last5nim = substr($nim, -4);
        $irs->id_irs = 'IRS' . $angkatan . $formattedSemester . $last5nim;
        $irs->save();

        $this->copyFileIRS($filename);
    
        return redirect("/dashboard/mahasiswa/{$mahasiswa->NIM}");
    }

    public function copyFileIRS($filename)
    {
        $sourcePath = storage_path('app/berkas_irs/' . $filename);
        $destinationPath = public_path('assets/berkas_irs/' . $filename);
        File::copy($sourcePath, $destinationPath);
    }

    function addKHS($nim)
    {
        $user = Users::where('NIM', $nim)->first();

        if ($user) {
            return view("entry.khs")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    public function confirmAddKHS(Request $request, $nim) {
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $khs = new KHS();
        $khs->NIM = $nim;
        $khs->smt_aktif = $request->input('smst_aktif');
        $khs->SKS_semester = $request->input('jumlah_sks_smt');
        $khs->SKS_kumulatif = $request->input('jumlah_sksk');
        $khs->IP_smt = $request->input('ips');
        $khs->IP_Kumulatif = $request->input('ipk');
        
        $filename = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_khs', $filename);

            // Simpan path file dalam database
            $khs->berkas_khs = $filename;
        }

        $angkatan = substr($mahasiswa->angkatan, -2);
        $semester = $request->input('smst_aktif');
        $formattedSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);
        $last5nim = substr($nim, -4);
        $khs->id_khs = 'KHS' . $angkatan . $formattedSemester . $last5nim;
        $khs->save();

        $this->copyFileKHS($filename);
    
        return redirect("/dashboard/mahasiswa/{$mahasiswa->NIM}");
    }

    public function copyFileKHS($filename)
    {
        $sourcePath = storage_path('app/berkas_khs/' . $filename);
        $destinationPath = public_path('assets/berkas_khs/' . $filename);
        File::copy($sourcePath, $destinationPath);
    }

    function addPKL($nim){
        $user = Users::where('NIM', $nim)->first();

        if ($user) {
            return view("entry.pkl")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function confirmAddPKL(Request $request, $nim){
        $pkl = PKL::where('NIM', $nim)->first();
        $pkl->status_pkl = 'sedang ambil';

        $filename = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_pkl', $filename);

            // Simpan path file dalam database
            $pkl->berkas = $filename;
        }
        $pkl->save();
        $this->copyFilePKL($filename);
        return redirect("/dashboard/mahasiswa/{$pkl->NIM}");
    }

    public function copyFilePKL($filename)
    {
        $sourcePath = storage_path('app/berkas_pkl/' . $filename);
        $destinationPath = public_path('assets/berkas_pkl/' . $filename);
        File::copy($sourcePath, $destinationPath);
    }

    function addSkripsi($nim){
        $user = Users::where('NIM', $nim)->first();

        if ($user) {
            return view("entry.skripsi")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function confirmAddSkripsi(Request $request, $nim){
        $skripsi = Skripsi::where('NIM', $nim)->first();
        $skripsi->status_skripsi = 'sedang ambil';
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_skripsi', $filename);

            // Simpan path file dalam database
            $skripsi->berkas_skripsi = $filename;
        }
        $skripsi->save();
        $this->copyFileSkripsi($filename);
        return redirect("/dashboard/mahasiswa/{$skripsi->NIM}");
    }

    function copyFileSkripsi($filename)
    {
        $sourcePath = storage_path('app/berkas_skripsi/' . $filename);
        $destinationPath = public_path('assets/berkas_skripsi/' . $filename);
        File::copy($sourcePath, $destinationPath);
    }

    function validasiKHS(Request $request, $id_khs, $nip) {
        $khs = KHS::find($id_khs);
        $khs->IP_smt = $request->input('ips');
    
        // Calculate the cumulative GPA (IP_Kumulatif)
        $khsSemesters = KHS::where('NIM', $khs->NIM)->get();
        $totalIP = 0;
        $totalSMT = 0;
    
        foreach ($khsSemesters as $semester) {
            if ($semester->IP_smt != null) {
                $totalIP += $semester->IP_smt;
                $totalSMT += 1;
            }
        }
    
        if ($totalSMT > 0) {
            $khs->IP_Kumulatif = $totalIP / $totalSMT;
        } else {
            $khs->IP_Kumulatif = null; // Avoid division by zero
        }
    
        $khs->save();
        return redirect("/dashboard/dosen/{$nip}");
    }
    

}
