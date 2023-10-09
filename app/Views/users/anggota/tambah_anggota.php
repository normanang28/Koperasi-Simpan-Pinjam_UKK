<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_add_member')?>" method="post">

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Full Name<span style="color: red;">*</span></label>
                            <input type="text" id="nama_anggota" name="nama_anggota" 
                            class="form-control text-capitalize" placeholder="Full Name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Gender<span style="color: red;">*</span></label>
                            <div class="col-12">
                                <select id="jk" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="jk" required="required">
                                  <option>Select Gender</option>
                                  <option value="Male">Male</option>
                                  <option value="Female">Female</option>
                              </select>
                          </div>
                      </div>
                      <div class="mb-3 col-md-6">
                        <label class="form-label">Address<span style="color: red;">*</span></label>
                        <input type="text" id="alamat" name="alamat" 
                        class="form-control text-capitalize" placeholder="Address">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Telephone Number<span style="color: red;">*</span></label>
                        <input type="Number" id="no_telp" name="no_telp" 
                        class="form-control text-capitalize" placeholder="Telephone Number" oninput="maxLengthCheck(this)">
                        <script>
                            function maxLengthCheck(object) {
                                if (object.value.length > 13)
                                    object.value = object.value.slice(0, 13);
                            }
                        </script>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Place And Date Of Birth<span style="color: red;">*</span></label>
                        <input type="text" id="ttl" name="ttl" 
                        class="form-control text-capitalize" placeholder="Place and Date of Birth">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Username<span style="color: red;">*</span></label>
                        <input type="text" id="username" name="username" 
                        class="form-control text-capitalize" placeholder="Username" maxlength="50">
                    </div>
                </div>
                <a href="<?= base_url('/home/member')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
            const namaPengguna = document.getElementById("nama_anggota").value.trim();
            const email = document.getElementById("alamat").value.trim();
            const jk = document.getElementById("no_telp").value.trim;
            const ttl = document.getElementById("ttl").value.trim();
            const username = document.getElementById("username").value.trim();

            // Aktifkan atau nonaktifkan tombol "Submit" berdasarkan isian
            if (namaPengguna !== "" && email !== "" && jk && ttl !== "" !== "" && username !== "") {
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
        window.location.href = '<?= base_url('/home/member') ?>'; // Ganti URL sesuai dengan URL dashboard Anda
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