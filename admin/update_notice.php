<?php
// Extract all POST data into individual variables
extract($_POST);

// Check if the "update" button was clicked
if (isset($update)) {
    
    // Check if at least one user is selected
    if (isset($user) && !empty($user)) {

        // 1. Update the main notice record (subject and description) for the given notice_id
        mysqli_query($conn, "UPDATE notice SET subject='$sub', Description='$details' WHERE notice_id='".$_GET['notice_id']."'");

        // 2. Fetch current users that this notice_id is assigned to
        $current_users_result = mysqli_query($conn, "SELECT user FROM notice WHERE notice_id='".$_GET['notice_id']."'");
        $current_users = array();
        while ($row = mysqli_fetch_array($current_users_result)) {
            $current_users[] = $row['user'];
        }

        // 3. Find users that were newly selected and not in current_users
        $users_to_add = array_diff($user, $current_users);

        // 4. Find users that had the notice before but are now unselected
        $users_to_remove = array_diff($current_users, $user);

        // 5. Insert new rows for users that are added
        foreach ($users_to_add as $new_user) {
            mysqli_query($conn, "INSERT INTO notice VALUES ('', '$new_user', '$sub', '$details', NOW())");
        }

        // 6. Delete rows for users that are removed (if any)
        if (!empty($users_to_remove)) {
            $users_to_remove_str = "'" . implode("','", $users_to_remove) . "'";
            mysqli_query($conn, "DELETE FROM notice WHERE notice_id='".$_GET['notice_id']."' AND user IN ($users_to_remove_str)");
        }

        // Success message
        $err = "<font color='blue'>Notice updated for ".count($user)." user(s)</font>";

    } else {
        // Error message if no user was selected
        $err = "<font color='red'>Please select at least one user</font>";
    }
}

// Fetch the notice details to display in the form fields
$q = mysqli_query($conn, "SELECT * FROM notice WHERE notice_id='".$_GET['notice_id']."' LIMIT 1");
$res = mysqli_fetch_array($q);

// Get list of current users associated with this notice
$current_users_query = mysqli_query($conn, "SELECT user FROM notice WHERE notice_id='".$_GET['notice_id']."'");
$current_users = array();
while ($current_user = mysqli_fetch_array($current_users_query)) {
    $current_users[] = $current_user['user'];
}
?>
<h2>UPDATE NOTICE</h2>
<form method="post">

    <!-- Show success or error messages -->
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"><?php echo @$err;?></div>
    </div>

    <!-- Subject input -->
    <div class="row">
        <div class="col-sm-4">Enter Subject</div>
        <div class="col-sm-5">
            <input type="text" name="sub" value="<?php echo htmlspecialchars($res['subject']); ?>" class="form-control" required/>
        </div>
    </div>

    <!-- Description textarea -->
    <div class="row" style="margin-top:10px">
        <div class="col-sm-4">Enter Details</div>
        <div class="col-sm-5">
            <textarea name="details" class="form-control" required><?php echo htmlspecialchars($res['Description']); ?></textarea>
        </div>
    </div>

    <!-- User selection checkboxes -->
    <div class="row" style="margin-top:10px">
        <div class="col-sm-4">Select User(s)</div>
        <div class="col-sm-5">
            <div class="form-group">
                <!-- Select All checkbox -->
                <label><input type="checkbox" id="selectAll"> <strong>Select All Users</strong></label>
            </div>

            <!-- User checkboxes -->
            <div class="form-group" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                <?php 
                // Load all users from the DB
                $sql = mysqli_query($conn, "SELECT name, email FROM user");
                while ($r = mysqli_fetch_array($sql)) {
                    $checked = in_array($r['email'], $current_users) ? 'checked' : '';
                    echo "<div class='checkbox'>";
                    echo "<label><input type='checkbox' name='user[]' class='userCheckbox' value='".$r['email']."' $checked> ".$r['name']."</label>";
                    echo "</div>";
                }
                ?>
            </div>
            <p class="small text-muted">You can select multiple users for this notice</p>
            <div id="selectedCount" class="text-info"></div>
        </div>
    </div>

    <!-- Submit and Reset buttons -->
    <div class="row" style="margin-top:10px">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <input type="submit" value="Update Notice" name="update" class="btn btn-success"/>
            <input type="reset" class="btn btn-secondary"/>
        </div>
    </div>
</form>

<!-- JavaScript Section -->
<script>
// Updates the displayed count of selected users
function updateSelectedCount() {
    const count = document.querySelectorAll('.userCheckbox:checked').length;
    document.getElementById('selectedCount').textContent = count + ' users selected';
}

// "Select All" checkbox logic
document.getElementById('selectAll').addEventListener('change', function () {
    const isChecked = this.checked;
    const checkboxes = document.getElementsByClassName('userCheckbox');

    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = isChecked;
    }

    updateSelectedCount();
});

// Individual checkbox logic to toggle "Select All" state
const userCheckboxes = document.getElementsByClassName('userCheckbox');
for (let i = 0; i < userCheckboxes.length; i++) {
    userCheckboxes[i].addEventListener('change', function () {
        const selectAll = document.getElementById('selectAll');

        if (!this.checked) {
            selectAll.checked = false;
        } else {
            let allChecked = true;
            for (let j = 0; j < userCheckboxes.length; j++) {
                if (!userCheckboxes[j].checked) {
                    allChecked = false;
                    break;
                }
            }
            selectAll.checked = allChecked;
        }

        updateSelectedCount();
    });
}

// Initialize the user count when page loads
updateSelectedCount();

// Prevent form submission if no users are selected
document.querySelector('form').addEventListener('submit', function (e) {
    const selectedUsers = document.querySelectorAll('.userCheckbox:checked').length;

    if (selectedUsers === 0) {
        e.preventDefault();
        alert('Please select at least one user to send the notice to.');
    }
});
</script>
