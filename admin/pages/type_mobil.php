<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Tipe Mobil</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Tipe Mobil</a></li>
                                    <li class="active"><a href="#">Data Tipe Mobil</a></li>
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
                                <strong class="card-title">Data Tipe Mobil</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <a href="index.php?p=tambah_type_mobil" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data Tipe Mobil</a>
                                </div>
                                <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
<?php
  include ("../config/koneksi.php");
  $sqll = "select * from type_mobil order by id_type_mobil desc";
  $resultt = mysql_query($sqll);
    if(mysql_num_rows($resultt) > 0){
?>                                            
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Type Mobil</th>
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
                                            <td><strong><?= htmlspecialchars($data['type_mobil']);?></strong><?= !empty($data['merek_mobil']) && $data['merek_mobil'] !== '-' ? ' <span class="badge badge-info">' . htmlspecialchars($data['merek_mobil']) . '</span>' : '';?></td>
                                            <td align="center">
                                                <a href="index.php?p=edit_type_mobil&id_type_mobil=<?php echo $data['id_type_mobil']; ?>" class="btn btn-sm btn-warning"> <i class="fa fa-pencil" style="color: white"></i> <font color="white">Edit</font></a>
                                                <a href="index.php?p=hapus_type_mobil&id_type_mobil=<?php echo $data['id_type_mobil']; ?>" onClick="return confirm('Apakah Anda Yakin Hapus Data?')" class="btn btn-sm btn-danger"> <i class="fa fa-trash" style="color: white"></i> <font color="white">Hapus</font></a>
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