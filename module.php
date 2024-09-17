<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Change font color to white for dark mode */
        body.dark-mode .heading,
        body.dark-mode .box h2,
        body.dark-mode .box p,
        body.dark-mode .box a,
        body.dark-mode .title {
            color: white;
        }
    </style>
</head>

<body class="<?php echo isset($_COOKIE['dark_mode']) && $_COOKIE['dark_mode'] === 'true' ? 'dark-mode' : ''; ?>">

    <?php include 'components/user_header.php'; ?>

    <section class="courses">
       
    <h1 class="heading <?php echo isset($_COOKIE['dark_mode']) && $_COOKIE['dark_mode'] === 'true' ? 'dark-mode' : ''; ?>">Available Modules</h1>
        <div class="box-container">
            <?php
            $sql = "SELECT * FROM module WHERE status = 'active'"; // Removed the tutor_id condition since it's not available in this file
            $result = $conn->prepare($sql);
            $result->execute();

            if ($result !== false && $result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='box'>";
                    echo "<h2>" . $row['title'] . "</h2>";
                    echo "<p>" . $row['description'] . "</p>";

                    if (isset($row['pdf']) && !empty($row['pdf'])) {
                        #echo "<a href='uploaded_files/" . $row['pdf'] . "'>Download File</a>";
                        echo '<a href="uploaded_files/'.$row['pdf'].'" target="_blank" class="btn">View File</a>';
                    } else {
                        echo "<p>No file available for download.</p>";
                    }
                    if($row['type']=='2'){
                      
                      $sql_grades = "SELECT * FROM grades WHERE module_id ='".$row['id']."' and user_id='".$user_id ."'"; 
                      $result_grades = $conn->prepare($sql_grades);
                      $result_grades->execute();
                      if ($result_grades !== false && $result_grades->rowCount() > 0) {
                        $row_grades= $result_grades->fetch(PDO::FETCH_ASSOC);
                        echo '<h2>Assignment has been uploaded</h2>';
                        echo '<a href="uploaded_files/'.$row_grades['document'].'" target="_blank" class="btn">View Assignment</a>';
                        echo '<h2>Grade:'.$row_grades['grade'].'</h2>';
                      }
                      else{
                        echo '<a href="upload_assignment.php?module='.$row['id'].'" class="btn btn-success">Upload File</a>';
                      }

                      
                    }
                   
                    echo "</div>";
                }
            } else {
                echo "<p>No modules found.</p>";
            }
            ?>

        </div>
    </section>

    <!-- footer section starts  -->
    <?php include 'components/footer.php'; ?>
    <!-- footer section ends -->

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
