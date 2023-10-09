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
                <i class="fas fa-exclamation-triangle blinking-icon"></i> Please fill in carefully, you cannot edit this data!!
            </div>
            <br>
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_savings')?>" method="post">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Savings Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_simpanan" name="nama_simpanan" 
                            class="form-control text-capitalize" placeholder="Savings Name">
                        </div>
                      <div class="mb-3 col-md-6">
                        <label class="form-label">Nominal<span style="color: red;">*</span></label>
                        <div class="input-group">
                            <input type="text" id="nominal_simpanan" name="nominal_simpanan"
                                   class="form-control text-capitalize" placeholder="Nominal">
                        </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-12 col-sm-12 col-xs-12">Remark<span class="required"></span>
                      </label>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <input id="keterangan_simpanan" class="form-control col-md-12 col-xs-12 text-capitalize" data-validate-length-range="6" data-validate-words="2" name="keterangan_simpanan" placeholder="Remark" required="required" type="text">
                      </div>
                    </div>
                </div>
                <a href="<?= base_url('/home/savings')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
            const namaPengguna = document.getElementById("nama_simpanan").value.trim();
            const email = document.getElementById("nominal_simpanan").value.trim();
            const ttl = document.getElementById("keterangan_simpanan").value.trim();

            // Aktifkan atau nonaktifkan tombol "Submit" berdasarkan isian
            if (namaPengguna !== "" && email !== "" && ttl !== "") {
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
        window.location.href = '<?= base_url('/home/savings') ?>'; // Ganti URL sesuai dengan URL dashboard Anda
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