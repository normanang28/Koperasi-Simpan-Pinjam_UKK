<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_loan_category')?>" method="post">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Loan Category<span style="color: red;">*</span></label>
                            <input type="text" id="nama_katagori" name="nama_katagori" class="form-control text-capitalize" placeholder="Loan Category">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Remark<span style="color: red;">*</span></label>
                            <input type="text" id="keterangan_kategori" name="keterangan_kategori" class="form-control text-capitalize" placeholder="Remark">
                        </div>
                    </div>
                    <div style="margin-top: 20px;"></div>
                <a href="<?= base_url('/home/loan_category')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
            const namaPengguna = document.getElementById("nama_katagori").value.trim();
            const keterangan_kategori = document.getElementById("keterangan_kategori").value.trim();

            // Aktifkan atau nonaktifkan tombol "Submit" berdasarkan isian
            if (namaPengguna !== "" ) {
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
        window.location.href = '<?= base_url('/home/loan_category') ?>'; // Ganti URL sesuai dengan URL dashboard Anda
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