<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form id="userForm" class="form-horizontal form-label-left" novalidate  action="<?= base_url('home/aksi_edit_cooperative_officer')?>" method="post">
                 <input type="hidden" name="id" value="<?= $duar->id_user ?>">

                 <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">NIK<span style="color: red;">*</span></label>
                        <input type="number" id="nik" name="nik" 
                        class="form-control text-capitalize" placeholder="NIK" value="<?= $duar->nik?>">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Full Name<span style="color: red;">*</span></label>
                        <input type="text" id="nama_petugas" name="nama_petugas" 
                        class="form-control text-capitalize" placeholder="Full Name" value="<?= $duar->nama_petugas?>">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Address<span style="color: red;">*</span></label>
                        <input type="text" id="alamat" name="alamat" 
                        class="form-control text-capitalize" placeholder="Address" value="<?= $duar->alamat?>">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Gender<span style="color: red;">*</span></label>
                        <div class="col-12">
                            <select id="jk" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="jk" required="required">
                              <option value="<?= $duar->jk?>"><?= $duar->jk; ?></option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                          </select>
                      </div>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Telephone Number<span style="color: red;">*</span></label>
                    <input type="Number" id="no_telp" name="no_telp" 
                    class="form-control text-capitalize" placeholder="Telephone Number" oninput="maxLengthCheck(this)" value="<?= $duar->no_telp?>">
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
                    class="form-control text-capitalize" placeholder="Place and Date of Birth" value="<?= $duar->ttl?>">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Username<span style="color: red;">*</span></label>
                    <input type="text" id="username" name="username" 
                    class="form-control text-capitalize" placeholder="Username" maxlength="50" value="<?= $duar->username?>">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Level<span style="color: red;">*</span></label>
                    <div class="col-12">
                        <select id="level" class="form-control col-12" data-validate-length-range="6" data-validate-words="2" name="level" required="required">
                          <option value="<?= $duar->level?>"><?= $duar->level; ?></option>
                          <option value="1">Admin</option>
                          <option value="2">Cooperative Officer</option>
                      </select>
                  </div>
              </div>
          </div>
          <a href="<?= base_url('/home/cooperative_officer/')?>" type="submit" class="btn btn-primary">Cancel</a></button>
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
            namaPengguna: "<?= $duar->nama_petugas ?>",
            email: "<?= $duar->alamat ?>",
            no_telp: "<?= $duar->no_telp ?>",
            ttl: "<?= $duar->ttl ?>",
            username: "<?= $duar->username ?>",
            level: "<?= $duar->level ?>"
        };

        // Tambahkan event listener untuk memeriksa perubahan data pada formulir
        userForm.addEventListener("change", function() {
            // Ambil nilai saat ini dari formulir
            const currentData = {
                nik: document.getElementById("nik").value.trim(),
                namaPengguna: document.getElementById("nama_petugas").value.trim(),
                email: document.getElementById("alamat").value.trim(),
                jk: document.getElementById("jk").value,
                no_telp: document.getElementById("no_telp").value.trim(),
                ttl: document.getElementById("ttl").value.trim(),
                username: document.getElementById("username").value.trim(),
                level: document.getElementById("level").value
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
        window.location.href = '<?= base_url('/home/cooperative_officer') ?>'; // Ganti URL sesuai dengan URL dashboard Anda
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