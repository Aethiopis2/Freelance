<div id="signup-form-dialog" class="modal">
  
  <form id="login-form" class="modal-content animate" method="post" action="<?php echo BASE_URL; ?>index.php"
    enctype="multipart/form-data">
    <div class="imgcontainer">
        <span onclick="Signup_Modal(0)" class="close" title="Close Modal">&times;</span>
        <img src="<?php echo BASE_URL; ?>assets/static-files/avatar-profile.png" alt="Avatar" class="avatar">
    </div>

    <div id="error-block">
      
    </div>

    <div class="signin-container">
        <input type="text" name="fullname" placeholder="Full name" required>

        <div class="popup">
            <span class="popuptext" id="myPopup">Username already exists</span>
        </div>
        
        <input type="text" name="username" 
            onchange="User_Exists(this.value)" placeholder="Username" required>
        
        <div class="popup">
            <span class="popuptext" id="myPopup2">Invalid email address</span>
        </div>
        <input type="email" name="email" placeholder="Email" onchange="Verify_Email(this.value)" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="passwordConfirmation" placeholder="Password confirmation" requried>
        <input type="number" name="tel" placeholder="Tel">
        <textarea name="bio" id="bio" cols="30" rows="10" placeholder="Bio ..."></textarea>
        <input type="file" name="avatar" value="<?php echo $avatar; ?>" placeholder="Avatar ...">
        
        <input type="hidden" id="email-verified" name="email-v">
        <input type="hidden" id="username-verified" name="username-v">

        <button type="submit" class='login-btn' name='register-btn'">Register</button>
    </div>

    <div class="signin-container" style="background-color:#f1f1f1">
        <button type="button" onclick="Signup_Modal(0)" class="cancelbtn">Cancel</button>
    </div>
  </form>

</div>