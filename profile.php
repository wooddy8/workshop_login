<?php
require 'config/connect.php';
if (empty($_SESSION['session_login']))
{
    header('location:login.php');
}

//echo time();
//echo '<br>';
//echo rand(100000, 999999);
//update profile
$msg = "";
$mag = "";
if (@$_POST['submit'])
{
    $user_fullname   = $_POST['user_fullname'];
    $user_email      = $_POST['user_email'];
    $user_imgprofile = $_FILES['user_imgprofile']['name'];
    $user_province   = $_POST['user_province'];

    //upload file php
    if (!empty($user_imgprofile))
    {

        $inputname        = "user_imgprofile";
        $filename         = $_FILES['user_imgprofile']['name'];
        $filename_explode = explode(".", $_FILES['user_imgprofile']['name']);
        $new_filename     = time() . "." . $filename_explode[1];
        $filesize         = $_FILES['user_imgprofile']['size'];
        $filetmp          = $_FILES['user_imgprofile']['tmp_name'];
        $filetype         = $_FILES['user_imgprofile']['type'];
        $maxfilesize      = "6000000";
        $orgdirectory     = "img/master"; //ภาพต้นฉบับ
        $thumbdirectory   = "img/thumbnail"; //ภาพย่อ
        $thumbwidth       = "300";
        $thumbheight      = "300";
        genius_uploadimg($inputname, $new_filename, $filesize, $filetmp, $filetype, $maxfilesize, $orgdirectory, $thumbdirectory, $thumbwidth, $thumbheight);

        //Command Update Database
        $sql = "UPDATE users SET
        user_fullname=:user_fullname,
        user_email=:user_email,
        user_imgprofile=:user_imgprofile,
        user_province =:user_province
        WHERE user_email = '$_SESSION[session_login]'";
        $query = $connect->prepare($sql);
        $query->bindParam(':user_fullname', $user_fullname);
        $query->bindParam(':user_email', $user_email);
        $query->bindParam(':user_imgprofile', $new_filename);
        $query->bindParam(':user_province', $user_province);
        $query->execute();

        //Update Session When Chang Email
        $_SESSION['session_login'] = $user_email;

        if ($filesize <= $maxfilesize)
        {
            echo $msg_size = "<div class='alert alert-danger'>รูปขนาดใหญ่เกิน 6 MB</div>";
        }
        else
        {
            $upload_path = "img/";
            move_uploaded_file($_FILES['user_imgprofile']['tmp_name'], $upload_path . $_FILES['user_imgprofile']['name']);
        }
    }
    else
    {

        //Command Update Database
        $sql = "UPDATE users SET
        user_fullname=:user_fullname,
        user_email=:user_email,
        user_province =:user_province
        WHERE user_email = '$_SESSION[session_login]'";
        $query = $connect->prepare($sql);
        $query->bindParam(':user_fullname', $user_fullname);
        $query->bindParam(':user_email', $user_email);
        $query->bindParam(':user_province', $user_province);
        $query->execute();

        //Update Session When Chang Email
        $_SESSION['session_login'] = $user_email;

    }
}

$sql_profile    = "SELECT * FROM users WHERE user_email = '$_SESSION[session_login]'";
$result_profile = $connect->query($sql_profile);
$result_profile->execute();
$user_profile = $result_profile->fetch();

$sql_province    = "SELECT province_id,province_name FROM tbl_provinces";
$result_province = $connect->query($sql_province);
$result_province->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $user_profile['user_fullname']; ?> | System</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Select 2  for this template -->
    <link href="select2/css/select2.min.css" rel="stylesheet">

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
                    <h3>Edit Profile</h3>
                    <form method="post" action="profile.php" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label">Fullname</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="user_fullname" id="user_fullname"
                                    value="<?php echo $user_profile['user_fullname']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="user_email" id="user_email"
                                    value="<?php echo $user_profile['user_email']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label">User Province</label>
                            <div class="col-sm-9">
                                <select name="user_province" class="form-control province_list" id="user_province">
                                    <option value=""></option>
                                <?php
while ($rs = $result_province->fetch(PDO::FETCH_ASSOC))
{
    if ($user_profile['user_province'] == $rs['province_id'])
    {
        echo "<option value='" . $rs['province_id'] . "' selected >" . $rs['province_name'] . "</option>";
    }
    else
    {
        echo "<option value='" . $rs['province_id'] . "'>" . $rs['province_name'] . "</option>";
    }

}
?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label">Pic Profile</label>
                            <div class="col-sm-9">
                                <input type="file" name="user_imgprofile" id="user_imgprofile" placeholder="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <input type="submit" name="submit" class="btn btn-primary" value="Update">
                            </div>
                        </div>
                    </form>

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

    <!--Select 2 JavaScript -->
    <script src="select2/js/select2.min.js"></script>
    <script src="select2/js/i18n/th.js"></script>

    <script>
    $(function() {
    $('.province_list').select2({
        language:"th",
        placeholder:"กรุณาเลือกจังหวัด",
        //minimumInputLength:3
    });
});
    </script>
</body>

</html>