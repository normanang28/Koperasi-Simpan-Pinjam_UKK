<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="header-left">
                <form action="<?= base_url('home/cooperative_officer_search') ?>" method="post">
                    <div class="input-group search-area">
                        <input type="text" class="form-control text-capitalize" name="search_cooperative_officer" placeholder="Search here...">
                        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                    </div>
                </form>
            </div>
            <div class="right-aligned">
                <?php if(!empty($search)) {?>
                    <a href="<?= base_url('/home/cooperative_officer/')?>"><button class="btn btn-info"><i class="fa fa-undo"></i> Back</button></a>
                <?php }?>
                <!-- <a href="<?= base_url('/home/add_cooperative_officer/')?>"><button class="btn btn-success"><i class="fa fa-plus"></i> Add</button></a> -->
                <a href="<?= base_url('/home/add_cooperative_officer/')?>"><button class="btn btn-success custom-button"><i class="fa fa-plus"></i> Add</button></a>
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

            
            <br>
            <div class="table-responsive">
                <table class="table items-table table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">NIK</th>
                            <th class="text-center">Username / Full Name</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Telephone Number</th>
                            <th class="text-center">Place And Date Of Birth</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        foreach ($duar as $gas){
                          ?>
                          <tr>
                            <th class="text-center"><?php echo $no++ ?></th>
                            <td class="text-center text-capitalize text-dark"><?php echo $gas->nik?></td>
                            <td class="text-center text-capitalize text-dark"><?php echo $gas->username?> / <?php echo $gas->nama_petugas?></td>
                            <td class="text-center text-capitalize text-dark"><?php echo $gas->jk?></td>
                            <td class="text-center text-capitalize text-dark"><?php echo $gas->no_telp?></td>
                            <td class="text-center text-capitalize text-dark"><?php echo $gas->ttl?></td>
                            <td>
                                <div class="col-12 center-column">
                                  <a href="<?= base_url('/home/detail_cooperative_officer/'.$gas->id_petugas_user)?>"><button class="btn btn-info"><i class="fa fa-bars"></i> Details</button></a>
                              </div>
                          </td>
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
            const row = `
            <tr>
            <th class="text-center">${i + 1}</th>
            <td class="text-center text-capitalize text-dark">${gas.nik}</td>
            <td class="text-center text-capitalize text-dark">${gas.username} / ${gas.nama_petugas}</td>
            <td class="text-center text-capitalize text-dark">${gas.jk}</td>
            <td class="text-center text-capitalize text-dark">${gas.no_telp}</td>
            <td class="text-center text-capitalize text-dark">${gas.ttl}</td>
            <td>
            <div class="col-12 center-column">
            <a href="<?= base_url('/home/detail_cooperative_officer/') ?>/${gas.id_petugas_user}"><button class="btn btn-info"><i class="fa fa-bars"></i> Details</button></a>
            </div>
            </td>
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