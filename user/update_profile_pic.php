<style>
  .form-container {
    max-width: 600px;
    margin: auto;
    padding: 30px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  }
  
  .profile-section {
    text-align: center;
    margin-bottom: 30px;
  }
  
  .current-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #007bff;
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
    margin-bottom: 15px;
    transition: transform 0.3s ease;
  }
  
  .current-image:hover {
    transform: scale(1.05);
  }
  
  .no-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    color: white;
    font-size: 48px;
    border: 4px solid #007bff;
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
  }
  
  .upload-area {
    border: 2px dashed #007bff;
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    background-color: #f8f9ff;
    transition: all 0.3s ease;
    margin-bottom: 20px;
    cursor: pointer;
  }
  
  .upload-area:hover {
    border-color: #0056b3;
    background-color: #e6f3ff;
  }
  
  .upload-area.dragover {
    border-color: #28a745;
    background-color: #e8f5e8;
  }
  
  .file-input {
    display: none;
  }
  
  .upload-icon {
    font-size: 48px;
    color: #007bff;
    margin-bottom: 15px;
  }
  
  .upload-text {
    color: #6c757d;
    margin-bottom: 10px;
  }
  
  .file-info {
    background-color: #e9ecef;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
    display: none;
  }
  
  .file-info.show {
    display: block;
  }
  
  .preview-container {
    margin-top: 20px;
    text-align: center;
  }
  
  .preview-image {
    max-width: 200px;
    max-height: 200px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }
  
  @media (max-width: 768px) {
    .form-container {
      margin: 10px;
      padding: 20px;
    }
    
    .current-image, .no-image {
      width: 120px;
      height: 120px;
    }
    
    .upload-area {
      padding: 20px;
    }
  }
</style>

<?php 
$user = $_SESSION['user'];
extract($_POST);

if(isset($update))
{
    $img = $_FILES['f']['name'];
    
    // Create user directory if it doesn't exist
    $user_dir = "../images/$user/";
    if (!file_exists($user_dir)) {
        mkdir($user_dir, 0777, true);
    }
    
    $query = "update user set image='$img' where email='".$_SESSION['user']."'";
    mysqli_query($conn, $query);
    
    move_uploaded_file($_FILES['f']['tmp_name'], $user_dir . $_FILES['f']['name']);
    
    $err = "<div class='alert alert-success'><i class='bi bi-check-circle'></i> Profile picture updated successfully!</div>";
}

// Select old data
$sql = mysqli_query($conn, "select * from user where email='".$_SESSION['user']."'");
$res = mysqli_fetch_assoc($sql);
?>

<div class="container mt-5 d-flex justify-content-center">
  <div class="form-container">
    <h2 class="mb-4 text-primary text-center">
      <i class="bi bi-camera"></i>
      Update Profile Picture
    </h2>

    <?php echo @$err; ?>

    <!-- Current Profile Picture Section -->
    <div class="profile-section">
      <h5 class="text-muted mb-3">Current Profile Picture</h5>
      <?php if(!empty($res['image']) && file_exists("../images/$user/".$res['image'])): ?>
        <img src="../images/<?php echo $user.'/'.$res['image']; ?>" 
             alt="Current Profile Picture" 
             class="current-image">
      <?php else: ?>
        <div class="no-image">
          <i class="bi bi-person"></i>
        </div>
      <?php endif; ?>
      <p class="text-muted small">
        <?php echo !empty($res['image']) ? 'Click to change your profile picture' : 'No profile picture set'; ?>
      </p>
    </div>

    <form method="post" enctype="multipart/form-data" id="uploadForm">
      <!-- File Upload Area -->
      <div class="upload-area" onclick="document.getElementById('fileInput').click()">
        <div class="upload-icon">
          <i class="bi bi-cloud-upload"></i>
        </div>
        <div class="upload-text">
          <strong>Click to choose a file</strong> or drag and drop
        </div>
        <small class="text-muted">
          Supported formats: JPG, PNG, GIF (Max size: 5MB)
        </small>
        
        <input 
          type="file" 
          name="f" 
          id="fileInput"
          class="file-input"
          accept="image/*"
          onchange="handleFileSelect(this)"
          required
        >
      </div>

      <!-- File Information -->
      <div id="fileInfo" class="file-info">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <i class="bi bi-file-image text-primary"></i>
            <span id="fileName" class="ms-2"></span>
          </div>
          <div>
            <small id="fileSize" class="text-muted"></small>
          </div>
        </div>
      </div>

      <!-- Image Preview -->
      <div id="previewContainer" class="preview-container" style="display: none;">
        <h6 class="text-muted mb-2">Preview:</h6>
        <img id="imagePreview" class="preview-image" alt="Preview">
      </div>

      <!-- Submit Button -->
      <div class="d-flex gap-3 justify-content-center mt-4">
        <button type="submit" name="update" class="btn btn-primary btn-lg" id="submitBtn" disabled>
          <i class="bi bi-upload"></i>
          Update Profile Picture
        </button>
        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="resetForm()">
          <i class="bi bi-x-circle"></i>
          Cancel
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function handleFileSelect(input) {
    const file = input.files[0];
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const submitBtn = document.getElementById('submitBtn');
    
    if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            resetForm();
            return;
        }
        
        // Validate file size (5MB limit)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB.');
            resetForm();
            return;
        }
        
        // Show file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileInfo.classList.add('show');
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
        
        // Enable submit button
        submitBtn.disabled = false;
    } else {
        resetForm();
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function resetForm() {
    document.getElementById('uploadForm').reset();
    document.getElementById('fileInfo').classList.remove('show');
    document.getElementById('previewContainer').style.display = 'none';
    document.getElementById('submitBtn').disabled = true;
}

// Drag and drop functionality
const uploadArea = document.querySelector('.upload-area');

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('dragover');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('fileInput').files = files;
        handleFileSelect(document.getElementById('fileInput'));
    }
});
</script>