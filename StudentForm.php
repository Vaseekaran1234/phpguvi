<?php
include 'crud.php';
$nameError = "";
$mobilenoError = "";
$emailError = "";
$dobError = "";
$addressError = "";
$englishError = "";
$tamilError = "";
$phpError = "";
$s = new StudentDetails(); 

if (isset($_GET['id']) && $_GET['action'] == 'view') {
  $ids = $_GET['id'];
  $s = $s->viewRecord($ids);
} else if (isset($_GET['id']) && $_GET['action'] == 'delete') {
  $ids = $_GET['id'];
  $s->delete($ids);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>Validation</title>
</head>

<body>
  <?php
  if (isset($_POST["submit"])) {
    $nameError = $s->setName($_POST['name']);
    $mobilenoError = $s->setMobileNo($_POST['mobileno']);
    $emailError = $s->setEmail($_POST['email']);
    $dobError = $s->setDOB($_POST['dob']);
    $addressError = $s->setAddress($_POST['address']);
    $englishError = $s->setEnglish($_POST['english']);
    $tamilError = $s->setTamil($_POST['tamil']);
    $phpError = $s->setPhp($_POST['php']);
    $s->setID($_POST['id']);
    if (
      empty($nameError) && empty($mobilenoError) && empty($emailError) && empty($dobError) &&
      empty($addressError) && empty($englishError) && empty($tamilError) && empty($phpError)
    ) {
      $msg = $s->save();
      echo "<script>alert('$msg');</script>";
    }
  }
  ?>

  <div class="area">
    <div class="container">
      <h1>Student Details</h1>
      <form method="post" onsubmit="return valid()" action='StudentForm.php' enctype="multipart/form-data">
        <label for="name"><b>Fullname</b></label><br />
        <input type="hidden" name="id" id="id" value='<?= $s->getID() ?>' />
        <input type="text" oninput="nameValid()" class="inputs" name="name" id="name" min="3" max="100" placeholder="Fullname" value='<?= $s->getName() ?>' />
        <div style="color: red" id="nameError"><?php echo $nameError;  ?></div>
        <br />
        <label for="mobileno"><b>Mobile Number</b></label><br />
        <input type="text" oninput="mobilenoValid()" class="inputs" name="mobileno" id="mobileno" placeholder="Mobile Number" max="10" value='<?php echo $s->getMobileNo(); ?>' />
        <div style="color: red" id="mobilenoError"><?php echo $mobilenoError; ?></div>
        <br />

        <label for="email"><b>Email </b></label><br />
        <input type="text" onkeypress="emailvalid()" id="email" class="inputs" name="email" placeholder="email" value='<?php echo $s->getEmail(); ?>' />
        <div style="color: red" id="emailError"><?php echo $emailError; ?></div>
        <br />

        <label for="dob"><b>Date of Birth </b></label><br />
        <input type="date" onclick="dobvalid()" id="dob" name="dob" class="inputs" value='<?php echo $s->getDOB() ?>' /><br />
        <div style="color: red" id="dobError"><?php echo $dobError; ?></div>
        <br />

        <label for="address"><b>Address </b></label><br />
        <textarea onclick="addressvalid()" id="address" class="inputs" name="address" maxlength="100" placeholder="Address"><?php echo $s->getAddress() ?></textarea><br />
        <div style="color: red" id="addressError"><?php echo $addressError; ?></div>
        <br />

        <label for="english"><b>English Mark </b></label><br />
        <input type="number" onclick="englishvalid()" class="inputs" id="english" name="english" placeholder="english" value='<?php echo $s->getEnglish(); ?>' /><br />
        <div style="color: red" id="englishError"><?php echo $englishError; ?></div>
        <br />

        <label for="tamil"><b>Tamil Mark</b></label><br />
        <input type="number" onclick="tamilvalid()" class="inputs" id="tamil" name="tamil" placeholder="tamil" value='<?php echo $s->getTamil() ?>' /><br />
        <div style="color: red" id="tamilError"><?php echo $tamilError; ?></div>
        <br />

        <label for="php"><b>PHP Mark</b></label><br />
        <input type="number" onclick="phpvalid()" class="inputs" id="php" name="php" placeholder="php" value='<?php echo $s->getPHP() ?>' /><br />
        <div style="color: red" id="phpError"><?php echo $phpError; ?></div>
        <br />

        <label><b>Profile Photo</b></label><br />
        <input type="file" onclick="imageValid()" id="image-input" name="profileImage" accept="image/*" /><br />
        <div style="color: red" id="images"></div>
        <br />

        <?php echo $s->getImage() ?>

        <br /><br /><br />
        <span style="left: 0"><button class="buttons-primary" name="submit" id="submit">
            Save
          </button></span>
        <span style="float: right; padding-right: 80px;"><button class="buttons-primary" name="" id="submit">
            <a href="index.php" style="color: black; text-decoration: none;"> Show table</a>
          </button></span>
        <br /><br />
      </form>
    </div>
  </div>
  <script>
    function valid() {
      var name = document.getElementById("name");
      var nameError = document.getElementById("nameError");

      var mobileno = document.getElementById("mobileno");
      var mobilenoError = document.getElementById("mobilenoError");

      var email = document.getElementById("email");
      var emailError = document.getElementById("emailError");
      const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

      var dob = document.getElementById("dob");
      var dobError = document.getElementById("dobError");

      var english = document.getElementById("english");
      var englishError = document.getElementById("englishError");

      var tamil = document.getElementById("tamil");
      var tamilError = document.getElementById("tamilError");

      var php = document.getElementById("php");
      var phpError = document.getElementById("phpError");

      var address = document.getElementById("address");
      var addressError = document.getElementById("addressError");

      const imageInput = document.getElementById("image-input");

      const id = document.getElementById("id");

      var isValid = true;

      if (name.value.length < 3 || name.value.length > 100) {
        name.style.border = "1px solid red";
        nameError.innerHTML =
          "Enter the valid name";
        isValid = false;
      }

      if (name.value === "") {
        name.style.border = "1px solid red";
        nameError.innerHTML = "Please enter your name";
        isValid = false;
      }

      if (parseInt(mobileno.value.length) != 10) {
        mobileno.style.border = "1px solid red";
        mobilenoError.innerHTML = "Please enter a valid mobile number";
        isValid = false;
      }

      if (mobileno.value == "") {
        mobileno.style.border = "1px solid red";
        mobilenoError.innerHTML = "Please enter your mobile number";
        isValid = false;
      }

      if (!emailRegex.test(email.value)) {
        email.style.border = "1px solid red";
        emailError.innerHTML = "Please enter a valid Email";
        isValid = false;
      }

      if (!email.value) {
        email.style.border = "1px solid";
        email.style.borderColor = "red";
        emailError.innerHTML = "Please enter the Email";
        isValid = false;
      }

      if (!dob.value) {
        dob.style.border = "1px solid";
        dob.style.borderColor = "red";
        dobError.innerHTML = "Please enter the DOB";
        isValid = false;
      } else {
        dob.style.border = "";
        dob.style.borderColor = "";
        dobError.innerHTML = "";
      }

      var dates = document.getElementById("dob");
      dates = dates.value;
      dates = dates.split('-');
      var today = new Date();
      var year = today.getFullYear();
      var month = today.getMonth() + 1;
      var day = today.getDate();

      if (year - dates[0] <= 0 && month - dates[1] <= 0) {
        dob.style.border = "1px solid";
        dob.style.borderColor = "red";
        dobError.innerHTML = "Please enter the valid DOB";
        isValid = false;
      }

      if (!english.value) {
        english.style.border = "1px solid";
        english.style.borderColor = "red";
        englishError.innerHTML = "Please enter the english mark";
        isValid = false;
      } else {
        english.style.border = "";
        english.style.borderColor = "";
        englishError.innerHTML = "";
      }
      if (!(english.value >= 0 && english.value <= 100)) {
        english.style.border = "1px solid";
        english.style.borderColor = "red";
        englishError.innerHTML = "Please enter the valid english mark";
        isValid = false;
      }
      if (!tamil.value) {
        tamil.style.border = "1px solid";
        tamil.style.borderColor = "red";
        tamilError.innerHTML = "Please enter the tamil mark";
        isValid = false;
      } else {
        tamil.style.border = "";
        tamil.style.borderColor = "";
        tamilError.innerHTML = "";
      }
      if (!(tamil.value >= 0 && tamil.value <= 100)) {
        tamil.style.border = "1px solid";
        tamil.style.borderColor = "red";
        tamilError.innerHTML = "Please enter the valid tamil mark";
        isValid = false;
      }
      if (!php.value) {
        php.style.border = "1px solid";
        php.style.borderColor = "red";
        phpError.innerHTML = "Please enter the php mark";
        isValid = false;
      } else {
        php.style.border = "";
        php.style.borderColor = "";
        phpError.innerHTML = "";
      }
      if (!(php.value >= 0 && php.value <= 100)) {
        php.style.border = "1px solid";
        php.style.borderColor = "red";
        phpError.innerHTML = "Please enter the valid php mark";
        isValid = false;
      }

      if (!address.value) {
        address.style.border = "1px solid";
        address.style.borderColor = "red";
        addressError.innerHTML = "Please enter the address";
        isValid = false;
      } else {
        address.style.border = "";
        address.style.borderColor = "";
        addressError.innerHTML = "";
      }
      if (!(address.value.length <= 1000)) {
        address.style.border = "1px solid";
        address.style.borderColor = "red";
        addressError.innerHTML = "Please enter the valid address";
        isValid = false;
      }

      if(id.value==0){
      const file = imageInput.files[0];
      if (file) {
        if (validateImage(file)) {  
          // isValid = true;
        } else {
          images.innerHTML =
            "Invalid image format. Please upload a valid image file.";
          isValid = false;
        }
      } else {
        images.innerHTML = "Please select an image to upload.";
        isValid = false;
      }
    }


      function validateImage(file) {
        const allowedFormats = ["image/jpeg", "image/png", "image/gif"];
        return allowedFormats.includes(file.type);
      }

      if (isValid) {
        var confirmation = confirm("Are you sure you want to submit?");
        if (!confirmation) {
          return false;
        }
        alert("Form submitted successfully");
      }
      return isValid;
    }

    function nameValid() {
      var name = document.getElementById("name");
      var nameError = document.getElementById("nameError");

      if (name.value !== "") {
        name.style.border = "";
        nameError.innerHTML = "";
      }
    }

    function mobilenoValid() {
      var mobileno = document.getElementById("mobileno");
      var mobilenoError = document.getElementById("mobilenoError");

      if (mobileno.value !== "") {
        mobileno.style.border = "";
        mobilenoError.innerHTML = "";
      }
    }

    function emailvalid() {
      var email = document.getElementById("email");
      var emailError = document.getElementById("emailError");
      email.style.border = "";
      email.style.borderColor = "";
      emailError.innerHTML = "";
    }

    function dobvalid() {
      var dob = document.getElementById("dob");
      var dobError = document.getElementById("dobError");
      dob.style.border = "";
      dob.style.borderColor = "";
      dobError.innerHTML = "";
    }

    function englishvalid() {
      var english = document.getElementById("english");
      var englishError = document.getElementById("englishError");
      english.style.border = "";
      english.style.borderColor = "";
      englishError.innerHTML = "";
    }

    function tamilvalid() {
      var tamil = document.getElementById("tamil");
      var tamilError = document.getElementById("tamilError");
      tamil.style.border = "";
      tamil.style.borderColor = "";
      tamilError.innerHTML = "";
    }

    function phpvalid() {
      var php = document.getElementById("php");
      var phpError = document.getElementById("phpError");
      php.style.border = "";
      php.style.borderColor = "";
      phpError.innerHTML = "";
    }

    function addressvalid() {
      var address = document.getElementById("address");
      var addressError = document.getElementById("addressError");
      address.style.border = "";
      address.style.borderColor = "";
      addressError.innerHTML = "";
    }

    function imageValid() {
      images.innerHTML = "";
    }
  </script>
</body>
</html>