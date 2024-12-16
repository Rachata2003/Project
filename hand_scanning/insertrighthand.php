<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Define the target directory and filename
    $target_dir = "./";
    $target_file = $target_dir . "righthand.jpg";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["handImage"]["name"], PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["handImage"]["tmp_name"]);
    if ($check !== false) {
        echo "File is uploaded successfully.";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Allow only specific file formats (jpg, jpeg, png)
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "Sorry, only JPG, JPEG, & PNG files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 due to an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
    } else {
        // If everything is ok, try to upload the file
        if (move_uploaded_file($_FILES["handImage"]["tmp_name"], $target_file)) {
            echo "The file has been uploaded as 'righthand.jpg'.<br>";
            // Redirect to insertformpg1.php located in data_collection folder
            header("Location: ../data_collection/insertformpg1.php"); // Adjusted path to go up one level and into the data_collection folder
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hand Image Upload</title>
</head>
<body>
    <h1>Take a photo of your right hand</h1>
    <form action="insertrighthand.php" method="post" enctype="multipart/form-data">
        <input type="file" accept="image/*" capture="camera" name="handImage" required>
        <br><br>
        <input type="submit" value="Upload Image">
    </form>
</body>
</html>
