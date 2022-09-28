<div id="signin-form-dialog" class="modal">
  
  <!--<input id='hidden-radio' name='hidden-radio' type='hidden' value='-1'>-->
  <form id="login-form" class="modal-content animate" method="post">
    <div class="imgcontainer">
        <span onclick="Signin_Modal(0)" class="close" title="Close Modal">&times;</span>
        <img src="<?php echo BASE_URL; ?>assets/static-files/avatar-profile.png" alt="Avatar" class="avatar">
    </div>

    <div id="error-block">
      
    </div>

    <div class="signin-container">
        <input class='login-input' type="text" placeholder="Type in your Username ..." name="uname" required>
        <input class='login-input' type="password" placeholder="Type in your Password ..." name="password" required>
        
        <button type="submit" class='login-btn' name='login-btn'">Login</button>
        <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
    </div>

    <div class="signin-container" style="background-color:#f1f1f1">
        <button type="button" onclick="Signin_Modal(0)" class="cancelbtn">Cancel</button>
        <span class="psw">Don't have an account <a href="#">Register Here</a></span>
    </div>
  </form>

</div>