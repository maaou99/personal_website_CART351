<?php
//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'POST')
{

   if(isset($_POST['project_name'])){
       $theMessage ="";

    $fcolor = $_POST['tools'];
    $fanimal = $_POST['allLinks'];
    $fnum = $_POST['artists'];
    $fimage = $_POST['images'];
    $fimage = $_POST['description'];
    // output something with these values::


   $myPackagedData=new stdClass();
   $myPackagedData->response = $theMessage;
   $testObj = json_encode($myPackagedData);
   echo($testObj);
  
  exit;
  
  }
}
  

?>
<!DOCTYPE html>
<html>
<head>
  
<link rel="stylesheet" href="css/galleryStyle.css">
<title>INPUT to GET in php</title>
</head>
<style>

</style>
<body>
 
<div class = "wrapper">

  <h2> SHARE YOUR ARTWORK! </h2>
<form id ="getForm" enctype="multipart/form-data" method="post">
  <div id="grid">

    <div class="item item-1">
    <p><label>Name of Project</label><br><input type = "text" size="24" maxlength = "40"  name = "project_name" required></p>
    </div>

    <div class="item item-2">
    <p><label>Tools used</label><br><input type = "text" size="24" maxlength = "40"  name = "tools" required></p>
    </div>

    <div class="item item-3">
   
    <p><label>Artists</label><br><input type="text" id="linkInput"  name="artists" ></p>
    <button onclick="addLink()" id = "add-artist" >Add Artist</button>
    <div id="linkContainer">
    <!-- Links will be added here dynamically -->
  </div>
    </div>
    <div class="item item-4">
    <p><label>Link to other artwork</label><br><input id="linkArt"  type = "text" placeholder="https://example.com" size="24" maxlength = "40"  name = "artists" min="1" max="100" required></p>
 
    </div>
    

    <div class="item item-6">
    <p><label>Description</label><br><textarea class="txtarea" name="description"  style="height:50px; width:200px" rows="3" name="Text" id="description-txt" value=""> </textarea></p>
    </div>

  </div>
  
  <p><button name = "submit" value = "SEND" id =buttonS>SUBMIT</button></p>
  
  <input type="hidden" name="allLinks" id="allLinks" value="">

</form>
</div>
<div id = "result"  ></div>

<script>
 window.onload = function () {
    console.log("ready");
    document.querySelector("#getForm").addEventListener("submit", function (event) {
    event.preventDefault();
      console.log("button clicked");
      console.log("form has been submitted");

      let linkArtText = document.getElementById('linkArt').value

    
      // Set the value of the hidden input with the links array
      document.getElementById('allLinks').value = JSON.stringify(linksArray);

      let formData = new FormData(document.querySelector("#getForm"));

      const queryString = new URLSearchParams(formData).toString();

      fetch("4-writeToFileWithForm.php?" + queryString)
        .then(function (response) {
          return response.json();
        })
        .then(function (jsonData) {
          console.log(jsonData);
          displayMessage(jsonData);
        });

        clearInputFields();
    });

  // Clear all input fields after submitting
 
  function clearInputFields() {
      // Get all input fields in the form
      var inputFields = document.querySelectorAll('#getForm input');

      // Loop through each input field and set its value to an empty string
      inputFields.forEach(function (input) {
         input.value = '';
      
      });

      document.getElementById('description-txt').value = '';


      // Clear the link container
      document.getElementById('linkContainer').innerHTML = '';

      // Clear the links array
      linksArray = [];
    }

        function displayMessage(messageObj){
        document.querySelector("#result").textContent = messageObj.response;
        }
      }

    // Get the linkArt input element
    let linkArtInput = document.getElementById('linkArt');

     // Add an event listener for the blur event (when the input field loses focus)
     linkArtInput.addEventListener('blur', function () {
      validateLinkInput(linkArtInput.value);
    });
    
    function validateLinkInput(linkUrl) {
      if (isValidUrl(linkUrl)) {
        // The input is a valid URL
        // You can perform any additional actions or provide feedback to the user
      } else {
        // The input is not a valid URL
        alert('Please enter a valid URL for the link to other artwork.');
      }
    }

        // Array to store links
        let linksArray = [];

      function isValidUrl(url) {
      // Regular expression to check if the input is a valid URL
      let urlPattern = /^(https?:\/\/)?([\w.]+)\.([a-z]{2,})\b(\/\S*)?$/i;
      return urlPattern.test(url);
    }


      function addLink() {
      // Get the value of the input field
      let linkUrl = document.getElementById('linkInput').value;

         // Check if the input is a valid URL
         if (true) {

           // Add the link to the array
           linksArray.push(linkUrl);
 
        // Create a new anchor element
        let newLink = document.createElement('p');

        // Set the inner text (display text) of the link
        newLink.innerText = linkUrl;
 

        // Append the paragraph to the link container
        document.getElementById('linkContainer').appendChild(newLink);

         // Clear the input field for the next entry
        document.getElementById('linkInput').value = '';
      } else {
        alert('Please enter a valid URL.');
      }
    }
 </script>
 </body>
</html>