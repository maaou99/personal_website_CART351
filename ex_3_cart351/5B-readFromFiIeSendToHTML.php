<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["requestFile"])) {
  $path = "files/" . $_GET["requestFile"];
  $theFile = fopen($path, "r") or die("Unable to open file!");

  $outArr = array();
  $NUM_PROPS = 5;

  while (!feof($theFile)) {
      $packObj = new stdClass();

      for ($j = 0; $j < $NUM_PROPS; $j++) {
          $str = fgets($theFile);
          $splitArr = explode(":", $str, 2);
          $key = trim($splitArr[0]);
          $val = trim($splitArr[1]);
          $packObj->$key = $val;
      }

      $outArr[] = $packObj;
  }

  fclose($theFile);

  $myJSONObj = json_encode($outArr);
  echo $myJSONObj;
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>5- READ AND OUTPUT EXAMPLE </title>


<style>
 
.wrapper-flex{
  display:flex;
  background-color:#FBA5A6;
  flex-wrap: wrap;
  margin-top: 5%;
}
.single_container{
  background-color: #f9806ba3;
  width:25%;
  margin:3%;
  color:white;
  overflow-wrap: break-word; /** wrap text */
  padding:1%;
  
}
.single_container h1{
    padding:2%;
   

}
.single_container h2{
    padding:2%;
    

}
.single_container h3{
    padding:2%;
 

}
span{
  display:inline-block;
  color:#3f211c;
 

}
#result{
  color:white;
  position: absolute;
  transform: translate(-50%, -50%);
  left: 50%;
  width: 900px;
  top: 50%;
}

#result > button{
  border: 2px;
  position: absolute;
  transform: translate(-50%, -50%);
  left: 50%;
  top: 50%;
   
}

h3{
  background-color: #f9816b;
  margin-right: 5%;
}




</style>

</head>
<body>
  <!-- NEW for the result -->
<div id = "result">
  <button id="button-result"><h2> SEE ARTWORK PROJECTS </h2></button>
  <div class = "wrapper-flex"></div> </div>
<script>

// here we put our JQUERY

window.onload = function () {

    console.log("in doc load");

    window.addEventListener("click", getDataOnClickGET);

    function getDataOnClickGET() {
        fetch('5B-readFromFiIeSendToHTML.php/?requestFile=testInput.txt')
            .then(function (data) {
                return data.json();
            })
            .then(function (res) {
                console.log(res);
                showResults(res);
            });

            function showResults(arrayFromServer) {
              document.getElementById("button-result").remove()
              //CHATGPT, 
              //console.log(arrayFromServer);
            document.querySelector(".wrapper-flex").innerHTML = "";

            for (let i = 0; i < arrayFromServer.length; i++) {
                let container = document.createElement("div");
                container.classList.add("single_container");

                for (const key in arrayFromServer[i]) {
                    let heading = document.createElement("h3");

                    // Handle the 'Links' key separately
                    if (key.toLowerCase() === 'links') {
                        let linksArray = arrayFromServer[i][key].split(', ');
                        heading.innerHTML = `<span>${key.toUpperCase()}:</span> ${linksArray.join(', ')}`;
                    
                    } else if (key.toLowerCase() === 'image') {
            // Display the image as an <img> element
            let img = document.createElement("img");
            img.src = arrayFromServer[i][key];
            img.alt = 'Image';

            let imageContainer = document.createElement("div");
            imageContainer.classList.add("image-container");
            imageContainer.appendChild(img);

            container.appendChild(imageContainer);
                    }
                    else {
                        heading.innerHTML = `<span>${key.toUpperCase()}:</span> ${arrayFromServer[i][key]}`;
                    }

                    container.appendChild(heading);
                }

                document.querySelector(".wrapper-flex").appendChild(container);
            }
        }
    }
};

</script>
</body>
</html>
