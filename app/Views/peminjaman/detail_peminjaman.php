<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="right-aligned">
                <a href="<?= base_url('/home/loan/')?>" type="submit" class="btn btn-info"><i class="fa fa-undo"></i></button></a>  
                <?php if(session()->get('level')== 2 && $gas->status_acc == 'Process') { ?>
                <a href="<?= base_url('/home/delete_loan/'.$gas->id_pinjaman)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i> </button></a>  
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
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Loan Date</th>
                        <th class="text-center">Payment Date</th>
                        <th class="text-center">Remark</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_pinjaman?></td>
                    <td class="text-center text-capitalize text-dark">Rp. <?php echo number_format($gas->nominal, 2, ',', '.') ?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->tanggal_peminjaman?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->tanggal_pelunasan?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->keterangan_pelunasan?></td>
                    <!-- <td class="text-center text-capitalize text-dark"><?php echo $gas->status_acc?></td> -->
                    <td class="text-center text-capitalize text-dark">
                        <?php if ($gas->status_acc == 'Approved'){ ?>
                            <i class="fas fa-circle text-success blinking-icon"></i> Approved
                        <?php } else { ?>
                            <i class="fas fa-circle text-warning blinking-icon"></i> Process
                        <?php } ?>
                    </td>
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

    @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Gaya untuk ikon berkedip */
        .blinking-icon {
            animation: blink 1s infinite; /* Gunakan animasi "blink" dengan durasi 1 detik dan berulang tak terbatas */
        }

        @keyframes blink-green {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes blink-orange {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Gaya untuk ikon berkedip */
        .blinking-icon {
            animation-duration: 1s; /* Durasi animasi 1 detik */
            animation-iteration-count: infinite; /* Animasi tak terbatas */
        }

        .text-success .blinking-icon {
            animation-name: blink-green; /* Animasi blink hijau */
        }

        .text-warning .blinking-icon {
            animation-name: blink-orange; /* Animasi blink oranye */
        }
</style>
</div>
</div>
</div>