<?php

namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\M_model;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
    public function index()
    {
    //     if(session()->get('id')==0 ) {
    //         $num1 = rand(1, 10);
    //         $num2 = rand(1, 10);
    //         echo view('login', ['num1' => $num1, 'num2' => $num2]);

    //     }else{
    //         return redirect()->to('/home/dashboard');
    // }

        if(session()->get('level')!= null) {
        $previousURL = previous_url(); // Get the URL of the previous page
        
        if ($previousURL) {
            return redirect()->to($previousURL); // Redirect to the previous page
        }

    }else{

        $model=new M_model();
        $where=array('dipakai'=>'Y');
        
        $cekSekolah=$model->getRow('settings_website',$where);
        session()->set('foto_sekolah',$cekSekolah->foto);
        session()->set('text_sekolah',$cekSekolah->text);
        session()->set('login_sekolah',$cekSekolah->login);
        session()->set('nama_website',$cekSekolah->nama_website);

        echo view('login');
    }
}

public function aksi_login()
{
    $n=$this->request->getPost('username'); 
    $p=$this->request->getPost('password');

    $captchaResponse = $this->request->getPost('g-recaptcha-response');
    $captchaSecretKey = '6Le4D6snAAAAAHD3_8OPnw4teaKXWZdefSyXn4H3';

    $verifyCaptchaResponse = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret={$captchaSecretKey}&response={$captchaResponse}"
    );

    $captchaData = json_decode($verifyCaptchaResponse);

    if (!$captchaData->success) {

        session()->setFlashdata('error', 'CAPTCHA verification failed. Please try again.');
        return redirect()->to('/Home');
    }

    $model= new M_model();
    $data=array(
        'username'=>$n, 
        'password'=>md5($p)
    );
    $cek=$model->getarray('user', $data);
    if ($cek>0) {
        $where=array('id_petugas_user'=>$cek['id_user']);
        $petugas_koperasi=$model->getarray('petugas_koperasi', $where);

            if ($petugas_koperasi) { // Check if it's a teacher
            session()->set('id', $cek['id_user']);
            session()->set('username', $cek['username']);
            session()->set('nama_petugas', $petugas_koperasi['nama_petugas']);
            session()->set('level', $cek['level']);

            $id = session()->get('id');
            $data=array(
                'id_log_user'=>session()->get('id'),
                'activity'=>"Login on the system with ID ". $id." ",
                'waktu'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            return redirect()->to('/home/dashboard');
        } else {
            $where = array('id_anggota_user' => $cek['id_user']);
            $anggota = $model->getarray('anggota', $where);

            if ($anggota) { // Check if it's a student
            if ($anggota['status_anggota'] == 'Active') {
                session()->set('id', $cek['id_user']);
                session()->set('username', $cek['username']);
                session()->set('nama_anggota', $anggota['nama_anggota']);
                session()->set('level', $cek['level']);

                $data=array(
                    'id_log_user'=>session()->get('id'),
                    'activity'=>"Login on the system with ID ". $id." ",
                    'waktu'=>date('Y-m-d H:i:s')
                );
                $model->simpan('log_activity',$data);

                return redirect()->to('/home/dashboard');
            }
        }
    }
}
return redirect()->to('/');
}

public function register()
{
    echo view('register');
}

public function aksi_register()
{
    $model=new M_model();

    $nama_anggota=$this->request->getPost('nama_anggota');
    $jk=$this->request->getPost('jk');
    $alamat=$this->request->getPost('alamat');
    $no_telp=$this->request->getPost('no_telp');
    $ttl=$this->request->getPost('ttl');
    $username=$this->request->getPost('username');

    $user=array(
        'username'=>$username,
        'password'=>md5('@dmin123'),
        'level'=> '3',
    );

    $model=new M_model();
    $model->simpan('user', $user);
    $where=array('username'=>$username);
    $id=$model->getarray('user', $where);
    $iduser = $id['id_user'];

    $anggota = array(
        'nama_anggota' => $nama_anggota,
        'jk' => 'Male',
        'alamat' => 'Data has not been filled in',
        'no_telp' => '08XXXXXXXXXXX',
        'ttl' => 'Data has not been filled in',
        'status_anggota'=>'Active',
        'id_anggota_user' => $iduser,
    );
    $model->simpan('anggota', $anggota);

    return redirect()->to('/');
}

public function log_out()
{
    if(session()->get('id') > 0) {
        $model = new M_model(); // Pastikan Anda mendefinisikan model di sini atau menggunakan instance yang benar
        $id = session()->get('id');

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Log out on the system with ID ". $id." ",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        session()->destroy();
        return redirect()->to('/');
    } else {
        return redirect()->to('/home/dashboard');
    }
}

public function dashboard()
{
    if(session()->get('id')>0) {

        $model= new M_model();
        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        $kui['s']=$model->tampil('simpanan');    
        $kui['p']=$model->tampil('pinjaman');    
        $kui['a']=$model->tampil('angsuran');    
        $kui['u']=$model->tampil('anggota');    

        echo view('header', $kui);
        echo view('menu');
        echo view('dashboard');
        echo view('footer');
    }else{
        return redirect()->to('/');
    }
}

// SETTINGS
public function settings_control()
{
    if(session()->get('level')== 1) {

        $id=session()->get('id');
        $where=array('id_settings'=> 1);
        $model=new M_model();
        $pakif['use']=$model->getRow('settings_website',$where);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('header', $kui);
        echo view('menu');
        echo view('settings', $pakif);
        echo view('footer');
    }else {
        return redirect()->to('/');
    }
}

public function aksi_change_website_settings()
{
    $model = new M_model();
    $id = $this->request->getPost('id');
    $where = array('id_settings' => $id);
    
    $logo = array();

    $photo = $this->request->getFile('foto');
    $text = $this->request->getFile('text'); 
    $login = $this->request->getFile('login'); 

    if ($photo && $photo->isValid()) {
        // Proses file foto
        $img = $photo->getRandomName();
        $photo->move(PUBLIC_PATH . '/assets/images/settings_web/', $img);
        $logo['foto'] = $img;
    }

    if ($text && $text->isValid()) {
        // Proses file teks
        $textFileName = $text->getRandomName();
        $text->move(PUBLIC_PATH . '/assets/images/settings_web/', $textFileName);
        $logo['text'] = $textFileName;
    }

    if ($login && $login->isValid()) {
        // Proses file login
        $loginFileName = $login->getRandomName();
        $login->move(PUBLIC_PATH . '/assets/images/settings_web/', $loginFileName);
        $logo['login'] = $loginFileName;
    }

    $nama_website = $this->request->getPost('nama_website');
    if (!empty($nama_website)) {
        $logo['nama_website'] = $nama_website;
    }

    if (!empty($logo)) {
        $model->edit('settings_website', $logo, $where);
    }

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Edit Website ". $nama_website." ",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/log_out');
}

