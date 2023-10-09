<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="right-aligned">
                <a href="<?= base_url('/home/installments/')?>" type="submit" class="btn btn-info"><i class="fa fa-undo"></i></button></a>  
                <?php if(session()->get('level')== 2) { ?>
                <a href="<?= base_url('/home/delete_installments/'.$gas->id_angsuran)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> </button></a>  
                <?php }else{} ?>           
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
                        <th class="text-center">Loan Name</th>
                        <th class="text-center">Loan Category</th>
                        <th class="text-center">Installments</th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Remark</th>
                        <th class="text-center">Date</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_pinjaman?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_katagori?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->angsuran_ke?></td>
                    <td class="text-center text-capitalize text-dark">Rp. <?php echo number_format($gas->nominal_angsuran, 2, ',', '.') ?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->keterangan_angsuran?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->tanggal_pembayaran?></td>
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