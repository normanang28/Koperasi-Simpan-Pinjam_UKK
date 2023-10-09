<?php if(session()->get('level')== 2) { ?>
<div align="center">

    <!-- <img align="center" src="data:image/jpg;base64,<?= $foto?>" width="82%" height="18%" > -->
    <div>
      <br>
      <br>
  </div>

  <table id="datatable-buttons" align="center" border="1" align="center" width="80%" class="table table-bordered table-striped verticle-middle table-responsive-sm">
      <thead>
        <tr>
          <th class="text-center">No.</th>
          <th class="text-center">Loan Name</th>
          <th class="text-center">Loan Category</th>
          <th class="text-center">Installments</th>
          <th class="text-center">Nominal</th>
          <th class="text-center">Remark</th>
          <th class="text-center">Date</th>
          <th class="text-center">Maker</th>
        </tr>
</thead>

<tbody>
    <?php
    $no = 1;
    foreach ($duar as $gas) {
            ?>

            <tr>
                <th class="text-center"><?php echo $no++ ?></th>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_pinjaman?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_katagori?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->angsuran_ke?></td>
                <td class="text-center text-capitalize text-dark">Rp. <?php echo number_format($gas->nominal_angsuran, 2, ',', '.') ?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->keterangan_angsuran?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->tanggal_pembayaran?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->username?> / <?php echo $gas->tanggal_pembayaran?></td>
            </tr>
        <?php }?>
    </tbody>
</table>
</div>
<script>
  window.print();
</script>
<?php }else{} ?>

<?php if(session()->get('level')== 3) { ?>
<div align="center">

    <!-- <img align="center" src="data:image/jpg;base64,<?= $foto?>" width="82%" height="18%" > -->
    <div>
      <br>
      <br>
  </div>

  <table id="datatable-buttons" align="center" border="1" align="center" width="80%" class="table table-bordered table-striped verticle-middle table-responsive-sm">
      <thead>
        <tr>
          <th class="text-center">No.</th>
          <th class="text-center">Loan Name</th>
          <th class="text-center">Loan Category</th>
          <th class="text-center">Installments</th>
          <th class="text-center">Nominal</th>
          <th class="text-center">Remark</th>
          <th class="text-center">Date</th>
          <th class="text-center">Maker</th>
        </tr>
</thead>

<tbody>
    <?php
    $no = 1;
    $username = session()->get('username');

    foreach ($duar as $gas) {
        if ($gas->username == $username) {
            ?>

            <tr>
                <th class="text-center"><?php echo $no++ ?></th>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_pinjaman?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->nama_katagori?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->angsuran_ke?></td>
                <td class="text-center text-capitalize text-dark">Rp. <?php echo number_format($gas->nominal_angsuran, 2, ',', '.') ?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->keterangan_angsuran?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->tanggal_pembayaran?></td>
                <td class="text-center text-capitalize text-dark"><?php echo $gas->username?> / <?php echo $gas->tanggal_pembayaran?></td>
            </tr>
        <?php }}?>
    </tbody>
</table>
</div>
<script>
  window.print();
</script>
<?php }else{} ?>
