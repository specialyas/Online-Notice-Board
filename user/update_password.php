<style>
  .form-container {
    max-width: 500px;
    margin: auto;
    padding: 30px;
    background-color: #f8f9fa; /* light gray background */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
</style>

<?php
extract($_POST);
if(isset($save))
{
	if($np=="" || $cp=="" || $op=="")
	{
		$err="<div class='alert alert-danger'>Please fill in all fields.</div>";
	}
	else
	{
		$op=md5($op);

		$sql=mysqli_query($conn,"select * from user where pass='$op'");
		$r=mysqli_num_rows($sql);
		if($r==true)
		{
			if($np==$cp)
			{
				$np=md5($np);
				$sql=mysqli_query($conn,"update user set pass='$np' where email='$user'");
				$err="<div class='alert alert-success'>Password updated successfully.</div>";
			}
			else
			{
				$err="<div class='alert alert-warning'>New password and Confirm Password do not match.</div>";
			}
		}
		else
		{
			$err="<div class='alert alert-danger'>Wrong Old Password.</div>";
		}
	}
}
?>

<div class="container mt-5 d-flex justify-content-center">
  <div class="form-container">
    <h2 class="mb-4 text-primary text-center">Update Password</h2>

    <?php echo @$err; ?>

    <form method="post">
      <div class="mb-3">
        <label for="op" class="form-label">Old Password</label>
        <input type="password" name="op" id="op" class="form-control" placeholder="Enter old password">
      </div>

      <div class="mb-3">
        <label for="np" class="form-label">New Password</label>
        <input type="password" name="np" id="np" class="form-control" placeholder="Enter new password">
      </div>

      <div class="mb-3">
        <label for="cp" class="form-label">Confirm Password</label>
        <input type="password" name="cp" id="cp" class="form-control" placeholder="Re-enter new password">
      </div>

      <div class="d-flex gap-2 justify-content-center">
        <input type="submit" value="Update Password" name="save" class="btn btn-primary">
        <input type="reset" class="btn btn-secondary">
      </div>
    </form>
  </div>
</div>