<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <!-- Nav tabs -->
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1">
                            <i class="fa fa-hourglass-half"></i>&nbsp; Submission
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile1">
                            <i class="fa fa-dollar-sign"></i>&nbsp; Loan
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home1" role="tabpanel">
                        <div class="pt-4">
                            <div class="header-left">
                                <?php if(session()->get('level')== 2) { ?>
                                    <form action="<?= base_url('home/loan_search') ?>" method="post">
                                        <div class="input-group search-area">
                                            <input type="text" class="form-control text-capitalize" name="search_loan" placeholder="Search here...">
                                            <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                                        </div>
                                    </form>
                                <?php }else{} ?>
                                <?php if(session()->get('level')== 3) { ?>
                                    <form action="<?= base_url('home/loan_search_member') ?>" method="post">
                                        <div class="input-group search-area">
                                            <input type="text" class="form-control text-capitalize" name="search_loan" placeholder="Search here...">
                                            <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                                        </div>
                                    </form>
                                <?php }else{} ?>
                                </div>
                            <form action="<?= base_url('/home/status_acc_loan/')?>" method="post">
                            <div class="right-aligned">
                                <?php if(!empty($search)) {?>
                                    <a href="<?= base_url('/home/loan/')?>"><button class="btn btn-info" type="button"><i class="fa fa-undo"></i> Back</button></a>
                                <?php }?>
                                <?php if(session()->get('level')== 2 || session()->get('level')== 3) { ?>
                                    <a href="<?= base_url('/home/add_loan/')?>"><button class="btn btn-success" type="button"><i class="fa fa-plus"></i> Add</button></a>
                                <?php }else{} ?>
                                <?php if(session()->get('level')== 2) { ?>
                                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i></button>
                                <?php }else{} ?>
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
                <th class="text-center">#</th>
                <th class="text-center">Loan Name</th>
                <th class="text-center">Nominal</th>
                <th class="text-center">Maker</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no=1;
            foreach ($duar as $gas){
                if ($gas->status_acc == "Process") { 
                  ?>
                  <tr>
                    <td>
                        <input type="checkbox" class="checkbox__input" value="<?= $gas->id_pinjaman ?>" name="invoice[]" id="invoice_<?= $gas->id_pinjaman ?>"/>
                    </td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_pinjaman?></td>
                    <td class="text-center text-capitalize text-dark">Rp. <?php echo number_format($gas->nominal, 2, ',', '.') ?></td>
                    <!-- <td class="text-center text-capitalize text-dark"><?php echo $gas->status_acc?></td> -->
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->username?> / <?php echo $gas->tanggal_peminjaman?></td>
                    <td class="text-center text-capitalize text-dark">
                            <i class="fas fa-circle text-warning blinking-icon"></i> Process
                    </td>
                    <td>
                        <div class="col-12 center-column">
                          <a href="<?= base_url('/home/detail_loan/'.$gas->id_pinjaman)?>"><button class="btn btn-info" type="button"><i class="fa fa-bars"></i> Details</button></a>
                      </div>
                  </td>
              </tr>
          <?php }}?>
      </tbody>
  </table>
</div>
</form>
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

        /* ... Kode CSS yang ada ... */

        /* Animasi kedip */
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
    const filteredData = data.filter(item => item.status_acc === "Process"); // Filter data hanya untuk "Process"
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);

    // Fungsi untuk menampilkan data pada halaman tertentu
    function displayDataOnPage(page) {
        tableBody.innerHTML = ''; // Kosongkan tabel

        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        let no = startIndex + 1; // Inisialisasi nomor (no) dengan nilai startIndex + 1

        for (let i = startIndex; i < endIndex && i < filteredData.length; i++) {
            const gas = filteredData[i];

            const formattedNominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(gas.nominal);

            const row = `
            <tr>
            <td class="text-center">
                <input type="checkbox" class="checkbox__input" value="${gas.id_pinjaman}" name="loan_loan[]" id="loan_loan${gas.id_pinjaman}"/>
            </td>
            <td class="text-center text-capitalize text-dark">${gas.nama_pinjaman}</td>
            <td class="text-center text-capitalize text-dark">${formattedNominal}</td>
            <td class="text-center text-capitalize text-dark">${gas.username} / ${gas.tanggal_peminjaman}</td>
            <td class="text-center text-capitalize text-dark">
                <i class="fas fa-circle text-${gas.status_acc === 'Process' ? 'warning' : 'default'} blinking-icon"></i>
                ${gas.status_acc}
            </td>
            <td>
            <div class="col-12 center-column">
            <a href="<?= base_url('/home/detail_loan/') ?>/${gas.id_pinjaman}"><button class="btn btn-info" type="button"><i class="fa fa-bars"></i> Details</button></a>
            </a>
            </div>
            </td>
            </tr>
            `;
            tableBody.innerHTML += row;
            no++;
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


<div class="tab-pane fade" id="profile1">
    <div class="pt-4">
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
                <th class="text-center">Loan Name</th>
                <th class="text-center">Nominal</th>
                <th class="text-center">Maker</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no=1;
            foreach ($duar as $gas){
                if ($gas->status_acc == "Approved") { 
                  ?>
                  <tr>
                    <th class="text-center"><?php echo $no++ ?></th>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_pinjaman?></td>
                    <td class="text-center text-capitalize text-dark">Rp. <?php echo number_format($gas->nominal, 2, ',', '.') ?></td>
                    <td class="text-center text-capitalize text-dark"><?php echo $gas->username?> / <?php echo $gas->tanggal_peminjaman?></td>
                    <td class="text-center text-capitalize text-dark">
                            <i class="fas fa-circle text-success blinking-icon"></i> Approved
                    </td>
                    <td>
                        <div class="col-12 center-column">
                          <a href="<?= base_url('/home/detail_loan/'.$gas->id_pinjaman)?>"><button class="btn btn-info"><i class="fa fa-bars"></i> Details</button></a>
                      </div>
                  </td>
              </tr>
          <?php }}?>
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
</div>
</div>
</div>
</div>