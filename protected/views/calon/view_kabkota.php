<?php
/* @var $this CalonController */
/* @var $model Calon */
$kategori =Yii::app()->session->get('id_kategori');

$this->breadcrumbs=array(
	'Calons'=>array('index'),
	$model->username,
);

$this->menu=array(
	// array('label'=>'List Calon', 'url'=>array('index')),
	// array('label'=>'Create Calon', 'url'=>array('create')),
	// array('label'=>'Update Calon', 'url'=>array('update', 'id'=>$model->username)),
	// array('label'=>'Delete Calon', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->username),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Manage Calon', 'url'=>array('admin')),
);
?>

<!-- <h1>View Calon #<?php echo $model->username; ?></h1> -->
<head>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1H72Fojan6yCxKf5DhNXD1Er4Y60ngWU&callback=myMap"></script>
 
<style>
h1 {text-align:center;}
          html, body {
               }
          #map {
               width: 100%;
               height: 540px;
               border: 0px solid black;
          }
</style>
 
<script type="text/javascript">

      var customIcons = {
 
        // icon di sini di non aktifkan karna, icon di definisikan di method load() agar mengikuti kategori
        // icon: '<?php echo Yii::app()->request->baseUrl;?>/custom/production/images/markers/marker'+id_kategori+'.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(-6.556176,107.749168),
        zoom: 8,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
 
      // Bagian ini digunakan untuk mendapatkan data format XML yang dibentuk dalam actionDataLokasi
      downloadUrl("<?php echo Yii::app()->request->baseUrl;?>/index.php/kegiatanKabkota/datalokasi/<?php echo $model->id_calon; ?>", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {

        var id_kegiatan = markers[i].getAttribute("id_kegiatan");
        var nama = markers[i].getAttribute("nama");
        var tanggal = markers[i].getAttribute("tanggal");
        var jenis = markers[i].getAttribute("jenis");
        var foto = markers[i].getAttribute("foto");
        var lat = markers[i].getAttribute("lat");
        var lng = markers[i].getAttribute("lng");
        
            
      //#429ADB biru
 
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<a target='_blank' href='../../kegiatanKabkota/"+id_kegiatan +"'><b>" +" #" +id_kegiatan+ "</b></br><b>" + nama + "</b><br/><div align='left'>"+jenis+"</br>"+ tanggal+"<br/><img class='img-responsive-avatar-view' height='100' widh='100' src='<?php echo Yii::app()->request->baseUrl?>/images/kegiatan/"+foto+" '> </a></div>";
          var icon = customIcons;
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: '<?php echo Yii::app()->request->baseUrl;?>/custom/production/images/markers/paslon<?php echo $model->id_calon ?>.png',
            shadow: customIcons.shadow
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }
 
    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
 
    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
 
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
 
      request.open('GET', url, true);
      request.send(null);
    }
 
    function doNothing() {}
 
</script>

</head>
<body onload="load()"> 

<div class="row">
        <div class="col-md-12">

<h2><i class="fa fa-user"></i> Lihat Data Office Boy #<?php echo $model->id_calon; echo" "; echo $model->nama; ?></h2>
<div class="x_title">
                    </div>

<div class="row">
        <div class="col-md-12">
            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
            	<a class="btn btn-primary" onclick="location='<?= Yii::app()->request->baseUrl?>/index.php/calon/admin'"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
<br><br>    

                <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    <img class="img-responsive avatar-view" src="<?php echo Yii::app()->request->baseUrl; ?>/foto/<?php echo $model->nama; ?>" alt="Avatar" title="<?php ?>">
                                </div>
                            </div>
                            <h3><?php ?></h3>

                            <ul class="list-unstyled user_data">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Username</th>
                                        <td><?php echo $model->username; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nama Akun Office Boy</th>
                                        <td><?php echo $model->nama; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </ul>

                      <?php   
                              if ($kategori == '-1'){
                      ?>
                        <a title="Edit Data Office Boy" class="btn btn-warning col-md-12" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/calon/update/<?= $model->id_calon; ?>"><i class="fa fa-pencil"></i> Update <?= $model->username ?></a>
                        <a onclick="return confirm('Anda yakin ingin menghapus Data Office Boy <?php echo $model->nama;?> ? Semua Kegiatan yang dilaporkan <?php echo $model->nama;?> juga ikut terhapus' )" title="Hapus Data Office Boy" class="btn btn-danger col-md-12" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/calon/delete/<?= $model->id_calon; ?>"><i class="fa fa-trash"></i> Hapus <?= $model->username?></a>

                      <?php } ?>
                        </div>
<br>
<br>
<br>
                        <div class="col-md-9 col-sm-9 col-xs-15">
                            <div class="x_panel">

                                <div class="x_content">

                                    <!-- start accordion -->
                                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">ID Akun Office Boy</th>
                                                        <td><?php echo $model->id_calon; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Username</th>
                                                        <td><?php echo $model->username; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Password</th>
                                                        <td><?php echo $model->password; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Nama Office Boy</th>
                                                        <td><?php echo $model->nama; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">No Identitas</th>
                                                        <td><?php echo $model->dapil; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Kategori</th>
                                                        <td><?php echo $model->kategori; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Kampus</th>
                                                        <td><?php echo $model->daerah; ?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of accordion -->


                                </div>
                            </div>
                        </div>
			</div>
		</div>
</div>

<!-- Start Chart -->
    <div class="col-md-6">
    <h3><i class="fa fa-tasks"></i> Grafik laporan Office Boy</h3>
    <div class="x_title"></div>
            <canvas id="myChart" width="100" height="100"></canvas>
        </div>
        <script>
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: ["Ruangan", "Lantai", "Gedung", "Toilet", "Gudang", "Halaman/Taman", "Lainnya"],
                    datasets: [{
                            label: 'Jenis Kegiatan Office Boy',
                            //data: [12, 19, 3, 5, 2, 3, 4],
                             data: [<?php 
                             //while ($p = mysqli_fetch_array($penghasilan)) { echo '"' . $p['hasil_penjualan'] . '",';}
                             foreach ($getAllCountPerJenisByPk as $data) {
                               echo '"' . $data['Ruangan'] . '",';
                               echo '"' . $data['Lantai'] . '",';
                               echo '"' . $data['Gedung'] . '",';
                               echo '"' . $data['Toilet'] . '",';
                               echo '"' . $data['Gudang'] . '",';
                               echo '"' . $data['HalamanTaman'] . '",';
                               echo '"' . $data['lainnya'] . '"';
                             }
                             ?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(153, 102, 255, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
        </script>
    <!-- End pof chart --> 

<div class="clearfix"></div>

<div class="col-md-6">
          <h3><i class="fa fa-map"></i> Peta Laporan <?= $model->nama; ?></h3>
        </div> 
<div class="clearfix"></div>        
<div id="map"></div>
<br>

<!-- Tabel kegiatan -->
<div class="">
          <div class="col-md-6">
          <h3><i class="fa fa-table"></i> Tabel Laporan <?= $model->nama; ?> </h3>
        </div>
          <div class="col-md-6 text-right">

                  <!-- <i class="fa fa-plus m-right-xs"></i> 
                                    <?php
                                     echo CHtml::Button('Tambah Laporan',array('onClick'=>"location='create'", 'class'=>'btn btn-primary')); 
                                     ?>
 -->
                            </div>

          
          
        </div>
        <div class="panel-body">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <br>
            <div class="x_title">
              <br>
          </div>
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Akun Pengawas</th>
                <th>Nama Kegiatan</th>
                <th>Jumlah Orang</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Foto</th>
                <th></th>
              </tr>
              </thead>
              <tbody>

                  <?php
                    // print_r($model); // testing pemanggilan data
                  ?>

                <?php $no = 1; ?>
                <?php foreach ($modelTabelKabkota as $data) : ?>

                  
                  <tr>
                    <td><?php echo $no;?></td>
                    <td><a href="#"><?= $data['nama_calon']; ?></a></td>
                    
                    <td><?= $data['nama_kegiatan']; ?></td>
                    <td><?= $data['jumlah_peserta'];?></td>
                    <td><?php
                    $date = date_create($data['tanggal']); 
                    echo date_format($date, 'j F Y, \p\u\k\u\l G:i');
                     ?></td>
                    <td><?= $data['jenis']; ?></td>
                    <td><a target="_blank" href="<?php echo Yii::app()->request->baseUrl; ?>/images/kegiatan/<?php echo $data['foto']; ?>"><img class="img-responsive avatar-view" height="100" width="100" src="<?php echo Yii::app()->request->baseUrl; ?>/images/kegiatan/<?php echo $data['foto']; ?>"></a></td>
                    <td>
                      <?php   
                              if ($kategori == '-1'){
                      ?>
                    <!--<div class="hidden-sm hidden-xs action-buttons">-->
                      <a class="btn btn-success btn-xs" href="<?= Yii::app()->request->baseUrl; ?>/index.php/kegiatanKabkota/<?= $data['id_kegiatan']; ?>" role="button"><i class="fa fa-search"></i></a>
                      <!-- <a class="btn btn-warning btn-xs" href="update/<?= $data['id_kegiatan']; ?>" role="button"><i class="fa fa-pencil"></i></a> -->
                      <a class="btn btn-danger btn-xs" href="<?= Yii::app()->request->baseUrl; ?>/index.php/kegiatan/delete/<?= $data['id_kegiatan']; ?>" role="button"  onclick="return confirm('Anda yakin ingin menghapus <?php echo $data['nama_kegiatan'];?>?')"><i class="fa fa-trash"></i></a>
                      <!--</div>-->

                      <?php } ?>
                      
                      

                    </td>
                  </tr>
                  <?php $no++; ?>
                <?php endforeach; ?>


              </tbody>
            </table>
          </div>

<?php 
// $this->widget('zii.widgets.CDetailView', array(
// 	'data'=>$model,
// 	'attributes'=>array(
// 		'username',
// 		'password',
// 		'nama',
// 		'dapil',
// 		'id_kabkota',
// 	),
// )); 
?>
