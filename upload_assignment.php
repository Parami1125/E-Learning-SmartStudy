<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
}

if (isset($_POST['submit'])) {
    $id = unique_id();
    $tutor_id=$_POST['tutor_id'];
    $module_id=$_POST['module_id'];
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    $pdf = $_FILES['pdf']['name'];
    $pdf = filter_var($pdf, FILTER_SANITIZE_STRING);
    $pdf_ext = pathinfo($pdf, PATHINFO_EXTENSION);
    $rename_pdf = unique_id() . '.' . $pdf_ext;
    $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
    $pdf_folder = 'uploaded_files/' . $rename_pdf;

    $add_playlist = $conn->prepare("INSERT INTO `grades` (id, tutor_id, user_id, module_id, description, document) VALUES (?, ?, ?, ?, ?, ?)");
    $add_playlist->execute([$id, $tutor_id, $user_id,  $module_id, $description, $rename_pdf]);
    move_uploaded_file($pdf_tmp_name, $pdf_folder);
    $message[] = 'New Assignment uploaded!';

    setcookie('tutor_id', $tutor_id, time() + (86400 * 30), '/'); // Set the tutor_id cookie for 30 days
}

// Fetch modules from the content table
$fetch_modules = $conn->prepare("SELECT * FROM content");
$fetch_modules->execute();
$modules = $fetch_modules->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <section class="video-form">

        <h1 class="heading">Upload Assignment</h1>
        <?php
             $sql = "SELECT * FROM module WHERE id = '".$_GET['module']."'"; // Removed the tutor_id condition since it's not available in this file
             $result = $conn->prepare($sql);
             $result->execute();
 
             if ($result !== false && $result->rowCount() > 0) {
                 $row = $result->fetch(PDO::FETCH_ASSOC);
              }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <p>Module title </p>
            <input type="hidden" name="module_id" value="<?php echo $row['id'] ?>">
            <input type="hidden" name="tutor_id" value="<?php echo $row['tutor_id'] ?>">
            <input type="text" name="modul_title" maxlength="100" required placeholder="enter module title" class="box" value="<?php echo $row['title']; ?>" readonly>
            <p>Module description </p>
            <textarea name="modul_description" class="box" required placeholder="write description" maxlength="1000" cols="3" rows="3" readonly><?php echo $row['description']; ?></textarea>
            <p>Select Assignment <span>*</span></p>
            <input type="file" name="pdf" accept="application/pdf" required class="box">     
            <p>Assignment description <span>*</span></p>
            <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30" rows="10" ></textarea>
            <input type="submit" value="Upload Module" name="submit" class="btn">
        </form>

    </section>

    <?php include 'components/footer.php'; ?>

    <script src="js/admin_script.js"></script>

</body>

</html>
