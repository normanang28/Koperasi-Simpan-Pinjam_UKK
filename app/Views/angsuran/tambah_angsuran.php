<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">

            <style>
                @keyframes blink {
                    0% { opacity: 1; }
                    50% { opacity: 0; }
                    100% { opacity: 1; }
                }

                .alert i.blinking-icon {
                    animation: blink 2s infinite;
                }
            </style>
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle blinking-icon"></i> Please fill in carefully, you cannot edit and delete this data!!
            </div>
            <br>
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_installments')?>" method="post" enctype="multipart/form-data">

                    <div class="row">
                       <div class="mb-3 col-md-6">
                           <label class="control-label col-12">Photo Evidence<span style="color: red;">*</span></label>  
                           <input type="file" name="bukti" class="form-file-input form-control col-12">
                         </div>
                       <div class="mb-3 col-md-6">
                           <label class="control-label col-12">Load Name<span style="color: red;">*</span></label>  
                            <select name="id_pinjaman" class="form-control text-capitalize" id="id_pinjaman" required>
                                <option>Select Loan Name</option>
                                <?php foreach ($p as $loan) {
                                    if ($loan->status_acc == 'Approved' ) { 
                                ?>
                                    <option class="text-capitalize" value="<?php echo $loan->id_pinjaman ?>"><?php echo $loan->nama_pinjaman ?> ~ <?php echo $loan->nominal ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label class="control-label col-12">Loan Category<span style="color: red;">*</span>
                          </label>
                          <div class="col-12">
                            <select  name="id_katagori" class="form-control text-capitalize" id="id_katagori" required>
                              <option>Select Loan Category</option>
                              <?php 
                              foreach ($k as $kategori) {
                              ?>
                              <option class="text-capitalize" value="<?php echo $kategori->id_katagori ?>"><?php echo $kategori->nama_katagori ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Installments<span style="color: red;">*</span></label>
                            <input type="number" id="angsuran_ke" name="angsuran_ke" 
                            class="form-control text-capitalize" placeholder="Installments">
                        </div>
                      <div class="mb-3 col-md-6">
                        <label class="form-label">Nominal<span style="color: red;">*</span></label>
                        <div class="input-group">
                            <input type="text" id="nominal_angsuran" name="nominal_angsuran"
                                   class="form-control text-capitalize" placeholder="Nominal">
                        </div>
                    </div>
                      <div class="mb-3 col-md-6">
                      <label class="control-label col-md-12 col-sm-12 col-xs-12">Remark<span class="required"></span>
                      </label>
                        <input id="keterangan_angsuran" class="form-control col-md-12 col-xs-12 text-capitalize" data-validate-length-range="6" data-validate-words="2" name="keterangan_angsuran" placeholder="Remark" required="required" type="text">
                  </div>
                </div>
                <a href="<?= base_url('/home/installments')?>" type="submit" class="btn btn-primary">Cancel</a></button>
                <button type="submit" id="submitButton" class="btn btn-success" disabled>Submit</button>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil referensi ke formulir dan tombol "Submit"
        const userForm = document.getElementById("userForm");
        const submitButton = document.getElementById("submitButton");

        // Tambahkan event listener untuk memeriksa isian formulir saat berubah
        userForm.addEventListener("change", function() {
            // Cek apakah ada nilai yang diisi dalam setiap elemen input
            const id_pinjaman = document.getElementById("id_pinjaman").value;
            const id_katagori = document.getElementById("id_katagori").value;
            const angsuran_ke = document.getElementById("angsuran_ke").value.trim();
            const nominal_angsuran = document.getElementById("nominal_angsuran").value.trim();
            const keterangan_angsuran = document.getElementById("keterangan_angsuran").value.trim();

            // Aktifkan atau nonaktifkan tombol "Submit" berdasarkan isian
            if (id_pinjaman !== "Select Loan Name" && id_katagori !== "Select Loan Category" && angsuran_ke !== "" && nominal_angsuran !== "" && keterangan_angsuran !== "") {
                submitButton.removeAttribute("disabled");
            } else {
                submitButton.setAttribute("disabled", "disabled");
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let timeout;
    const timeoutDuration = 2 * 60 * 1000; // 2 menit dalam milidetik (1000 ms = 1 detik)

    function startTimeout() {
        clearTimeout(timeout); // Hapus timeout sebelumnya (jika ada)
        timeout = setTimeout(redirectToDashboard, timeoutDuration);
    }

    function redirectToDashboard() {
        window.location.href = '<?= base_url('/home/installments') ?>'; // Ganti URL sesuai dengan URL dashboard Anda
    }

    // Mulai timer ketika halaman dimuat atau ada aktivitas
    document.addEventListener('mousemove', startTimeout);
    document.addEventListener('keypress', startTimeout);

    // Mulai timer ketika halaman pertama dimuat
    startTimeout();

    const tableBody = document.querySelector('.table tbody');
    const pageNumbers = document.getElementById('pageNumbers');

    // Data dan variabel kontrol
    const data = <?= json_encode($duar) ?>; // Menggunakan data yang Anda ambil dari controller
    const itemsPerPage = 50;
    let currentPage = 1;
});
</script>