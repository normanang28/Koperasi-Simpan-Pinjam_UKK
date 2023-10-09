<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="right-aligned">
                <a href="<?= base_url('/home/cooperative_officer/')?>" type="submit" class="btn btn-info"><i class="fa fa-undo"></i></button></a>
                <a href="<?= base_url('/home/reset_pw/'.$gas->id_petugas_user)?>"><button class="btn btn-info" title="Reset Password"><i class="fa fa-light fa-key"></i></button></a>
                <a href="<?= base_url('/home/edit_cooperative_officer/'.$gas->id_petugas_user)?>"><button class="btn btn-warning"><i class="fa fa-edit"></i> </button></a>
                <a href="<?= base_url('/home/delete_cooperative_officer/'.$gas->id_petugas_user)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> </button></a>         
            </div>
            <br>
            <style>
              /* Gaya untuk kontainer form */
              .form-container {
                width: 300px; /* Lebar form */
                margin: 0 auto; /* Pusatkan form horizontal */
            }

            /* Gaya untuk elemen yang ada di dalam form */
            .right-aligned {
                text-align: right;
            }
        </style>
        <div class="table-responsive">
            <table class="table items-table table table-bordered table-striped verticle-middle table-responsive-sm">
                <thead>
                    <tr>
                        <th class="text-center">NIK</th>
                        <th class="text-center">Full Name</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Telephone Number</th>
                        <th class="text-center">Place And Date Of Birth</th>
                        <!-- <th class="text-center">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nik?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_petugas?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->jk?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->alamat?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->no_telp?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->ttl?></td>
                        <!-- <td>
                            <div class="button-container">
                              <a href="<?= base_url('/home/edit_cooperative_officer/'.$gas->id_petugas_user)?>"><button class="btn btn-warning"><i class="fa fa-edit"></i> </button></a>
                              <a href="<?= base_url('/home/delete_cooperative_officer/'.$gas->id_petugas_user)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> </button></a>                  
                          </div>
                      </td> -->
                  </tr>
              </tbody>
          </table>
      </div>
      <style>
       .pagination {
        display: flex;
        justify-content: flex-end; /* Mengatur angka ke kanan */
        align-items: center; /* Memusatkan elemen vertikal */
    }

    .page-numbers button {
        margin-left: 5px; /* Jarak antara tombol nomor halaman */
        font-size: 14px; /* Ukuran teks tombol nomor halaman */
        padding: 5px 10px; /* Padding tombol nomor halaman */
    }

    .center-column {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .center-column .btn {
        margin-top: 5px; /* Jarak vertikal antara tombol "Edit" dan "Hapus" */
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
</div>
</div>
</div>