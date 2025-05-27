<?php
require('./db/connection.php');
extract($_POST);
if(isset($save))
{
//check user alereay exists or not
$sql=mysqli_query($conn,"select * from user where email='$e'");

$r=mysqli_num_rows($sql);

if($r==true)
{
$err= "<font color='red'>This user already exists</font>";
}
else
{
//dob
$dob=$yy."-".$mm."-".$dd;

//hobbies
$hob=implode(",",$hob);
 
//image
$imageName=$_FILES['img']['name'];


//encrypt your password
$pass=md5($p);


$query="insert into user values('','$n','$e','$pass','$mob','$gen','$hob','$imageName','$dob',now())";
mysqli_query($conn,$query);

//upload image

mkdir("images/$e");
move_uploaded_file($_FILES['img']['tmp_name'],"images/$e/".$_FILES['img']['name']);


$err="<font color='blue'>Registration successfull !!</font>";

}
}

?>



<h2 class="text-center mb-4"><b>REGISTRATION FORM</b></h2>

<?php if (isset($err)) : ?>
  <div class="alert alert-<?php echo strpos($err, 'success') !== false ? 'success' : 'danger'; ?> text-center p-2">
    <?php echo $err; ?>
  </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="mx-auto p-4 border rounded shadow-sm" style="max-width: 600px; font-size: 1.5rem;">
  <div class="form-group mb-3">
    <label for="name">Your Name</label>
    <input type="text" class="form-control" name="n" id="name" required>
  </div>

  <div class="form-group mb-3">
    <label for="email">Your Email</label>
    <input type="email" class="form-control" name="e" id="email" required>
  </div>

  <div class="form-group mb-3">
    <label for="password">Your Password</label>
    <input type="password" class="form-control" name="p" id="password" required>
  </div>

  <div class="form-group mb-3">
    <label for="mob">Your Mobile No.</label>
    <input type="number" class="form-control" name="mob" id="mob" required>
  </div>

  <div class="form-group mb-3">
    <label class="d-block">Select Your Gender</label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="gen" value="m" id="male" required>
      <label class="form-check-label" for="male">Male</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="gen" value="f" id="female">
      <label class="form-check-label" for="female">Female</label>
    </div>
  </div>

  <div class="form-group mb-3">
    <label class="d-block">Choose Your Hobbies</label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="hob[]" value="reading" id="reading">
      <label class="form-check-label" for="reading">Reading</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="hob[]" value="singing" id="singing">
      <label class="form-check-label" for="singing">Singing</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="hob[]" value="playing" id="playing">
      <label class="form-check-label" for="playing">Playing</label>
    </div>
  </div>

  <div class="form-group mb-3">
    <label for="img">Upload Your Image</label>
    <input type="file" class="form-control" name="img" id="img" required>
  </div>

  <div class="form-group mb-4">
    <label class="d-block">Date of Birth</label>
    <div class="d-flex flex-wrap gap-2">
      <select name="yy" class="form-control w-auto me-2" required>
        <option value="">Year</option>
        <?php for ($i = 1950; $i <= 2016; $i++) echo "<option>$i</option>"; ?>
      </select>

      <select name="mm" class="form-control w-auto me-2" required>
        <option value="">Month</option>
        <?php for ($i = 1; $i <= 12; $i++) echo "<option>$i</option>"; ?>
      </select>

      <select name="dd" class="form-control w-auto" required>
        <option value="">Date</option>
        <?php for ($i = 1; $i <= 31; $i++) echo "<option>$i</option>"; ?>
      </select>
    </div>
  </div>

  <div class="text-center">
    <input type="submit" class="btn btn-primary px-4" value="Save" name="save">
    <input type="reset" class="btn btn-secondary px-4" value="Reset">
  </div>
</form>
