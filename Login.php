<?php

class Login extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model('My_Models');
    }

    public function index(){
        $this->load->view('halaman_login');
    }

    public function do_login(){
        // memasukkan nama dari form yang di input
        $user = $this->input->post('uname');
        $pass = $this->input->post('password');

        // var login untuk mengakses ke model
        // parameter dta yang dikirim $user dan $pass
        $login = $this->My_Models->Cek_login($user,$pass);

        // ketika ada datanya (>0) maka akan menampilkan berhasil
        // kalau ga ada akan muncul gagal, ex: username dan password terdaftar jadi ada datanya, tapi kalau belum terdaftar akan gagal.

        // jika datanya ada akan di arahkan ke halaman admin
        if(count($login) > 0 ){
            
            redirect('login/admin');
            $this->session->set_userdata(array(
                'user' => $user
            ));
           
        

        }else{
            $this->session->set_flashdata('login','Periksa Username dan Password Anda');
            redirect('login/index');
        }

    }

    public function logout(){
        $this->session->unset_userdata('user');
        redirect('login/index');
    }

    public function admin(){

        $data['user'] = $this->session->userdata('user');
        $data['total_buku'] = $this->My_Models->total_buku();
        $data['total_peminjaman'] = $this->My_Models->total_peminjaman();
        $data['total_anggota'] = $this->My_Models->total_anggota();
        $this->load->view('template/header');
        $this->load->view('admin/admin', $data);
        $this->load->view('template/footer');
    }

// __________________________________________________________________________________________________________________________________________

    public function buku(){

        $data_nana['buku_nana'] = $this->My_Models->Ambil_Buku();
        $this->load->view('template/header');
        $this->load->view('admin/buku', $data_nana);
        $this->load->view('template/footer');
    }

    public function tambah_buku(){

        $this->load->view('template/header');
        $this->load->view('admin/tambah_buku');
        $this->load->view('template/footer');
    }

    public function do_tambah(){
       
       
        $this->My_Models->do_tambah();
        $this->session->set_flashdata('tambah','Data Berhasil di Tambah');
        redirect('login/buku');

        // $foto       = $_FILES['foto'] ['name']   ;
        // // foto : diambil dari name form ketika tambah foto
        // if($foto=''){
        //     echo "Tidak ada Gambar";
        // }else{
        //     $config['allowed types'] = 'jpg|img|png|gif';
        //     $config['upload_path'] = "./assets/foto";
        //     $this->load->library('upload', $config);
        //     if(!$this->upload->do_upload('foto')){
        //         echo "gagal";
        //     }else{
        //    $this->My_Models->do_tambah();
        //     }
        // }
    
    }

    public function edit($id){

        // Pertama ambil data, sesuai dengan id yang kita klik
        $data['buku'] = $this->My_Models->show_buku_nana($id);

        $this->load->view('template/header');
        $this->load->view('admin/edit_buku', $data);
        $this->load->view('template/footer');
    }

    public function do_edit(){
        
        $this->My_Models->do_edit();
        $this->session->set_flashdata('tambah','Data Berhasil di Ubah');
        redirect('login/buku');
    }

    public function lihatData($id){

        $data['buku'] = $this->My_Models->lihat_data_nana($id);
    
        $this->load->view('template/header');
        $this->load->view('admin/lihat_buku', $data);
        $this->load->view('template/footer');
    }

    public function hapus_buku($id){
        // Menerima parameter id

        $this->My_Models->do_hapus_nana($id);
        // Lalu kirimkan parameter yang kita dapat
        $this->session->set_flashdata('tambah', 'Data Berhasil Dihapus');
        redirect('login/buku');

    }


