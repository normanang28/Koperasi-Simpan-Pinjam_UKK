<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_edit_loan_category')?>" method="post">
                   <input type="hidden" name="id" value="<?= $duar->id_katagori  ?>">

                   <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Loan Category<span style="color: red;">*</span></label>
                        <input type="text" id="nama_katagori" name="nama_katagori" 
                        class="form-control text-capitalize" placeholder="Loan Category" value="<?= $duar->nama_katagori?>">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Remark<span style="color: red;">*</span></label>
                        <input type="text" id="keterangan_kategori" name="keterangan_kategori" 
                        class="form-control text-capitalize" placeholder="Remark" value="<?= $duar->keterangan_kategori?>">
                    </div>
            </div>
            <a href="<?= base_url('/home/loan_category')?>" type="submit" class="btn btn-primary">Cancel</a></button>
            <button type="submit" id="updateButton" class="btn btn-success" disabled>Update</button>
        </form>
    </div>
</div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil referensi ke formulir dan tombol "Update"
        const userForm = document.getElementById("userForm");
        const updateButton = document.getElementById("updateButton");

        // Ambil nilai awal data dari formulir
        const initialData = {
            namaPengguna: "<?= $duar->nama_katagori ?>",
            email: "<?= $duar->keterangan_kategori ?>",
        };

        // Tambahkan event listener untuk memeriksa perubahan data pada formulir
        userForm.addEventListener("change", function() {
            // Ambil nilai saat ini dari formulir
            const currentData = {
                namaPengguna: document.getElementById("nama_katagori").value.trim(),
                email: document.getElementById("keterangan_kategori").value.trim(),
            };

            // Cek apakah ada perubahan pada data
            const isDataChanged = Object.keys(currentData).some(key => currentData[key] !== initialData[key]);

            // Aktifkan atau nonaktifkan tombol "Update" berdasarkan perubahan data
            if (isDataChanged) {
                updateButton.removeAttribute("disabled");
            } else {
                updateButton.setAttribute("disabled", "disabled");
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