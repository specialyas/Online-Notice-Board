<style>
  .form-container {
    max-width: 500px;
    /* margin: auto; */
    padding: 30px;
    background-color: #f8f9fa; /* light gray background */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .gray1 {
	color: #504B38
  }
</style>



<?php
extract($_POST);
if(isset($save))
{

	if($e=="" || $p=="")
	{
	$err="<font color='red'>fill all the fileds first</font>";
	}
	else
	{
$pass=md5($p);

$sql=mysqli_query($conn,"select * from user where email='$e' and pass='$pass'");

$r=mysqli_num_rows($sql);

if($r==true)
{
$_SESSION['user']=$e;
header('location:user');
}

else
{

$err="<font color='red'>Invalid login details</font>";

}
}
}

?>
<!-- <h2><b>LOGIN FORM</B></h2>
<form method="post">

	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4"><?php echo @$err;?></div>
	</div>



	<div class="row">
		<div class="col-sm-4">Email ID</div>
		<div class="col-sm-5">
		<input type="email" name="e" class="form-control"/></div>
	</div>

	<div class="row">
		<div class="col-sm-4">Password</div>
		<div class="col-sm-5">
		<input type="password" name="p" class="form-control"/></div>
	</div>
	<div class="row" style="margin-top:10px">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		<input type="submit" value="Login" name="save" class="btn btn-success"/>

		</div>
	</div>
</form>
 
undet 
-->
<div class="container mt-5 d-flex justify-content-center">
  <div class="form-container">
    <h2 class="mb-4 text-center gray1">LOGIN FORM</h2>

    <!-- <?php echo @$err; ?> -->

	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4"><?php echo @$err;?></div>
	</div>

    <form method="post">
		
      <div class="mb-3 row">
        <label for="email" class="form-label">Email ID</label>
        <input type="email" name="e" id="e" class="form-control" placeholder="Enter your mail">
      </div>

      <div class="mb-3 row">
        <label for="np" class="form-label">Password</label>
        <input type="password" name="p" id="p" class="form-control" placeholder="Enter password">
      </div>

      <div class="row d-flex gap-2 justify-content-center" style="margin-top:10px">
        <input type="submit" value="Login" name="save" class="btn btn-primary">
        <input type="reset" class="btn btn-danger">
      </div>

    </form>
  </div>
</div>
