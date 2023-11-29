<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['project_name'])) {

        $projectName = $_GET['project_name'];
        $tools = $_GET['tools'];
        $links = json_decode($_GET['allLinks']);
        $artists = $_GET['artists'];
        $description = $_GET['description'];
        

        // If you use fopen() on a file that does not exist, it will create it,
        // given that the file is opened for writing (w) or appending (a).
        $file = fopen("files/testInput.txt", "a") or die("Unable to open file!");

        // Write the form data to the file with a newline character
        fwrite($file, "Project Name: $projectName\n");
        fwrite($file, "Tool: $tools\n");
        // Write the links as a value of the 'links' key
        fwrite($file, "Artists: " . implode(', ', $links) . "\n");
        fwrite($file, "Links: $artists\n");
        fwrite($file, "description:  $description\n");
        // Handle image upload
    
       $uploadDir = 'uploads/';
       $uploadedImage = $_FILES['uploadedImage'];


if (!empty($uploadedImage['name'])) {
    $uploadPath = $uploadDir . basename($uploadedImage['name']);

    if (move_uploaded_file($uploadedImage['tmp_name'], $uploadPath)) {
        // Image uploaded successfully
        $theMessage .= "Image uploaded successfully. ";
        $fimage = $uploadPath; // Use $fimage as needed

        // Append image information to the file
        fwrite($file, "image:   $fimage\n");
    } else {
        // Failed to upload image
        $theMessage .= "Failed to upload image. ";
    }
}
        // Close the file
        fclose($file);

        $outArray = array();
        $outArray["response"] = "\u{2713}";
        $myJSONObj = json_encode($outArray);
        echo $myJSONObj;

        // You must exit
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $targetDir = "uploads/"; // Specify the target directory
    $targetFile = $targetDir . basename($_FILES["image"]["name"]); // Specify the file path

    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>

