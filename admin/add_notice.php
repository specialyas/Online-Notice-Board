<?php 
$success = false;
extract($_POST);
if(isset($add))
{
	if($details=="" || $sub=="" || $user=="")
	{
		$err="<div class='alert alert-danger'><i class='bi bi-exclamation-triangle-fill'></i> Please fill all the fields first</div>";	
	}
	else
	{
		foreach($user as $v)
		{
			mysqli_query($conn,"insert into notice values('','$v','$sub','$details',now())");
		}
		
		$err="<div class='alert alert-success'><i class='bi bi-check-circle-fill'></i> Notice added successfully!</div>";
		$success = true;
		// Clear form variables after successful submission
		$sub = "";
		$details = "";
		$user = array();
	}
}
?>

<style>
/* Modern form styling for Add Notice page */
.page-add-notice {
  background-color: #f8f9fa;
}

.modern-form-container {
  max-width: 800px;
  margin: 0 auto;
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  padding: 40px;
  margin-top: 20px;
}

.form-header {
  text-align: center;
  margin-bottom: 40px;
  padding-bottom: 20px;
  border-bottom: 2px solid #e9ecef;
}

.form-header h2 {
  color: #495057;
  font-weight: 600;
  margin: 0;
  font-size: 28px;
}

.form-header p {
  color: #6c757d;
  margin: 10px 0 0 0;
  font-size: 16px;
}

