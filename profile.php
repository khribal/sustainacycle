<?php session_start(); 
//grab session vars
$userID=$_SESSION['userID'];
$email=$_SESSION['email'];
$name=$_SESSION['name'];
$lastName=$_SESSION['lastName'];
$tele=$_SESSION['tele'];

//connect to the database
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

//set edit mode as false for user details form
$editMode = false;
//form was submitted (image upload)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["uploadImage"]) && $_FILES["uploadImage"]["error"] == 0){
        //get the photo information
        $file_name = $_FILES["uploadImage"]["name"];
        $file_temp = $_FILES["uploadImage"]["tmp_name"];
        $file_size = $_FILES["uploadImage"]["size"];
        
        //move it to the local folder
        $upload_directory = __DIR__ . "/uploads/";
        if(move_uploaded_file($file_temp, $upload_directory . $file_name)){
            
        }
        //!!!!!!!!!!FIX URL FOR TEAM!!!!!!!!!!!!//
        //create url for the image
        $image_url = "https://cgi.luddy.indiana.edu/~klhribal/team20/uploads/" . $file_name;

        //set the new session profile pic
        $_SESSION['profilePic'] = $image_url;
        
        //update their profile pic in the database
        $updateQuery = "UPDATE users SET profilePic='$image_url' WHERE userID='$userID'";
        
        $updateResult = $conn->query($updateQuery);
    } elseif(isset($_POST['userDetailsForm'])){
        
    }
}
//close conn
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <?php include('./includes/boot-head.php'); ?>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body class="profile-body">
<?php include('./includes/nav.php'); ?>

<div class="container">
    <div class="row">
        <div class="col rounded border text-center d-flex flex-column" style="height: fit-content;">
        <form action="profile.php" method="post" enctype="multipart/form-data" id="imageUploadForm">
            <label for="profileImage" id="profile-container"> 
                <img src="<?php if (isset($_SESSION['profilePic']) && $_SESSION['profilePic'] != ""){
                    echo $_SESSION['profilePic'];}else{ echo "./img/empty-profile.jpg";}?>" alt="blank-profile-pic" class="empty-profile align-self-center" id="profileImage" style="width: 250px; height: 250px; object-fit: cover; border-radius: 50%;">
                <p class="profile-hover">Click to change your profile picture</p>
            </label>
            <!-- hidden input to allow users to upload img -->
            <input type="file" id="uploadImage" name="uploadImage" style="display:none;" accept="image/*">
        </form>
                <p><strong><?php echo $_SESSION['username']; ?></strong></p>
                <p><?php echo $_SESSION['email']; ?></p>
        </div>

        <!--  -->
        <div class="col-6 rounded border">
        <?php 
            // Enable edit mode to show save button if necessary
            $isEditMode = isset($_POST['editBtn']);

            // Display user details in read-only or editable mode
            echo '<div data-user-id=' . $userID . '>
                    <form method="post" action="profile.php" id="profile-form">
                        <h5>First Name: ' . ($isEditMode ? '<input type="text" name="editFirstName" value="' . $name . '">' : $name) . '</h5>
                        <h5>Last Name: ' . ($isEditMode ? '<input type="text" name="editLastName" value="' . $lastName . '">' : $lastName) . '</h5>
                        <h5>Phone: ' . ($isEditMode ? '<input type="text" name="editPass" value="' . $tele . '">' : $tele) . '</h5>
                        <div class="row">
                            <div class="col-sm">
                                <input type="hidden" name="userID" value="' . $userID . '">
                                ' . ($isEditMode ? '<button type="submit" class="btn btn-success" name="saveBtn">Save Changes</button>' : '<button type="submit" class="btn btn-primary" name="editBtn">Edit</button>') . '
                            </div>
                        </div>
                    </form>
                </div>';
            ?>
        </div>

        <div class="col rounded border">
            smaller
        </div>
    </div>
</div>


<script>
    //change profile pic script
    document.getElementById('profileImage').addEventListener('click', function() {
        document.getElementById('uploadImage').click();
    });

    // If you want to preview the selected image before submitting
    document.getElementById('uploadImage').addEventListener('change', function(event) {
        var fileInput = event.target;
        var imgElement = document.getElementById('profileImage');
        var form = document.getElementById('imageUploadForm'); 

        var reader = new FileReader();
        reader.onload = function(e) {
            imgElement.src = e.target.result;
            imgElement.style.width = '250px';
            imgElement.style.height = '250px';

            imgElement.style.objectFit = 'cover';

            imgElement.style.borderRadius = '50%';
            
            //submit form to update user image
            form.submit();
        };
        
        reader.readAsDataURL(fileInput.files[0]);
    });

</script>


<?php 
include('./includes/footer.php');
include('./includes/boot-script.php'); ?>
</body>
</html>