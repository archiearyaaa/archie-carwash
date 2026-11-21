<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Transaksi</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Transaksi</a></li>
                                    <li class="active"><a href="#">Data Transaksi</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Data Transaksi</strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
<?php
  include ("../config/koneksi.php");
  $sqll = "select * from transaksi join pendaftaran using (id_pendaftaran) join customer where pendaftaran.id_customer = customer.id_customer order by id_transaksi desc";
  $resultt = mysql_query($sqll);
    if(mysql_num_rows($resultt) > 0){
?>                                            
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No. Antrian</th>
                                            <th>No. Nota</th>
                                            <th>Nama Customer</th>
                                            <th>Total Biaya</th>
                                            <th>Status</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
  $nomor=1;
  while($data = mysql_fetch_array($resultt)){
?>                                          
                                        <tr>
                                            <td><?= $nomor++;?></td>
                                            <td><strong><?= $data['no_antrian'];?></strong></td>
                                            <td><span class="badge badge-dark"><?= $data['no_nota'];?></span></td>
                                            <td><?= $data['nama'];?></td>
                                            <td style="font-weight: 600; color: #0284c7;">Rp <?= number_format($data['total'], 0, ',', '.');?></td>
                                            <td><span class="badge badge-success"><?= $data['status'];?></span></td>
                                            <td><?= $data['nama_pencuci'];?></td>
                                            <td align="center">
                                                <a href="pages/cetak_nota_kasir.php?id_transaksi=<?= $data['id_transaksi']; ?>" target="_blank" class="btn btn-sm btn-info" style="border-radius: 6px; font-weight: 600;">
                                                    <i class="fa fa-print"></i> Struk Kasir
                                                </a>
                                            </td>
                                        </tr>
<?php
  }
?>
              </tbody>
            </table>
            </div>
<?php
  }else{
    echo 'Data not found!';
    echo mysql_error();
  }
?>            
                            </div>
                        </div>
                    </div>


                </div>
            </div><!-- .animated -->
        </div><!-- .content -->