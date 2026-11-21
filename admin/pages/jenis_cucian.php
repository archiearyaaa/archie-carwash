<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Jenis Cucian</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Jenis Cucian</a></li>
                                    <li class="active"><a href="#">Data Jenis Cucian</a></li>
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
                                <strong class="card-title">Data Jenis Cucian</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a href="index.php?p=tambah_jenis_cucian" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Jenis Cucian</a>
                                </div>
                                <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
<?php
  include ("../config/koneksi.php");
  $sqll = "select * from jenis_cucian order by id_jenis_cucian desc";
  $resultt = mysql_query($sqll);
    if(mysql_num_rows($resultt) > 0){
?>                                            
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jenis Cucian</th>
                                            <th>Biaya</th>
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
                                            <td><?= $data['jenis_cucian'];?></td>
                                            <td>Rp <?= number_format($data['biaya'], 0, ',', '.');?></td>
                                            <td align="center">
                                                <a href="index.php?p=edit_jenis_cucian&id_jenis_cucian=<?php echo $data['id_jenis_cucian']; ?>" class="btn btn-sm btn-warning"> <i class="fa fa-pencil" style="color: white"></i> <font color="white">Edit</font></a>
                                                <a href="index.php?p=hapus_jenis_cucian&id_jenis_cucian=<?php echo $data['id_jenis_cucian']; ?>" onClick="return confirm('Apakah Anda Yakin Hapus Data?')" class="btn btn-sm btn-danger"> <i class="fa fa-trash" style="color: white"></i> <font color="white">Hapus</font></a>
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