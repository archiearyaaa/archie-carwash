<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>User</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">User</a></li>
                                    <li class="active"><a href="#">Data User</a></li>
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
                                <strong class="card-title">Data User</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a href="index.php?p=tambah_user" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data User</a>
                                </div>
                                <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
<?php
  include ("../config/koneksi.php");
  
  // Pastikan tabel user ada di database agar tidak terjadi error jika memakai database versi lain
  mysql_query("CREATE TABLE IF NOT EXISTS `user` (
    `id_user` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `nama` varchar(50) NOT NULL,
    `alamat` varchar(100) NOT NULL,
    `hp` varchar(25) NOT NULL,
    `status` int(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id_user`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  $sqll = "select * from user order by id_user desc";
  $resultt = mysql_query($sqll);
    if(mysql_num_rows($resultt) > 0){
?>                                            
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Alamat</th>
                                            <th>No. HP</th>
                                            <th>Status</th>
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
                                            <td><?= $data['nama'];?></td>
                                            <td><?= $data['username'];?></td>
                                            <td><?= $data['alamat'];?></td>
                                            <td><?= $data['hp'];?></td>
                                            <td align="center">
                                            <?php if($data['status']=='1'){ ?>
                                              <a href="index.php?p=ganti_status_user&id=<?php echo $data['id_user'];?>&status=<?php echo $data['status'];?>" onClick="return confirm('Apakah Anda Yakin Menonaktifkan User Ini?')" class="btn btn-sm btn-success" style="width: 85px"> <font color="white"> Aktif</font></a>
                                            <?php } elseif($data['status']=='0') { ?>
                                              <a href="index.php?p=ganti_status_user&id=<?php echo $data['id_user'];?>&status=<?php echo $data['status'];?>" onClick="return confirm('Apakah Anda Yakin Mengaktifkan User Ini?')" class="btn btn-sm btn-danger" style="width: 85px"> <font color="white">Nonaktif</font></a>
                                            <?php } ?>
                                          </td>
                                            
                                            <td align="center">
                                                <a href="index.php?p=edit_user&id_user=<?php echo $data['id_user']; ?>" class="btn btn-sm btn-warning"> <i class="fa fa-pencil" style="color: white"></i> <font color="white">Edit</font></a>
                                                <a href="index.php?p=hapus_user&id_user=<?php echo $data['id_user']; ?>" onClick="return confirm('Apakah Anda Yakin Hapus Data?')" class="btn btn-sm btn-danger"> <i class="fa fa-trash" style="color: white"></i> <font color="white">Hapus</font></a>
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