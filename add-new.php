<?php
include "db_conn.php";

if (isset($_POST["submit"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    // Check if a file has been uploaded
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['pdf_file']['name'];
        $file_tmp = $_FILES['pdf_file']['tmp_name'];

        // Check file size
        if ($_FILES['pdf_file']['size'] <= 2097152) { // 2MB in bytes
            $randomno = rand(0, 100000);
            $rename = 'Upload' . date('Y-m-d_H-i-s') . $randomno;
            $newname = $rename . ' ' . $file_name;
            $new_path = "./uploads/" . $newname;

            // Move uploaded file to destination
            if (move_uploaded_file($file_tmp, $new_path)) {
                // Insert data into database
                $sql = "INSERT INTO `crud`(`id`, `first_name`, `last_name`, `email`, `gender`, `pdf_file`) 
                        VALUES (NULL,'$first_name','$last_name','$email','$gender', '$newname')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    header("Location: index.php?msg=New record created successfully");
                    exit;
                } else {
                  ?>
                     <div class="alert alert-success text-center">
                        <a class="close" data-dismiss="alert" aria-label="close">X</a>
                        <strong>Connection is Failed!</strong>
                        <?php
                           mysqli_error($conn);
                        ?>
                     </div>
                  <?php
                }
            } else {
               ?>
                  <div class="alert alert-success text-center">
                     <a class="close" data-dismiss="alert" aria-label="close">X</a>
                     <strong>Wrong!</strong> File upload failed!
                  </div>
               <?php
            }
        } else {
            ?>
               <div class="alert alert-success text-center">
                  <a class="close" data-dismiss="alert" aria-label="close">X</a>
                  <strong>Wrong!</strong> File size must be less than 2 MB.
               </div>
            <?php
        }
    } else {
         ?>
            <div class="alert alert-success text-center">
               <a class="close" data-dismiss="alert" aria-label="close">X</a>
               <strong>Wrong!</strong> Please select a PDF file to upload.
            </div>
         <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>PHP CRUD Application</title>
</head>

<body>
   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #2D0981; color: white;">
      PHP Complete CRUD Application
   </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Add New User</h3>
         <p class="text-muted">Complete the form below to add a new user</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">First Name:</label>
                  <input type="text" class="form-control" name="first_name" placeholder="FirstName">
               </div>

               <div class="col">
                  <label class="form-label">Last Name:</label>
                  <input type="text" class="form-control" name="last_name" placeholder="LastName">
               </div>
            </div>

            <div class="mb-3">
               <label class="form-label">Email:</label>
               <input type="email" class="form-control" name="email" placeholder="name@example.com">
            </div>

            <div class="form-group mb-3">
               <label>Gender:</label>
               &nbsp;
               <input type="radio" class="form-check-input" name="gender" id="male" value="male">
               <label for="male" class="form-input-label">Male</label>
               &nbsp;
               <input type="radio" class="form-check-input" name="gender" id="female" value="female">
               <label for="female" class="form-input-label">Female</label>
            </div>
            
            <div class="mb-3">
               <label for="pdf_file" class="form-label"> Choose PDF file</label>
               <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf" required>
               <input type="hidden" name="MAX_FILE_SIZE" value="2097152"> <!-- 2MB in bytes -->
            </div>

            <div>
               <button type="submit" class="btn btn-success" name="submit">Save</button>
               <a href="index.php" class="btn btn-danger">Cancel</a>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>