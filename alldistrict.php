<?php
require 'config/connect.php';
if (empty($_SESSION['session_login']))
{
    header('location:login.php');
}
//ส่วนของการแบ่งหน้า
$pagelen = 20;

//ดึงหมายเลขหน้าจาก url
if (empty($_GET['page']))
{
    $page = 1;
}
else
{
    $page = $_GET['page'];
}

/*
$sql_count    = "SELECT district_id FROM tbl_districts ";
$result_count = $connect->query($sql_count);
$numrow       = $result_count->rowCount();

//คำนวนหาจำนวนหน้าทั้งหมดที่สามารถแบ่งได้
$totalpage = ceil($numrow / $pagelen);
//echo $totalpage;

//คำนวนหารายการถัดไปของแต่ละหน้า
$goto = ($page - 1) * $pagelen;
echo $goto;
 */
$sql = "SELECT * FROM tbl_districts
        INNER JOIN tbl_provinces ON(tbl_districts.province_id = tbl_provinces.province_id)
        INNER JOIN tbl_amphures ON(tbl_districts.amphur_id = tbl_amphures.amphur_id)
        INNER JOIN tbl_geography ON(tbl_districts.geo_id = tbl_geography.geo_id)";
$result = $connect->query($sql);
$numrow = $result->rowCount();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>District | System</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Data Table CSS -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'sidemenu.php';?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include 'topmenu.php';?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1>District Data <?php echo ($numrow) ?> </h1>
                    <table class="table table-striped" id="dataTable" width="100%">
                        <thead>
                            <tr class="bg-primary text-light">
                                <th>ID</th>
                                <th>Code</th>
                                <th>Name (TH)</th>
                                <th>Name (Eng)</th>
                                <th>Amphur</th>
                                <th>Province</th>
                                <th>Geo ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
while ($rs = $result->fetch(PDO::FETCH_ASSOC))
{
    ?>
                            <tr>
                                <td><?=$rs['district_id']?></td>
                                <td><?=$rs['district_code']?></td>
                                <td><?=$rs['district_name']?></td>
                                <td><?=$rs['district_name_eng']?></td>
                                <td><?=$rs['amphur_name']?></td>
                                <td><?=$rs['province_name']?></td>
                                <td><?=$rs['geo_name']?></td>


                            </tr>
                            <?php
}
?>
                        </tbody>
                    </table>

                    <nav aria-label="...">
                        <ul class="pagination">
                        <?php
/*
if ($page > 1)
{
$back = $page - 1;

echo "<li class='page-item'>";
echo "<a class='page-link'  href='district.php?page=$back&pid=$_GET[pid]'>Previous</a>";
echo "</li>";
}
else
{
echo "<li class='page-item disabled'>";
echo "<a class='page-link'  href='#'>Previous</a>";
echo "</li>";
}

for ($a = 1; $a <= $totalpage; $a++)
{
if ($page == $a)
{
echo "<li class='page-item active'><a class='page-link' href='district.php?page=$a&pid=$_GET[pid]'>" . $a . "</a></li>";
}
else
{
echo "<li class='page-item'><a class='page-link' href='district.php?page=$a&pid=$_GET[pid]'>" . $a . "</a></li>";
}
}
if ($page < $totalpage)
{
$next = $page + 1;
echo "<li class='page-item'>";
echo "<a class='page-link' href='district.php?page=$next&pid=$_GET[pid]'>Next</a>";
echo "</li>";
}
else
{
echo "<li class='page-item disabled'>";
echo "<a class='page-link' href='#'>Next</a>";
echo "</li>";
}
 */
?>
                        </ul>
                    </nav>
                </div>
            </div>
            <?php include 'footer.php';?>
        </div>
    </div>





    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Data Table -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!--Load Data Table -->
    <script>
    $(document).ready( function () {
    $('#dataTable').DataTable();
} );
    </script>
</body>

</html>