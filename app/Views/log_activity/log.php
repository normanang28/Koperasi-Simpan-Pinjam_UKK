<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="header-left">
            <form action="<?= base_url('home/log_search') ?>" method="post">
                    <div class="input-group search-area">
                        <input type="text" class="form-control text-capitalize" name="search_log" placeholder="Search here...">
                        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                    </div>
                </form>
            </div>
            <br>
            <div class="right-aligned">
                <?php if(!empty($search)) {?>
                    <a href="<?= base_url('/home/log_activity/')?>"><button class="btn btn-info"><i class="fa fa-undo"></i> Back</button></a>
                <?php }?>
            </div>
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
            <style>
                /* Gaya default untuk placeholder */
                .search-area input::placeholder {
                    color: #999; /* Warna placeholder default */
                    transition: color 0.3s; /* Transisi warna selama 0.3 detik */
                }

                /* Gaya untuk placeholder yang berkedip */
                .search-area input:focus::placeholder {
                    color: #ff0000; /* Warna yang diinginkan ketika berkedip */
                }
            </style>
           <div class="table-responsive">
            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Activity</th>
                        <th class="text-center">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no=1;
                    foreach ($duar as $gas){
                      ?>
                      <tr>
                          <th class="text-center"><?php echo $no++ ?></th>
                          <td class="text-capitalize text-center"><?php echo $gas->username?></td>      
                          <td class="text-capitalize text-center"><?php echo $gas->activity?></td>
                          <td class="text-capitalize text-center"><?php echo $gas->waktu?></td>
                      </tr>
                  <?php }?>
                  
              </tbody>
          </table>
      </div>
      <div class="pagination">
        <nav>
            <ul class="pagination pagination-sm">
                <li class="page-item page-indicator" id="previousPageButton">
                    <a class="page-link" href="javascript:void(0)">
                        <i class="la la-angle-left"></i></a>
                    </li>
                    <li class="page-item" id="currentPageNumber">1</li>
                    <li class="page-item page-indicator" id="nextPageButton">
                        <a class="page-link" href="javascript:void(0)">
                            <i class="la la-angle-right"></i></a>
                        </li>
                    </ul>
                </nav>
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

            .button-container {
                display: flex;
                justify-content: center; /* Mengatur tombol-tombol di tengah secara horizontal */
                align-items: center;
            }

            .button-container a {
                margin: 0 5px; /* Tambahkan ruang di kiri dan kanan tombol */
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tableBody = document.querySelector('.table tbody');
                const currentPageNumber = document.getElementById('currentPageNumber');
                const previousPageButton = document.getElementById('previousPageButton');
                const nextPageButton = document.getElementById('nextPageButton');

    // Data dan variabel kontrol
    const data = <?= json_encode($duar) ?>; // Menggunakan data yang Anda ambil dari controller
    const itemsPerPage = 20;
    let currentPage = 1;
    const totalPages = Math.ceil(data.length / itemsPerPage);

    // Fungsi untuk menampilkan data pada halaman tertentu
    function displayDataOnPage(page) {
        tableBody.innerHTML = ''; // Kosongkan tabel

        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        for (let i = startIndex; i < endIndex && i < data.length; i++) {
            const gas = data[i];
            // Buat baris tabel sesuai dengan data yang diterima dari controller
            // Anda dapat menyesuaikan ini sesuai dengan tampilan Anda
            const row = `
            <tr>
            <th class="text-center">${i + 1}</th>
            <td class="text-capitalize text-center text-dark">${gas.username}</td>
            <td class="text-capitalize text-center text-dark">${gas.activity}</td>
            <td class="text-capitalize text-center text-dark">${gas.waktu}</td>
            </tr>
            `;
            tableBody.innerHTML += row;
        }
    }

    // Fungsi untuk mengatur nomor halaman
    function updatePageNumbers() {
        currentPageNumber.textContent = currentPage;
    }

    // Mengatur aksi untuk tombol Previous (<)
    previousPageButton.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            displayDataOnPage(currentPage);
            updatePageNumbers();
        }
    });

    // Mengatur aksi untuk tombol Next (>)
    nextPageButton.addEventListener('click', function () {
        if (currentPage < totalPages) {
            currentPage++;
            displayDataOnPage(currentPage);
            updatePageNumbers();
        }
    });

    displayDataOnPage(currentPage);
    updatePageNumbers();
});
</script>
</div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let timeout;
    const timeoutDuration = 2 * 60 * 1000; // 2 menit dalam milidetik (1000 ms = 1 detik)

    function startTimeout() {
        clearTimeout(timeout); // Hapus timeout sebelumnya (jika ada)
        timeout = setTimeout(redirectToDashboard, timeoutDuration);
    }

    function redirectToDashboard() {
        window.location.href = '<?= base_url('/home/dashboard') ?>'; // Ganti URL sesuai dengan URL dashboard Anda
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