// __________________________________________________________________________________________________________________________________________

    public function anggota(){

        $data_nana['anggota_nana'] = $this->My_Models->Ambil_Anggota_Nana();
        $this->load->view('template/header');
        $this->load->view('admin/anggota', $data_nana);
        $this->load->view('template/footer');

    }

    public function tambah_anggota(){

        $this->load->view('template/header');
        $this->load->view('admin/tambah_anggota');
        $this->load->view('template/footer');

    }

    public function do_tambah_anggota(){

        $this->My_Models->do_tambah_anggota();
        $this->session->set_flashdata('tambah','Data Berhasil di Tambah');
        redirect('login/anggota');


    }

    public function lihat_anggota($id){

        $data['anggota'] = $this->My_Models->lihat_anggota($id);
        $this->load->view('template/header');
        $this->load->view('admin/lihat_anggota',$data);
        $this->load->view('template/footer');
    }

    public function edit_anggota($id){

          // Pertama ambil data, sesuai dengan id yang kita klik
          $data['anggota'] = $this->My_Models->lihat_anggota($id);

          $this->load->view('template/header');
          $this->load->view('admin/edit_anggota', $data);
          $this->load->view('template/footer');

    }

    public function do_edit_anggota(){

        $this->My_Models->do_edit_nana();
        $this->session->set_flashdata('tambah','Data Berhasil di Ubah');
        redirect('login/anggota');

    }

    public function hapus_anggota($id){

        $this->My_Models->delete_anggota_nana($id);
        $this->session->set_flashdata('tambah','Data Berhasil di Hapus');
        redirect('login/anggota');
    }

// __________________________________________________________________________________________________________________________________________
    public function peminjaman(){

        $data['peminjaman'] = $this->My_Models->get_data_peminjaman();

        $this->load->view('template/header');
        $this->load->view('admin/peminjaman',$data);
        $this->load->view('template/footer');
    }

    public function tambah_peminjaman(){

        $data_nana['anggota_nana'] = $this->My_Models->Ambil_Anggota_Nana();
        $data_nana['buku_nana'] = $this->My_Models->Ambil_Buku();

        $this->load->view('template/header');
        $this->load->view('admin/tambah_peminjaman',$data_nana);
        $this->load->view('template/footer');

    }

    public function do_tambah_peminjaman(){

        $this->My_Models->tambah_peminjaman_nana();
        $this->session->set_flashdata('tambah','Data Berhasil di Tambah');
        redirect('login/peminjaman');
    }

    public function edit_peminjaman($id){

        $data['peminjaman_nana'] = $this->My_Models->get_id_peminjaman($id);
        $data_nana['anggota_nana'] = $this->My_Models->Ambil_Anggota_Nana();
        $data_nana['buku_nana'] = $this->My_Models->Ambil_Buku();

        $this->load->view('template/header');
        $this->load->view('admin/edit_peminjaman',$data_nana);
        $this->load->view('template/footer');
    }

    public function hapus_peminjaman($id){

        $this->My_Models->delete_peminjaman_nana($id);
        $this->session->set_flashdata('tambah','Data Berhasil di Hapus');
        redirect('login/peminjaman');
    }


// __________________________________________________________________________________________________________________________________________
    public function setting(){

        $this->load->view('template/header');
        $this->load->view('admin/setting');
        $this->load->view('template/footer');
    }

    public function do_setting(){
        // do_setting ini dia ubah password admin

        $pass  = $this->input->post('pass');
        $pass2 = $this->input->post('pass2');

        if($pass == $pass2){
            // Ini dibaca, kalau input pass itu sama dengan pass2
            // artinya berhasil dia akan mengakses ke models->database
            //table admin->untuk mengganti password admin 
            $this->My_Models->edit_setting_nana();
            $this->session->set_flashdata('ubah','Password Berhasil di Ubah');
            redirect('login/setting');
        }else{
            //Tapi kalau password  pertama dan password kedua beda
            // Dia akan ada flashdata yang menampilkan warning
            $this->session->set_flashdata('ubah','Password Gagal di Ubah');
            redirect('login/setting');
        }

    }

 

 
 

 
   
}
?>