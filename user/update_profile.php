<style>
  .form-container {
    max-width: 700px;
    margin: auto;
    padding: 30px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  }
  
  .form-section {
    margin-bottom: 25px;
  }
  
  .radio-group, .checkbox-group {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
  }
  
  .radio-item, .checkbox-item {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 12px;
    background-color: white;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  
  .radio-item:hover, .checkbox-item:hover {
    border-color: #007bff;
    background-color: #f8f9ff;
  }
  
  .radio-item input, .checkbox-item input {
    margin: 0;
  }
  
  .date-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }
  
  .date-select {
    flex: 1;
    min-width: 120px;
  }
  
  .readonly-field {
    background-color: #f8f9fa !important;
    cursor: not-allowed;
  }
  
  @media (max-width: 768px) {
    .form-container {
      margin: 10px;
      padding: 20px;
    }
    
    .radio-group, .checkbox-group {
      flex-direction: column;
    }
    
    .date-group {
      flex-direction: column;
    }
  }
</style>

<?php
extract($_POST);
if(isset($update))
{
    //dob
    $dob=$yy."-".$mm."-".$dd;
    //hobbies
    $hob=implode(",",$hob);

    $query="update user set name='$n',mobile='$mob',gender='$gen',hobbies='$hob',dob='$dob' where email='".$_SESSION['user']."'";
    mysqli_query($conn,$query);

    $err="<div class='alert alert-success'><i class='bi bi-check-circle'></i> Profile updated successfully!</div>";
}

//select old data
$sql=mysqli_query($conn,"select * from user where email='".$_SESSION['user']."'");
$res=mysqli_fetch_assoc($sql);
?>

<div class="container mt-5 d-flex justify-content-center">
  <div class="form-container">
    <h2 class="mb-4 text-primary text-center">
      <i class="bi bi-person-gear"></i>
      Update Your Profile
    </h2>

    <?php echo @$err; ?>

    <form method="post">
      <!-- Name Field -->
      <div class="form-section">
        <label for="name" class="form-label fw-bold">Full Name</label>
        <input 
          type="text" 
          id="name"
          name="n" 
          class="form-control" 
          value="<?php echo htmlspecialchars($res['name']); ?>"
          placeholder="Enter your full name"
          required
        >
      </div>

      <!-- Email Field -->
      <div class="form-section">
        <label for="email" class="form-label fw-bold">Email Address</label>
        <input 
          type="email" 
          id="email"
          name="e" 
          class="form-control readonly-field" 
          value="<?php echo htmlspecialchars($res['email']); ?>"
          readonly
        >
        <small class="text-muted">Email cannot be changed</small>
      </div>

      <!-- Mobile Field -->
      <div class="form-section">
        <label for="mobile" class="form-label fw-bold">Mobile Number</label>
        <input 
          type="tel" 
          id="mobile"
          name="mob" 
          class="form-control" 
          value="<?php echo htmlspecialchars($res['mobile']); ?>"
          placeholder="Enter your mobile number"
          pattern="[0-9]{10}"
        >
      </div>

      <!-- Gender Field -->
      <div class="form-section">
        <label class="form-label fw-bold">Gender</label>
        <div class="radio-group">
          <label class="radio-item">
            <input 
              type="radio" 
              name="gen" 
              value="m" 
              <?php if($res['gender']=="m"){echo "checked";} ?>
            >
            <i class="bi bi-person"></i>
            Male
          </label>
          <label class="radio-item">
            <input 
              type="radio" 
              name="gen" 
              value="f" 
              <?php if($res['gender']=="f"){echo "checked";} ?>
            >
            <i class="bi bi-person-dress"></i>
            Female
          </label>
        </div>
      </div>

      <!-- Hobbies Field -->
      <div class="form-section">
        <label class="form-label fw-bold">Hobbies</label>
        <?php $arrr=explode(",",$res['hobbies']); ?>
        <div class="checkbox-group">
          <label class="checkbox-item">
            <input 
              type="checkbox" 
              name="hob[]" 
              value="reading" 
              <?php if(in_array("reading",$arrr)){echo "checked";} ?>
            >
            <i class="bi bi-book"></i>
            Reading
          </label>
          <label class="checkbox-item">
            <input 
              type="checkbox" 
              name="hob[]" 
              value="singing" 
              <?php if(in_array("singing",$arrr)){echo "checked";} ?>
            >
            <i class="bi bi-mic"></i>
            Singing
          </label>
          <label class="checkbox-item">
            <input 
              type="checkbox" 
              name="hob[]" 
              value="playing" 
              <?php if(in_array("playing",$arrr)){echo "checked";} ?>
            >
            <i class="bi bi-controller"></i>
            Playing
          </label>
        </div>
      </div>

      <!-- Date of Birth Field -->
      <div class="form-section">
        <label class="form-label fw-bold">Date of Birth</label>
        <?php $arrr1=explode("-",$res['dob']); ?>
        <div class="date-group">
          <div class="date-select">
            <select name="yy" class="form-select" required>
              <option value="">Year</option>
              <?php
              for($i=1950;$i<=2005;$i++)
              {
              ?>
              <option value="<?php echo $i; ?>" <?php if($arrr1[0]==$i){echo "selected";} ?>>
                <?php echo $i; ?>
              </option>
              <?php } ?>
            </select>
          </div>
          
          <div class="date-select">
            <select name="mm" class="form-select" required>
              <option value="">Month</option>
              <?php
              $months = [
                1=>'January', 2=>'February', 3=>'March', 4=>'April',
                5=>'May', 6=>'June', 7=>'July', 8=>'August',
                9=>'September', 10=>'October', 11=>'November', 12=>'December'
              ];
              foreach($months as $num => $name)
              {
              ?>
              <option value="<?php echo $num; ?>" <?php if($arrr1[1]==$num){echo "selected";} ?>>
                <?php echo $name; ?>
              </option>
              <?php } ?>
            </select>
          </div>
          
          <div class="date-select">
            <select name="dd" class="form-select" required>
              <option value="">Day</option>
              <?php
              for($i=1;$i<=31;$i++)
              {
              ?>
              <option value="<?php echo $i; ?>" <?php if($arrr1[2]==$i){echo "selected";} ?>>
                <?php echo $i; ?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <!-- Submit Buttons -->
      <div class="d-flex gap-3 justify-content-center mt-4">
        <button type="submit" name="update" class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle"></i>
          Update Profile
        </button>
        <button type="reset" class="btn btn-outline-secondary btn-lg">
          <i class="bi bi-arrow-clockwise"></i>
          Reset
        </button>
      </div>
    </form>
  </div>
</div>