.form-group {
  margin-bottom: 25px;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #495057;
  margin-bottom: 8px;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-control-modern {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #e9ecef;
  border-radius: 8px;
  font-size: 16px;
  transition: all 0.3s ease;
  background-color: #f8f9fa;
}

.form-control-modern:focus {
  outline: none;
  border-color: #007bff;
  background-color: white;
  box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}

.textarea-modern {
  min-height: 120px;
  resize: vertical;
  font-family: inherit;
}

.user-selection-container {
  border: 2px solid #e9ecef;
  border-radius: 12px;
  padding: 20px;
  background-color: #f8f9fa;
}

.select-all-container {
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 15px;
}

.select-all-container label {
  margin: 0;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
}

.select-all-container input[type="checkbox"] {
  margin-right: 10px;
  transform: scale(1.2);
}

.users-list {
  max-height: 250px;
  overflow-y: auto;
  border: 1px solid #dee2e6;
  border-radius: 8px;
  padding: 15px;
  background: white;
}

.user-checkbox-item {
  padding: 8px 0;
  border-bottom: 1px solid #f1f3f4;
  transition: background-color 0.2s ease;
}

.user-checkbox-item:last-child {
  border-bottom: none;
}

.user-checkbox-item:hover {
  background-color: #f8f9fa;
}

.user-checkbox-item label {
  margin: 0;
  cursor: pointer;
  display: flex;
  align-items: center;
  font-weight: 500;
  color: #495057;
}

.user-checkbox-item input[type="checkbox"] {
  margin-right: 10px;
  transform: scale(1.1);
}

.form-actions {
  margin-top: 40px;
  text-align: center;
  padding-top: 20px;
  border-top: 2px solid #e9ecef;
}

.btn-modern {
  padding: 12px 30px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 16px;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  margin: 0 10px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-primary-modern {
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
}

.btn-primary-modern:hover {
  background: linear-gradient(135deg, #0056b3, #004085);
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,123,255,0.3);
}

.btn-secondary-modern {
  background: linear-gradient(135deg, #6c757d, #545b62);
  color: white;
}

.btn-secondary-modern:hover {
  background: linear-gradient(135deg, #545b62, #3d4043);
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(108,117,125,0.3);
}

.alert {
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 25px;
  border: none;
  font-weight: 500;
}

.alert-success {
  background: linear-gradient(135deg, #d4edda, #c3e6cb);
  color: #155724;
  border-left: 4px solid #28a745;
}

.alert-danger {
  background: linear-gradient(135deg, #f8d7da, #f1aeb5);
  color: #721c24;
  border-left: 4px solid #dc3545;
}

.alert i {
  margin-right: 8px;
}

.help-text {
  font-size: 14px;
  color: #6c757d;
  margin-top: 8px;
  font-style: italic;
}

/* Responsive design */
@media (max-width: 768px) {
  .modern-form-container {
    margin: 10px;
    padding: 20px;
  }
  
  .form-header h2 {
    font-size: 24px;
  }
  
  .btn-modern {
    width: 100%;
    margin: 5px 0;
  }
}
</style>

<div class="modern-form-container">
  <div class="form-header">
    <h2><i class="bi bi-plus-circle"></i> Add New Notice</h2>
    <p>Create and send notices to selected users</p>
  </div>

  <?php echo @$err; ?>

  <form method="post">
    <div class="form-group">
      <label class="form-label">
        <i class="bi bi-tag"></i> Notice Subject
      </label>
      <input type="text" name="sub" class="form-control-modern" placeholder="Enter the notice subject..." value="<?php echo isset($sub) ? htmlspecialchars($sub) : ''; ?>"/>
    </div>

    <div class="form-group">
      <label class="form-label">
        <i class="bi bi-file-text"></i> Notice Details
      </label>
      <textarea name="details" class="form-control-modern textarea-modern" placeholder="Enter the detailed notice content..."><?php echo isset($details) ? htmlspecialchars($details) : ''; ?></textarea>
    </div>

    <div class="form-group">
      <label class="form-label">
        <i class="bi bi-people"></i> Select Recipients
      </label>
      <div class="user-selection-container">
        <div class="select-all-container">
          <label>
            <input type="checkbox" id="selectAll">
            <i class="bi bi-check-all"></i> Select All Users
          </label>
        </div>
        
        <div class="users-list">
          <?php 
          $sql = mysqli_query($conn, "select name,email from user");
          while($r = mysqli_fetch_array($sql))
          {
            $checked = (isset($user) && is_array($user) && in_array($r['email'], $user)) ? 'checked' : '';
            echo "<div class='user-checkbox-item'>";
            echo "<label>";
            echo "<input type='checkbox' name='user[]' class='userCheckbox' value='".$r['email']."' $checked>";
            echo "<i class='bi bi-person'></i> ".$r['name'];
            echo "</label>";
            echo "</div>";
          }
          ?>
        </div>
        
        <div class="help-text">
          <i class="bi bi-info-circle"></i> Select one or more users to receive this notice
        </div>
      </div>
    </div>

    <div class="form-actions">
      <input type="submit" value="Send Notice" name="add" class="btn-modern btn-primary-modern"/>
      <input type="reset" value="Clear Form" class="btn-modern btn-secondary-modern"/>
    </div>
  </form>
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
  var isChecked = this.checked;
  var checkboxes = document.getElementsByClassName('userCheckbox');
  
  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = isChecked;
  }
});

// If any individual checkbox is unchecked, uncheck the "Select All"
var userCheckboxes = document.getElementsByClassName('userCheckbox');
for (var i = 0; i < userCheckboxes.length; i++) {
  userCheckboxes[i].addEventListener('change', function() {
    var selectAll = document.getElementById('selectAll');
    if (!this.checked) {
      selectAll.checked = false;
    } else {
      // Check if all individual checkboxes are checked
      var allChecked = true;
      for (var j = 0; j < userCheckboxes.length; j++) {
        if (!userCheckboxes[j].checked) {
          allChecked = false;
          break;
        }
      }
      selectAll.checked = allChecked;
    }
  });
}

<?php if (isset($success) && $success): ?>
// Clear form after successful submission
document.addEventListener('DOMContentLoaded', function() {
  // Clear all checkboxes
  var allCheckboxes = document.querySelectorAll('input[type="checkbox"]');
  allCheckboxes.forEach(function(checkbox) {
    checkbox.checked = false;
  });
});
<?php endif; ?>
</script>