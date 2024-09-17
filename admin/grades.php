<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
   $tutor_id = $_COOKIE['tutor_id'];
} else {
   $tutor_id = '';
   header('location:login.php');
}

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
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
      body.dark-mode {
         color: #fff;
      }
   </style>
</head>
<body>
<style>
table.table tr td { font-size: 14px; border:1px }
input[type="text"], textarea {
   background-color : #d1d1d1; 
}
</style>
<?php include '../components/admin_header.php'; ?>
   
<section class="comments">

   <h1 class="heading">Select modules</h1>

   <div class="show-comments">

   <div class="box" style="text-align: center;">
      <h3 class="title" style="margin-bottom: .5rem;">Select Assignment to grade</h3>
      <form action="grades.php" method="GET"> <!-- Use a form to submit the module parameter -->
         <select name="module" data-select-name required>
            <option value="" selected disabled>-- Select Module --</option>
            <?php
              $select_modules = $conn->prepare("SELECT * FROM `module` WHERE tutor_id = ? and type=? ORDER BY date DESC");
              $select_modules->execute([$tutor_id,2]);

              if ($select_modules->rowCount() > 0) {
                while ($fetch_module = $select_modules->fetch(PDO::FETCH_ASSOC)) {
                  if ($fetch_module['id']==$_GET['module'])
                    echo "<option value='".$fetch_module['id']."' selected>".$fetch_module['title']."</option>";
                  else
                    echo "<option value='".$fetch_module['id']."'>".$fetch_module['title']."</option>";
                }
              }
            ?>
        </select>
        <button type="submit">Go</button> <!-- Add a submit button to submit the form -->
      </form>
   </div>

   </div>

   <br>
   <br>
<h1 class="heading">Grading</h1>

<div class="show-comments">

<div class="box" style="text-align: center;">
<table class="table">
  <thead>
    <tr>
      <td>Student Name</td>
      <td>Assignment Title</td>
      <td>Description </td>
      <td>Grade</td>
      <td>Action</td>
    </tr>
    <?php
      if(isset($_GET['module'])) { // Check if the 'module' parameter is set in the URL
        $selected_module = $_GET['module'];
        $select = $conn->prepare("SELECT
        grades.id,
        users.name, 
        module.title, 
        grades.description, 
        grades.document, 
        grades.grade
      FROM
        grades
        INNER JOIN
        users
        ON 
          grades.user_id = users.id
        INNER JOIN
        module
        ON 
          grades.module_id = module.id WHERE grades.tutor_id = ? and grades.module_id=? ");
        $select->execute([$tutor_id, $selected_module]);

        if ($select->rowCount() > 0) {
          while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td><p>".$row['name']."</p></td>";
            echo "<td>".$row['title']."</td>";
            echo "<td><a href='../uploaded_files/".$row['document']."' >".$row['description']."</a></td>";
            if($row['grade']==0){
              echo "<td><input type='text' size='10' id='".$row['id']."' value='".$row['grade']."'></input></td>";
               echo "<td><button class='btn' onclick=\"saveData('".$row['id']."')\">Save</button></td>";          
            }else{
              echo "<td><input type='text' size='10' id='".$row['id']."' value='".$row['grade']."'></input></td>";
              echo "<td><button class='btn' onclick=\"saveData('".$row['id']."')\">Update</button></td>";  
            }

            echo "</tr>";
          }
        }
      }
    ?>
  </thead>
  <tbody>
    
  </tbody>
</table>
</div>

</section>



<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded',function() {
        document.querySelector('select[data-select-name]').onchange=changeEventHandler;
    },false);

    function changeEventHandler(event) {
        window.location.href = "grades.php?module="+this.options[this.selectedIndex].value;
    }
    function saveData(id) {
      //alert(id)
      grade=document.getElementById(id).value;
      //alert(grade)

      // Create a new XMLHttpRequest object
      var xhr = new XMLHttpRequest();

      // Configure the request
      xhr.open("POST", "grade_save.php"); // Replace "/save" with your server endpoint URL

      // Set the onload and onerror event handlers
      xhr.onload = function () {
        if (xhr.status === 200) {
          // Request succeeded
          console.log(xhr.responseText);
          if(xhr.responseText==="Berhasil"){
            alert("Success")
            location.reload();
          }
        } else {
          // Request failed
          console.log("Error: " + xhr.status);
        }
      };

      xhr.onerror = function () {
        console.log("Request failed");
      };

      // Set the request headers (if needed)
      // xhr.setRequestHeader("Content-Type", "application/json");

      // Set the request data
      var data = {
        id: id,
        grade:grade
      };

      // Convert the data to JSON string
      var jsonData = JSON.stringify(data);

      // Send the request
      xhr.send(jsonData);
}

</script>

</body>
</html>