// PROFILE LEVEL 1 & 2
public function profile()
{
    if(session()->get('level')== 1 || session()->get('level')== 2) {

        $id=session()->get('id');
        $where2=array('id_user'=>$id);
        $where=array('id_petugas_user'=>$id);
        $model=new M_model();
        $pakif['users']=$model->edit_pp('petugas_koperasi',$where);
        $pakif['use']=$model->edit_pp('user',$where2);

        $kui['foto']=$model->getRow('user',$where2);

        $id=session()->get('id');


        echo view('header',$kui);
        echo view('menu');
        echo view('profile', $pakif);
        echo view('footer');
    }else {
        return redirect()->to('/');
    }
}

public function aksi_change_profile()
{
        // print_r($this->request->getPost());
    $model= new M_model();
    $id=session()->get('id');
    $where=array('id_user'=>$id);
    $photo=$this->request->getFile('foto');
    $kui=$model->getRow('user',$where);
    if( $photo != '' ){}
        elseif($photo != '' && file_exists(PUBLIC_PATH."/assets/images/profile/".$kui->foto) ) 
        {
            unlink(PUBLIC_PATH."/assets/images/profile/".$kui->foto);
        }
        elseif($photo == '')
        {
            $username= $this->request->getPost('username');
            $nik= $this->request->getPost('nik');                    
            $nama_petugas= $this->request->getPost('nama_petugas');
            $jk= $this->request->getPost('jk');
            $alamat= $this->request->getPost('alamat');
            $no_telp= $this->request->getPost('no_telp');
            $ttl= $this->request->getPost('ttl');

            $user=array(
                'username'=>$username,
            );
            $model->edit('user', $user,$where);
            $where2=array('id_petugas_user'=>$id);

            $petugas_koperasi=array(
                'nik'=>$nik,
                'nama_petugas'=>$nama_petugas,
                'jk'=>$jk,
                'alamat'=>$alamat,
                'no_telp'=>$no_telp,
                'ttl'=>$ttl,
            );
            $model->edit('petugas_koperasi', $petugas_koperasi, $where2);

            $data=array(
                'id_log_user'=>session()->get('id'),
                'activity'=>"Edit Profile ". $nama_petugas." ",
                'waktu'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            return redirect()->to('/home/log_out');
        }

        $username= $this->request->getPost('username');
        $nik= $this->request->getPost('nik');                    
        $nama_petugas= $this->request->getPost('nama_petugas');
        $jk= $this->request->getPost('jk');
        $alamat= $this->request->getPost('alamat');
        $no_telp= $this->request->getPost('no_telp');
        $ttl= $this->request->getPost('ttl');

        $img = $photo->getRandomName();
        $photo->move(PUBLIC_PATH.'/assets/images/profile/',$img);
        $user=array(
            'username'=>$username,
            'foto'=>$img
        );
        $model=new M_model();
        $model->edit('user', $user,$where);

        $petugas_koperasi=array(
            'nik'=>$nik,
            'nama_petugas'=>$nama_petugas,
            'jk'=>$jk,
            'alamat'=>$alamat,
            'no_telp'=>$no_telp,
            'ttl'=>$ttl,
        );
        $where2=array('id_petugas_user'=>$id);
        $model->edit('petugas_koperasi', $petugas_koperasi, $where2);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Edit Profile ". $nama_petugas." ",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('/home/profile');
    }


// PROFILE LEVEL 3
    public function profile_member()
    {
        if(session()->get('level')== 3) {

            $id=session()->get('id');
            $where2=array('id_user'=>$id);
            $where=array('id_anggota_user'=>$id);
            $model=new M_model();
            $pakif['users']=$model->edit_pp('anggota',$where);
            $pakif['use']=$model->edit_pp('user',$where2);

            $kui['foto']=$model->getRow('user',$where2);

            $id=session()->get('id');


            echo view('header',$kui);
            echo view('menu');
            echo view('profile_member', $pakif);
            echo view('footer');
        }else {
            return redirect()->to('/');
        }
    }

    public function aksi_change_profile_member()
    {
        // print_r($this->request->getPost());
        $model= new M_model();
        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $photo=$this->request->getFile('foto');
        $kui=$model->getRow('user',$where);
        if( $photo != '' ){}
            elseif($photo != '' && file_exists(PUBLIC_PATH."/assets/images/profile/".$kui->foto) ) 
            {
                unlink(PUBLIC_PATH."/assets/images/profile/".$kui->foto);
            }
            elseif($photo == '')
            {
                $username= $this->request->getPost('username');
                $nama_anggota= $this->request->getPost('nama_anggota');
                $jk= $this->request->getPost('jk');
                $alamat= $this->request->getPost('alamat');
                $no_telp= $this->request->getPost('no_telp');
                $ttl= $this->request->getPost('ttl');

                $user=array(
                    'username'=>$username,
                );
                $model->edit('user', $user,$where);
                $where2=array('id_anggota_user'=>$id);

                $petugas_koperasi=array(
                    'nama_anggota'=>$nama_anggota,
                    'jk'=>$jk,
                    'alamat'=>$alamat,
                    'no_telp'=>$no_telp,
                    'ttl'=>$ttl,
                );
                $model->edit('anggota', $petugas_koperasi, $where2);

                $data=array(
                    'id_log_user'=>session()->get('id'),
                    'activity'=>"Edit Profile ". $nama_anggota." ",
                    'waktu'=>date('Y-m-d H:i:s')
                );
                $model->simpan('log_activity',$data);

                return redirect()->to('/home/log_out');
            }

            $username= $this->request->getPost('username');
            $nama_anggota= $this->request->getPost('nama_anggota');
            $jk= $this->request->getPost('jk');
            $alamat= $this->request->getPost('alamat');
            $no_telp= $this->request->getPost('no_telp');
            $ttl= $this->request->getPost('ttl');

            $img = $photo->getRandomName();
            $photo->move(PUBLIC_PATH.'/assets/images/profile/',$img);
            $user=array(
                'username'=>$username,
                'foto'=>$img
            );
            $model=new M_model();
            $model->edit('user', $user,$where);

            $petugas_koperasi=array(
                'nama_anggota'=>$nama_anggota,
                'jk'=>$jk,
                'alamat'=>$alamat,
                'no_telp'=>$no_telp,
                'ttl'=>$ttl,
            );
            $where2=array('id_anggota_user'=>$id);
            $model->edit('anggota', $petugas_koperasi, $where2);

            $data=array(
                'id_log_user'=>session()->get('id'),
                'activity'=>"Edit Profile ". $nama_anggota." ",
                'waktu'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            return redirect()->to('/home/log_out');
        }

// PASSWORD
        public function change_pw()  
        {
            if(session()->get('level')== 1 || session()->get('level')== 2 || session()->get('level')== 3) {

                $id=session()->get('id');
                $where2=array('id_user'=>$id);
                $model=new M_model();
                $where=array('id_user' => session()->get('id'));
                $kui['foto']=$model->getRow('user',$where);
                $pakif['use']=$model->getRow('user',$where2);

                $id=session()->get('id');
                $where=array('id_user'=>$id);

                echo view('header',$kui);
                echo view('menu',$pakif);
                echo view('password',$pakif);
                echo view('footer');
            }else{
                return redirect()->to('/');
            }
        }

        public function aksi_change_pw()   
        {
            $pass=$this->request->getPost('pw');
            $id=session()->get('id');
            $model= new M_model();

            $data=array( 
                'password'=>md5($pass)
            );

            $where=array('id_user'=>$id);
            $model->edit('user', $data, $where);

            $data=array(
                'id_log_user'=>session()->get('id'),
                'activity'=>"Edit password with ID ". $id." ",
                'waktu'=>date('Y-m-d H:i:s')
            );
            $model->simpan('log_activity',$data);

            return redirect()->to('/home/log_out');
        }

// USERS
        public function cooperative_officer()
        {
            $model=new M_model();
            $on='petugas_koperasi.id_petugas_user=user.id_user';
            $kui['duar']=$model->fusionOderBy('petugas_koperasi', 'user', $on,  'tanggal_petugas');

            $id=session()->get('id');
            $where=array('id_user'=>$id);

            $where=array('id_user' => session()->get('id'));
            $kui['foto']=$model->getRow('user',$where);

            echo view('header',$kui);
            echo view('menu');
            echo view('users/petugas_koperasi/petugas_koperasi');
            echo view('footer'); 
        }

        public function cooperative_officer_search()
        {
         if(!session()->get('id') > 0){
            return redirect()->to('/home/dashboard');
        }

        if(session()->get('level')== 1) {

            $model=new M_model();
            $on='petugas_koperasi.id_petugas_user=user.id_user';
            $where=$this->request->getPost('search_cooperative_officer');
            $kui['duar']=$model->superLike2('petugas_koperasi', 'user', $on, 'petugas_koperasi.nik','petugas_koperasi.nama_petugas', $where);
        }

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['search']="on";

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view ('header', $kui);
        echo view ('menu');
        echo view('users/petugas_koperasi/petugas_koperasi');
        echo view ('footer');
    }

    public function detail_cooperative_officer($id)
    {
        $model=new M_model();
        $where2=array('id_petugas_user'=>$id); 
        $on='petugas_koperasi.id_petugas_user=user.id_user';
        $kui['gas']=$model->detail('petugas_koperasi', 'user',$on, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('header',$kui);
        echo view('menu');
        echo view('users/petugas_koperasi/detail_petugas_koperasi');
        echo view('footer');
    }

    public function add_cooperative_officer()
    {
        $model=new M_model();
        $on='petugas_koperasi.id_petugas_user=user.id_user';
        $kui['duar']=$model->fusionOderBy('petugas_koperasi', 'user', $on,  'tanggal_petugas');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('header',$kui);
        echo view('menu');
        echo view('users/petugas_koperasi/tambah_petugas_koperasi');
        echo view('footer');
    }

    public function aksi_add_cooperative_officer()
    {
        $model=new M_model();

        $nik=$this->request->getPost('nik');
        $nama_petugas=$this->request->getPost('nama_petugas');
        $alamat=$this->request->getPost('alamat');
        $jk=$this->request->getPost('jk');
        $no_telp=$this->request->getPost('no_telp');
        $ttl=$this->request->getPost('ttl');
        $username=$this->request->getPost('username');
        $level=$this->request->getPost('level');

        $user=array(
            'username'=>$username,
            'password'=>md5('@dmin123'),
            'level'=>$level,
        );

        $model=new M_model();
        $model->simpan('user', $user);
        $where=array('username'=>$username);
        $id=$model->getarray('user', $where);
        $iduser = $id['id_user'];

        $petugas = array(
            'nik' => $nik,
            'nama_petugas' => $nama_petugas,
            'alamat' => $alamat,
            'jk' => $jk,
            'no_telp' => $no_telp,
            'ttl' => $ttl,
            'id_petugas_user' => $iduser,
        );
        $model->simpan('petugas_koperasi', $petugas);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Add account cooperative officer ". $nama_petugas." ",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('/home/cooperative_officer');
    }

    public function reset_pw($id)
    {
        $model=new M_model();
        $where=array('id_user'=>$id);
        $data=array(
            'password'=>md5('@dmin123')
        );
        $model->edit('user',$data,$where);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Reset Password account cooperative officer with ID ". $id." ",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('/home/cooperative_officer');
    }

    public function edit_cooperative_officer($id)
    {
        $model=new M_model();
        $where2=array('petugas_koperasi.id_petugas_user'=>$id);

        $on='petugas_koperasi.id_petugas_user=user.id_user';
        $kui['duar']=$model->edit_user('petugas_koperasi', 'user',$on, $where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('header',$kui);
        echo view('menu');
        echo view('users/petugas_koperasi/edit_petugas_koperasi');
        echo view('footer');
    }

    public function aksi_edit_cooperative_officer()
    {
        $id= $this->request->getPost('id');    
        $username= $this->request->getPost('username');
        $level= $this->request->getPost('level');
        $nik= $this->request->getPost('nik');
        $nama_petugas= $this->request->getPost('nama_petugas');
        $alamat= $this->request->getPost('alamat');
        $jk= $this->request->getPost('jk');
        $no_telp= $this->request->getPost('no_telp');
        $ttl= $this->request->getPost('ttl');

        $where=array('id_user'=>$id);    
        $where2=array('id_petugas_user'=>$id);
        if ($password !='') {
            $user=array(
                'username'=>$username,
                'level'=>$level,
            );
        }else{
            $user=array(
                'username'=>$username,
                'level'=>$level,
            );
        }

        $model=new M_model();
        $model->edit('user', $user,$where);

        $petugas_koperasi=array(
            'nik'=>$nik,
            'nama_petugas'=>$nama_petugas,
            'alamat' => $alamat,
            'jk'=>$jk,
            'no_telp'=>$no_telp,
            'ttl'=>$ttl,
        );

        $model->edit('petugas_koperasi', $petugas_koperasi, $where2);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Edit account cooperative officer ". $nama_petugas." with ID ". $id." ",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('/home/cooperative_officer');
    }

    public function delete_cooperative_officer($id)
    {
        $model=new M_model();
        $where2=array('id_user'=>$id);
        $where=array('id_petugas_user'=>$id);
        $model->hapus('petugas_koperasi',$where);
        $model->hapus('user',$where2);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Delete account cooperative officer with ID ". $id."",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('/home/cooperative_officer');
    }


    public function member()
    {
        $model=new M_model();
        $on='anggota.id_anggota_user=user.id_user';
        $kui['duar']=$model->fusionOderBy('anggota', 'user', $on,  'tanggal_anggota');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);
    // print_r($kui['duar'][0]);
        echo view('header',$kui);
        echo view('menu');
        echo view('users/anggota/anggota');
        echo view('footer'); 
    }

    public function member_search()
    {
     if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 1) {

        $model=new M_model();
        $on='anggota.id_anggota_user=user.id_user';
        $where=$this->request->getPost('search_member');
        $kui['duar']=$model->superLike3('anggota', 'user', $on, 'user.username','anggota.nama_anggota','anggota.no_telp', $where);
    }

    $id=session()->get('id');
    $where=array('id_user'=>$id);
    $kui['search']="on";

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view ('header', $kui);
    echo view ('menu');
    echo view('users/anggota/anggota');
    echo view ('footer');
}

public function status_not_active($id)
{
    if(session()->get('level')== 1) {

        $model=new M_model();
        $where=array('id_anggota_user'=>$id);
        $data=array(
            'status_anggota'=>"Not Active"
        );

        $model->edit('anggota', $data, $where);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Status not active account member with ID ". $id."",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('home/member');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function status_active($id)
{
    if(session()->get('level')== 1) {

        $model=new M_model();
        $where=array('id_anggota_user'=>$id);
        $data=array(
            'status_anggota'=>"Active"
        );
        $model->edit('anggota', $data, $where);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Status active account member with ID ". $id."",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('home/member');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function detail_member($id)
{
    $model=new M_model();
    $where2=array('id_anggota_user'=>$id); 
    $on='anggota.id_anggota_user=user.id_user';
    $kui['gas']=$model->detail('anggota', 'user',$on, $where2);

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('users/anggota/detail_anggota');
    echo view('footer');
}

public function add_member()
{
    $model=new M_model();
    $on='anggota.id_anggota_user=user.id_user';
    $kui['duar']=$model->fusionOderBy('anggota', 'user', $on,  'tanggal_anggota');

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('users/anggota/tambah_anggota');
    echo view('footer');
}

public function aksi_add_member()
{
    $model=new M_model();

    $nama_anggota=$this->request->getPost('nama_anggota');
    $jk=$this->request->getPost('jk');
    $alamat=$this->request->getPost('alamat');
    $no_telp=$this->request->getPost('no_telp');
    $ttl=$this->request->getPost('ttl');
    $username=$this->request->getPost('username');

    $user=array(
        'username'=>$username,
        'password'=>md5('@dmin123'),
        'level'=> '3',
    );

    $model=new M_model();
    $model->simpan('user', $user);
    $where=array('username'=>$username);
    $id=$model->getarray('user', $where);
    $iduser = $id['id_user'];

    $anggota = array(
        'nama_anggota' => $nama_anggota,
        'jk' => $jk,
        'alamat' => $alamat,
        'no_telp' => $no_telp,
        'ttl' => $ttl,
        'status_anggota'=>'Active',
        'id_anggota_user' => $iduser,
    );
    $model->simpan('anggota', $anggota);

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Add account member ". $nama_anggota."",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/member');
}

public function reset_member($id)
{
    $model=new M_model();
    $where=array('id_user'=>$id);
    $data=array(
        'password'=>md5('@dmin123')
    );
    $model->edit('user',$data,$where);

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Reset Password account member with ID ". $id." ",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/member');
}

public function edit_member($id)
{
    $model=new M_model();
    $where2=array('anggota.id_anggota_user'=>$id);

    $on='anggota.id_anggota_user=user.id_user';
    $kui['duar']=$model->edit_user('anggota', 'user',$on, $where2);

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('users/anggota/edit_anggota');
    echo view('footer');
}

public function aksi_edit_member()
{
    $id= $this->request->getPost('id');    
    $username= $this->request->getPost('username');
    $nama_anggota= $this->request->getPost('nama_anggota');
    $jk= $this->request->getPost('jk');
    $alamat= $this->request->getPost('alamat');
    $no_telp= $this->request->getPost('no_telp');
    $ttl= $this->request->getPost('ttl');

    $where=array('id_user'=>$id);    
    $where2=array('id_anggota_user'=>$id);
    if ($password !='') {
        $user=array(
            'username'=>$username,
        );
    }else{
        $user=array(
            'username'=>$username,
        );
    }

    $model=new M_model();
    $model->edit('user', $user,$where);

    $anggota=array(
        'nama_anggota'=>$nama_anggota,
        'jk'=>$jk,
        'alamat' => $alamat,
        'no_telp'=>$no_telp,
        'ttl'=>$ttl,
    );

    $model->edit('anggota', $anggota, $where2);

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Edit account member ". $nama_anggota." with ID ". $id."",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/member');
}

public function delete_member($id)
{
    $model=new M_model();
    $where2=array('id_user'=>$id);
    $where=array('id_anggota_user'=>$id);
    $model->hapus('anggota',$where);
    $model->hapus('user',$where2);

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Delete account member with ID ". $id."",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/member');
}

// SIMPANAN
public function savings()
{
    if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 2) {

        $model=new M_model();
        $on='simpanan.maker_simpanan=user.id_user';
        $kui['duar']=$model->fusionOderBy('simpanan', 'user', $on,  'tanggal_simpanan');
    }

    if(session()->get('level')== 3) {

        $model=new M_model();
        $where=array('username'=>session()->get('username'));
        $on='simpanan.maker_simpanan=user.id_user';
        $kui['duar']=$model->savings('simpanan', 'user', $on,  'tanggal_simpanan', $where);
    }

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('simpanan/simpanan');
    echo view('footer'); 
}

public function savings_search()
{
 if(!session()->get('id') > 0){
    return redirect()->to('/home/dashboard');
}

if(session()->get('level')== 2) {

    $model=new M_model();
    $on='simpanan.maker_simpanan=user.id_user';
    $where=$this->request->getPost('search_savings');
    $kui['duar']=$model->superLike3('simpanan', 'user', $on, 'simpanan.nama_simpanan','simpanan.nominal_simpanan','simpanan.tanggal_simpanan', $where);
}

$id=session()->get('id');
$where=array('id_user'=>$id);
$kui['search']="on";

$where=array('id_user' => session()->get('id'));
$kui['foto']=$model->getRow('user',$where);

echo view ('header', $kui);
echo view ('menu');
echo view('simpanan/simpanan');
echo view ('footer');
}

public function savings_search_member()
{
 if(!session()->get('id') > 0){
    return redirect()->to('/home/dashboard');
}

if(session()->get('level')== 3) {

    $model=new M_model();
    $on='simpanan.maker_simpanan=user.id_user';
    $where2=array('username'=>session()->get('username'));
    $where=$this->request->getPost('search_savings');
    $kui['duar']=$model->superLikeS('simpanan', 'user', $on, 'simpanan.nama_simpanan','simpanan.nominal_simpanan','simpanan.tanggal_simpanan', $where, $where2);
}

$id=session()->get('id');
$where=array('id_user'=>$id);
$kui['search']="on";

$where=array('id_user' => session()->get('id'));
$kui['foto']=$model->getRow('user',$where);

echo view ('header', $kui);
echo view ('menu');
echo view('simpanan/simpanan');
echo view ('footer');
}

public function add_savings()
{
    $model=new M_model();
    $on='simpanan.maker_simpanan=user.id_user';
    $kui['duar']=$model->fusion('simpanan', 'user', $on);

    $id=session()->get('id');
    $where=array('id_user'=>$id);
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu',$kui);
    echo view('simpanan/tambah_simpanan',$kui);
    echo view('footer');
}

public function detail_savings($id)
{
    $model=new M_model();
    $where2=array('id_simpanan'=>$id); 
    $on='simpanan.maker_simpanan=user.id_user';
    $kui['gas']=$model->detail('simpanan', 'user',$on, $where2);

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('simpanan/detail_simpanan',$kui);
    echo view('footer');
}

public function aksi_add_savings()
{
    $model=new M_model();
    $nama_simpanan=$this->request->getPost('nama_simpanan');
    $nominal_simpanan=$this->request->getPost('nominal_simpanan');
    $keterangan_simpanan=$this->request->getPost('keterangan_simpanan');
    $maker_simpanan=session()->get('id');
    $data=array(

        'nama_simpanan'=>$nama_simpanan,
        'nominal_simpanan'=>$nominal_simpanan,
        'keterangan_simpanan'=>$keterangan_simpanan,
        'maker_simpanan'=>$maker_simpanan
    );
    $model->simpan('simpanan',$data);

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Add a savings table ". $nama_simpanan."",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/savings');
}

public function delete_savings($id)
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $where=array('id_simpanan'=>$id);
        $model->hapus('simpanan',$where);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Delete the savings table with ID ". $id."",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('home/savings');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

// PEMINJAMAN
public function loan()
{
    if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 2) {

        $model=new M_model();
        $on='pinjaman.maker_pinjaman=user.id_user';
        $kui['duar']=$model->fusionOderBy('pinjaman', 'user', $on, 'tanggal_peminjaman');
    }

    if(session()->get('level')== 3) {

        $model=new M_model();
        $where=array('username'=>session()->get('username'));
        $on='pinjaman.maker_pinjaman=user.id_user';
        $kui['duar']=$model->savings('pinjaman', 'user', $on, 'tanggal_peminjaman', $where);
    }

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('peminjaman/test');
    echo view('footer'); 
}

public function detail_loan($id)
{
    $model=new M_model();
    $where2=array('id_pinjaman'=>$id); 
    $on='pinjaman.maker_pinjaman=user.id_user';
    $kui['gas']=$model->detail('pinjaman', 'user',$on, $where2);

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('peminjaman/detail_peminjaman');
    echo view('footer');
}

public function loan_search()
{
 if(!session()->get('id') > 0){
    return redirect()->to('/home/dashboard');
}

if(session()->get('level')== 2) {

    $model=new M_model();
    $on='pinjaman.maker_pinjaman=user.id_user';
    $where=$this->request->getPost('search_loan');
    $kui['duar']=$model->superLike3('pinjaman', 'user', $on, 'pinjaman.nama_pinjaman','pinjaman.nominal','pinjaman.tanggal_peminjaman', $where);
}

$id=session()->get('id');
$where=array('id_user'=>$id);
$kui['search']="on";

$where=array('id_user' => session()->get('id'));
$kui['foto']=$model->getRow('user',$where);

echo view ('header', $kui);
echo view ('menu');
echo view('peminjaman/test');
echo view ('footer');
}

public function loan_search_member()
{
 if(!session()->get('id') > 0){
    return redirect()->to('/home/dashboard');
}

if(session()->get('level')== 3) {

    $model=new M_model();
    $on='pinjaman.maker_pinjaman=user.id_user';
    $where2=array('username'=>session()->get('username'));
    $where=$this->request->getPost('search_loan');
    $kui['duar']=$model->superLikeS('pinjaman', 'user', $on, 'pinjaman.nama_pinjaman','pinjaman.nominal','pinjaman.tanggal_peminjaman', $where, $where2);
}

$id=session()->get('id');
$where=array('id_user'=>$id);
$kui['search']="on";

$where=array('id_user' => session()->get('id'));
$kui['foto']=$model->getRow('user',$where);

echo view ('header', $kui);
echo view ('menu');
echo view('peminjaman/test');
echo view ('footer');
}

public function status_acc_loan()
{
    if (session()->get('level') == 2) {
        $ids = $this->request->getPost('loan_loan');

        // Check if $ids is an array
        if (is_array($ids)) {
            $modelPinjaman = new M_model(); // Ganti M_modelPinjaman dengan model yang sesuai untuk tabel pinjaman
            $modelKategori = new M_model(); // Ganti M_modelKategori dengan model yang sesuai untuk tabel kategori
            $model_3 = new M_model(); // Ganti M_modelKategori dengan model yang sesuai untuk tabel kategori

            $data = array(
                'status_acc' => "Approved"
            );

            foreach ($ids as $id) {
                $where = array('id_pinjaman' => $id);
                $modelPinjaman->edit('pinjaman', $data, $where);

                $where = array('id_pinjaman' => $id);
                $modelKategori->edit('pinjaman_laporan', $data, $where);

                $data=array(
                    'id_log_user'=>session()->get('id'),
                    'activity'=>"Approved status on the loan table with ID ". $id."",
                    'waktu'=>date('Y-m-d H:i:s')
                );
                $model_3->simpan('log_activity',$data);

            }

            return redirect()->to('home/loan');
        } else {
            return redirect()->to('home/loan')->with('error', 'Invalid input data');
        }
    } else {
        return redirect()->to('/home/dashboard');
    }
}


public function add_loan()
{
    $model=new M_model();
    $on='pinjaman.maker_pinjaman=user.id_user';
    $kui['duar']=$model->fusion('pinjaman', 'user', $on);

    $id=session()->get('id');
    $where=array('id_user'=>$id);
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu',$kui);
    echo view('peminjaman/tambah_peminjaman');
    echo view('footer');
}

public function aksi_add_loan()
{
    $model=new M_model();
    $nama_pinjaman=$this->request->getPost('nama_pinjaman');
    $nominal=$this->request->getPost('nominal');
    $tanggal_pelunasan=$this->request->getPost('tanggal_pelunasan');
    $keterangan_pelunasan=$this->request->getPost('keterangan_pelunasan');
    $maker_pinjaman=session()->get('id');
    $data=array(

        'nama_pinjaman'=>'Loan ' . $nama_pinjaman,
        'nominal'=>$nominal,
        'tanggal_pelunasan'=>$tanggal_pelunasan,
        'keterangan_pelunasan'=>$keterangan_pelunasan,
        'status_acc'=>'Process',
        'maker_pinjaman'=>$maker_pinjaman
    );

    $data_2=array(

        'nama_pinjaman'=>'Loan ' . $nama_pinjaman,
        'nominal'=>$nominal,
        'tanggal_pelunasan'=>$tanggal_pelunasan,
        'keterangan_pelunasan'=>$keterangan_pelunasan,
        'status_acc'=>'Process',
        'maker_pinjaman'=>$maker_pinjaman
    );

    $model->simpan('pinjaman',$data);
    $model->simpan('pinjaman_laporan',$data_2);

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Add a loan table ". $nama_pinjaman."",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/loan');
}

public function delete_loan($id)
{
    if(session()->get('level')== 2) {

        $model_1=new M_model();
        $model_2=new M_model();
        $model_3=new M_model();

        $where=array('id_pinjaman'=>$id);
        $model_1->hapus('pinjaman',$where);

        $where=array('id_pinjaman'=>$id);
        $model_2->hapus('pinjaman_laporan',$where);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Delete the loan table with ID ". $id."",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model_3->simpan('log_activity',$data);

        return redirect()->to('home/loan');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

// ANGSURAN
public function installments()
{
    if(!session()->get('id') > 0){
        return redirect()->to('/home/dashboard');
    }

    if(session()->get('level')== 2) {

        $model=new M_model();
        $on='angsuran.id_angsuran_peminjaman=pinjaman.id_pinjaman';
        $on2='angsuran.id_angsuran_kategori=katagori_pinjaman.id_katagori';
        $on3='angsuran.maker_angsuran=user.id_user';
        $kui['duar']=$model->ultraOderBy('angsuran', 'pinjaman', 'katagori_pinjaman', 'user', $on, $on2, $on3, 'tanggal_pembayaran');
    }

    if(session()->get('level')== 3) {

        $model=new M_model();
        $where=array('username'=>session()->get('username'));
        $on='angsuran.id_angsuran_peminjaman=pinjaman.id_pinjaman';
        $on2='angsuran.id_angsuran_kategori=katagori_pinjaman.id_katagori';
        $on3='angsuran.maker_angsuran=user.id_user';
        $kui['duar']=$model->angsuran('angsuran', 'pinjaman', 'katagori_pinjaman', 'user', $on, $on2, $on3, 'tanggal_pembayaran', $where);
    }

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('angsuran/angsuran');
    echo view('footer'); 
}

public function detail_installments($id)
{
    $model=new M_model();
    $where2=array('id_angsuran'=>$id); 
    $on='angsuran.id_angsuran_peminjaman=pinjaman.id_pinjaman';
    $on2='angsuran.id_angsuran_kategori=katagori_pinjaman.id_katagori';
    $on3='angsuran.maker_angsuran=user.id_user';
    $kui['gas']=$model->detail_angsuran('angsuran', 'pinjaman', 'katagori_pinjaman', 'user', $on, $on2, $on3, $where2);

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('angsuran/detail_angsuran');
    echo view('footer');
}

public function installments_search()
{
 if(!session()->get('id') > 0){
    return redirect()->to('/home/dashboard');
}

if(session()->get('level')== 2) {

    $model=new M_model();
    $on='angsuran.id_angsuran_peminjaman=pinjaman.id_pinjaman';
    $on2='angsuran.id_angsuran_kategori=katagori_pinjaman.id_katagori';
    $on3='angsuran.maker_angsuran=user.id_user';
    $where=$this->request->getPost('search_installments');
    $kui['duar']=$model->superLike5('angsuran', 'pinjaman', 'katagori_pinjaman', 'user', $on, $on2, $on3, 'pinjaman.nama_pinjaman','katagori_pinjaman.nama_katagori','angsuran.angsuran_ke', 'angsuran.nominal_angsuran', 'angsuran.tanggal_pembayaran', $where);
}

$id=session()->get('id');
$where=array('id_user'=>$id);
$kui['search']="on";

$where=array('id_user' => session()->get('id'));
$kui['foto']=$model->getRow('user',$where);

echo view ('header', $kui);
echo view ('menu');
echo view('angsuran/angsuran');
echo view ('footer');
}

public function installments_search_member()
{
 if(!session()->get('id') > 0){
    return redirect()->to('/home/dashboard');
}

if(session()->get('level')== 3) {

    $model=new M_model();
    $on='angsuran.id_angsuran_peminjaman=pinjaman.id_pinjaman';
    $on2='angsuran.id_angsuran_kategori=katagori_pinjaman.id_katagori';
    $on3='angsuran.maker_angsuran=user.id_user';
    $where2=array('username'=>session()->get('username'));
    $where=$this->request->getPost('search_installments');
    $kui['duar']=$model->superLikeAngsuran('angsuran', 'pinjaman', 'katagori_pinjaman', 'user', $on, $on2, $on3, 'pinjaman.nama_pinjaman','katagori_pinjaman.nama_katagori','angsuran.angsuran_ke', 'angsuran.nominal_angsuran', 'angsuran.tanggal_pembayaran', $where, $where2);
}

$id=session()->get('id');
$where=array('id_user'=>$id);
$kui['search']="on";

$where=array('id_user' => session()->get('id'));
$kui['foto']=$model->getRow('user',$where);

echo view ('header', $kui);
echo view ('menu');
echo view('angsuran/angsuran');
echo view ('footer');
}

public function add_installments()
{
    $model=new M_model();
    $on='angsuran.id_angsuran_peminjaman=pinjaman.id_pinjaman';
    $on2='angsuran.id_angsuran_kategori=katagori_pinjaman.id_katagori';
    $on3='angsuran.maker_angsuran=user.id_user';
    $kui['duar']=$model->ultra('angsuran', 'pinjaman', 'katagori_pinjaman', 'user', $on, $on2, $on3);

    $id=session()->get('id');
    $where=array('id_user'=>$id);
    $kui['foto']=$model->getRow('user',$where);

    $kui['p']=$model->tampil('pinjaman'); 
    $kui['k']=$model->tampil('katagori_pinjaman'); 

    echo view('header',$kui);
    echo view('menu');
    echo view('angsuran/tambah_angsuran');
    echo view('footer');
}

public function aksi_add_installments()
{
    $model=new M_model();
    $pinjaman=$this->request->getPost('id_pinjaman');
    $katagori_peminjaman=$this->request->getPost('id_katagori');
    $angsuran_ke=$this->request->getPost('angsuran_ke');
    $nominal_angsuran=$this->request->getPost('nominal_angsuran');
    $keterangan_angsuran=$this->request->getPost('keterangan_angsuran');
    $maker_angsuran=session()->get('id');
    $data=array(

        'id_angsuran_peminjaman'=> $pinjaman,
        'id_angsuran_kategori'=> $katagori_peminjaman,
        'angsuran_ke'=> 'installments ' . $angsuran_ke,
        'nominal_angsuran'=>$nominal_angsuran,
        'keterangan_angsuran'=>$keterangan_angsuran,
        'maker_angsuran'=>$maker_angsuran
    );

    try {
        $foto = $this->request->getFile('bukti');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move(ROOTPATH . '/public/bukti/', $newName);
            $data['bukti'] = $newName; // Add the uploaded file name to the data
        }

        $model->simpan('angsuran',$data);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Add a installments table ". $angsuran_ke." ",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('/home/installments');
    } catch (\Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

public function download($file_name)
{
        // Assuming your uploaded files are stored in the "uploads" directory
    $file_path = FCPATH . 'bukti/' . $file_name;
        // $file_name = 'rz.png'; // This is the name of the file to be downloaded

    if (file_exists($file_path)) {
            // Set appropriate headers

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Length: ' . filesize($file_path));

            // Send the file to the browser
        readfile($file_path);
        exit;
    } else {
            // File not found
        die('File not found.');
    }
}

public function delete_installments($id)
{
    if(session()->get('level')== 2) {

        $model=new M_model();
        $where=array('id_angsuran'=>$id);
        $model->hapus('angsuran',$where);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Delete a installments table with ID ". $id." ",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('home/installments');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

// KATEGORI PEMINJAMAN
public function loan_category()
{
    $model=new M_model();
    $kui['duar']=$model->tampilOrderBy('katagori_pinjaman', 'tanggal_kategori');

    $id=session()->get('id');
    $where=array('id_user'=>$id);

    $where=array('id_user' => session()->get('id'));
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu');
    echo view('kategori_peminjaman/ketegori_peminjaman');
    echo view('footer'); 
}

public function add_loan_category()
{
    $model=new M_model();
    $on='katagori_pinjaman.maker_maker=user.id_user';
    $kui['duar']=$model->fusion('katagori_pinjaman', 'user', $on);

    $id=session()->get('id');
    $where=array('id_user'=>$id);
    $kui['foto']=$model->getRow('user',$where);

    echo view('header',$kui);
    echo view('menu',$kui);
    echo view('kategori_peminjaman/tambah_kategori',$kui);
    echo view('footer');
}

public function aksi_add_loan_category()
{
    $model=new M_model();
    $nama_katagori=$this->request->getPost('nama_katagori');
    $keterangan_kategori=$this->request->getPost('keterangan_kategori');
    $maker_maker=session()->get('id');
    $data=array(

        'nama_katagori'=>$nama_katagori,
        'keterangan_kategori'=>$keterangan_kategori,
        'maker_maker'=>$maker_maker,
    );
    $model->simpan('katagori_pinjaman',$data);

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Add a loan category table ". $nama_katagori." ",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/loan_category');
}

public function delete_loan_category($id)
{
    if(session()->get('level')== 2) {

        $model=new M_model();
        $where=array('id_katagori'=>$id);
        $model->hapus('katagori_pinjaman',$where);

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Delete the loan category table ". $nama_katagori." with ID ". $id."",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        return redirect()->to('home/loan_category');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function edit_loan_category($id)
{
    if(session()->get('level')== 2) {

        $model=new M_model();
        $where=array('katagori_pinjaman.id_katagori'=>$id);

        $on='katagori_pinjaman.maker_maker=user.id_user';
        $kui['duar']=$model->edit_kategori('katagori_pinjaman', 'user', $on, $where);

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view('header',$kui);
        echo view('menu');
        echo view('kategori_peminjaman/edit_kategori',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function aksi_edit_loan_category()
{
    $model=new M_model();
    $id=$this->request->getPost('id');
    $nama_katagori=$this->request->getPost('nama_katagori');
    $keterangan_kategori=$this->request->getPost('keterangan_kategori');
    $maker_maker=session()->get('id');

    $data=array(
        'nama_katagori'=>$nama_katagori,
        'keterangan_kategori'=>$keterangan_kategori,
        'maker_maker'=>$maker_maker
    );

    $where=array('id_katagori'=>$id);
    $model->edit('katagori_pinjaman',$data,$where);

    $data=array(
        'id_log_user'=>session()->get('id'),
        'activity'=>"Edit the loan category table ". $nama_katagori." with ID ". $id."",
        'waktu'=>date('Y-m-d H:i:s')
    );
    $model->simpan('log_activity',$data);

    return redirect()->to('/home/loan_category');
}

// LOG ACTIVITY
public function log_activity()
{
    if(session()->get('level')== 1 || session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $where=array('log_activity.id_log_user'=>session()->get('id'));
        $on='log_activity.id_log_user=user.id_user';
        $kui['duar'] = $model->log('log_activity', 'user', $on, $where, 'waktu');

        $id=session()->get('id');
        $where=array('id_user'=>$id);

        $where=array('id_user' => session()->get('id'));
        $kui['foto']=$model->getRow('user',$where);

        echo view ('header', $kui);
        echo view ('menu');
        echo view ('log_activity/log');
        echo view ('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function log_search()
{
 if(!session()->get('id') > 0){
    return redirect()->to('/home/dashboard');
}

if(session()->get('level')== 1 || session()->get('level')== 2 || session()->get('level')== 3) {

    $model=new M_model();
    $on='log_activity.id_log_user=user.id_user';
    $where2=array('username'=>session()->get('username'));
    $where=$this->request->getPost('search_log');
    $kui['duar']=$model->superLikeLog('log_activity', 'user', $on, 'log_activity.activity','log_activity.waktu', $where, $where2);
}

$id=session()->get('id');
$where=array('id_user'=>$id);
$kui['search']="on";

$where=array('id_user' => session()->get('id'));
$kui['foto']=$model->getRow('user',$where);

echo view ('header', $kui);
echo view ('menu');
echo view ('log_activity/log');
echo view ('footer');
}

// LAPORAN
public function savings_report()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $kui['kunci']='view_savings';

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);

        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('laporan/filter',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function cari_savings()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_invoice('simpanan',$awal,$akhir);
        // $img = file_get_contents(
        //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

        // $kui['foto'] = base64_encode($img);
        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in Printed Format ~ Savings",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        echo view('laporan/c_savings',$kui);

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function pdf_savings()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_invoice('simpanan',$awal,$akhir);
        // $img = file_get_contents(
        //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

        // $kui['foto'] = base64_encode($img);
        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in PDF Format ~ Savings",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        $dompdf = new\Dompdf\Dompdf();
        $dompdf->loadHtml(view('laporan/c_savings',$kui));
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();
        $dompdf->stream('my.pdf', array('Attachment'=>0));

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function excel_savings()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $data=$model->filter_invoice('simpanan',$awal,$akhir);

        $spreadsheet=new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Savings Name')
        ->setCellValue('B1', 'Nominal')
        ->setCellValue('C1', 'Remark')
        ->setCellValue('D1', 'Maker');

        $column = 2;
        $level = session()->get('level');

        foreach ($data as $data) {
            if ($level == 3 ? $data->username == session()->get('username') : true) {
                $formattedNominal = 'Rp. ' . number_format($data->nominal_simpanan, 2, ',', '.');
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data->nama_simpanan)
                ->setCellValue('B' . $column, $formattedNominal)
                ->setCellValue('C' . $column, $keterangan_simpanan)
                ->setCellValue('D' . $column, $data->username . '/' . $data->tanggal_simpanan);

                $column++;
            }
        }

        $writer = new XLsx($spreadsheet);
        $fileName = 'Savings and Loan Cooperative savings report ~ SLC';

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in Excel Format ~ Savings",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        header('Content-type:vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }else{
        return redirect()->to('/home/dashboard');
    }
}


public function loan_report()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $kui['kunci']='view_loan';

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);

        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('laporan/filter',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function cari_loan()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_loan('pinjaman_laporan',$awal,$akhir);
        // $img = file_get_contents(
        //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

        // $kui['foto'] = base64_encode($img);
        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in Printed Format ~ Loan",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        echo view('laporan/c_loan',$kui);

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function pdf_loan()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_loan('pinjaman_laporan',$awal,$akhir);
        // $img = file_get_contents(
        //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

        // $kui['foto'] = base64_encode($img);
        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in PDF Format ~ Loan",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        $dompdf = new\Dompdf\Dompdf();
        $dompdf->loadHtml(view('laporan/c_loan',$kui));
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();
        $dompdf->stream('my.pdf', array('Attachment'=>0));

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function excel_loan()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $data=$model->filter_loan('pinjaman_laporan',$awal,$akhir);

        $spreadsheet=new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Loan Name')
        ->setCellValue('B1', 'Nominal')
        ->setCellValue('C1', 'Loan Date')
        ->setCellValue('D1', 'Payment Date')
        ->setCellValue('E1', 'Remark')
        ->setCellValue('F1', 'Maker');

        $column = 2;
        $level = session()->get('level');

        foreach ($data as $data) {
            if ($level == 3 ? $data->username == session()->get('username') : true) {
                $formattedNominal = 'Rp. ' . number_format($data->nominal, 2, ',', '.');
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data->nama_pinjaman)
                ->setCellValue('B' . $column, $formattedNominal)
                ->setCellValue('C' . $column, $tanggal_peminjaman)
                ->setCellValue('D' . $column, $data->tanggal_pelunasan)
                ->setCellValue('E' . $column, $data->keterangan_pelunasan)
                ->setCellValue('F' . $column, $data->username . '/' . $data->tanggal_peminjaman);

                $column++;
            }
        }

        $writer = new XLsx($spreadsheet);
        $fileName = 'Savings and Loan Cooperative loan report ~ SLC';

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in Excel Format ~ Loan",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        header('Content-type:vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }else{
        return redirect()->to('/home/dashboard');
    }
}


public function installments_report()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $kui['kunci']='view_installments';

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);

        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('laporan/filter',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function cari_installments()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_angsuran('angsuran',$awal,$akhir);
        // $img = file_get_contents(
        //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

        // $kui['foto'] = base64_encode($img);
        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in Printed Format ~ Installments",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        echo view('laporan/c_installments',$kui);

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function pdf_installments()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_angsuran('angsuran',$awal,$akhir);
        // $img = file_get_contents(
        //     'C:\xampp\htdocs\laporan_keuangan\public\assets\images\KOP_PH.jpg');

        // $kui['foto'] = base64_encode($img);
        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in PDF Format ~ Installments",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        $dompdf = new\Dompdf\Dompdf();
        $dompdf->loadHtml(view('laporan/c_installments',$kui));
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();
        $dompdf->stream('my.pdf', array('Attachment'=>0));

    }else{
        return redirect()->to('/home/dashboard');
    }
}
public function excel_installments()
{
    if(session()->get('level')== 2 || session()->get('level')== 3) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $data=$model->filter_angsuran('angsuran',$awal,$akhir);

        $spreadsheet=new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Loan Name')
        ->setCellValue('B1', 'Loan Category')
        ->setCellValue('C1', 'Installments')
        ->setCellValue('D1', 'Nominal')
        ->setCellValue('E1', 'Remark')
        ->setCellValue('F1', 'Date')
        ->setCellValue('G1', 'Maker');

        $column = 2;
        $level = session()->get('level');

        foreach ($data as $data) {
            if ($level == 3 ? $data->username == session()->get('username') : true) {
                $formattedNominal = 'Rp. ' . number_format($data->nominal_angsuran, 2, ',', '.');
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data->nama_pinjaman)
                ->setCellValue('B' . $column, $data->nama_katagori)
                ->setCellValue('C' . $column, $angsuran_ke)
                ->setCellValue('D' . $column, $formattedNominal)
                ->setCellValue('E' . $column, $data->keterangan_angsuran)
                ->setCellValue('F' . $column, $data->tanggal_pembayaran)
                ->setCellValue('G' . $column, $data->username . '/' . $data->tanggal_pembayaran);

                $column++;
            }
        }

        $writer = new XLsx($spreadsheet);
        $fileName = 'Savings and Loan Cooperative installments report ~ SLC';

        $data=array(
            'id_log_user'=>session()->get('id'),
            'activity'=>"Displays Savings and Loans Cooperative Reports in Excel Format ~ Installments",
            'waktu'=>date('Y-m-d H:i:s')
        );
        $model->simpan('log_activity',$data);

        header('Content-type:vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }else{
        return redirect()->to('/home/dashboard');
    }
}
}
