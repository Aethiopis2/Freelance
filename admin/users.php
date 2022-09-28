<?php require_once('include/admin-header-section.php'); 
    $page_name = "Manage Users";
    $current_selection = 3; 
?>

    <title>Xpress Media | Manage Users</title>
</head>
<body>
    
    <!-- ============================= Sidebar ============================= -->
    
    <?php require_once('include/admin-sidebar.php'); ?>
    
    <!--X============================= Sidebar =============================X-->

    <!-- ============================= Main-content ============================= -->
    
    <div class="main-content">

        <!-- ============================= Header bar ============================= -->

        <?php require_once('include/admin-headbar.php'); ?>

        <!--X============================= Header bar =============================X-->

        <!-- ============================= Main ============================= -->
        <main>
        <div class="container content">
                <div class="action">
                    <?php if($isEditingUser === true): ?>
                        <h4 class="page-title">Update User</h4>
                    <?php else: ?>
                        <h4 class="page-title">Create user</h4>
                    <?php endif ?>

                    <form action="<?php echo BASE_URL . 'admin/users.php'; ?>" method="POST" enctype="multipart/form-data">
                        <!-- editing a user requires id --> 
                        <?php if($isEditingUser === true): ?>
                            <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                        <?php endif ?>

                        <input type="text" name="fullname" value="<?php echo $fullname; ?>" placeholder="Full name" required>

                        <div class="popup">
                            <span class="popuptext" id="myPopup">Username already exists</span>
                        </div>
                        <input type="text" name="username" value="<?php echo $username; ?>" 
                                onchange="User_Exists(this.value)" placeholder="Username" required>

                        <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email" required>

                        <?php if ($isEditingUser === true): ?> 
                            <input type="password" name="old_password" placeholder="Old password ...">
                            <input type="password" name="password" placeholder="Password">
                            <input type="password" name="passwordConfirmation" placeholder="Password confirmation">
                        <?php else: ?>
                            <input type="password" name="password" placeholder="Password" required>
                            <input type="password" name="passwordConfirmation" placeholder="Password confirmation" requried>
                        <?php endif ?>
                        
                        <input type="number" name="tel" value="<?php echo $tel; ?>" placeholder="Tel">
                        
                        <?php if(!isset($bio)): ?>
                            <textarea name="bio" id="bio" cols="30" rows="10" placeholder="Bio ...">
                        <?php else: ?>
                            <textarea name="bio" id="bio" cols="30" rows="10" placeholder="Bio ..."><?php echo $bio; ?></textarea>
                        <?php endif ?>
                        
                        <input type="file" name="avatar" value="<?php echo $avatar; ?>" placeholder="Avatar ...">
                        <select name="role" required>
                            <option value="" selected disabled>Assign role</option>
                            <?php foreach ($user_roles as $key => $role): ?>
                                <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                            <?php endforeach ?>
                        </select>

                        <!-- if editing user, display the update button instead of create button -->
                        <div class="admin-button-wrapper">
                            <?php if ($isEditingUser === true): ?> 
                                <button type="submit" class="admin-btn" name="update-user">Update</button>
                            <?php else: ?>
                                <button type="submit" class="admin-btn" name="create-user">Save</button>
                            <?php endif ?>
                        </div>

                    </form>
                </div>

                <!-- display records from db -->
                <div class="table-div">
                    
                    <!-- display notification message -->
                    <?php include(ROOT_PATH . 'admin/include/messages.php'); ?>


                    <?php if(empty($user_info)): ?>
                        <h1>No users in the database</h1>
                    <?php else: ?>
                        <h4>Users</h4>
                        <table class="table">
                            <thead>
                                <th>N</th>
                                <th>Full Name</th>
                                <th>User Info</th>
                                <th>Role</th>
                                <th colspan="2">Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($all_users as $key => $admin): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $admin['fullname']; ?></td>
                                        <td>
                                            <?php echo $admin['username']; ?>
                                            <?php echo $admin['email']; ?>
                                        </td>
                                        <td><?php echo $admin['user_role']; ?></td>
                                        <td class="table-icon">
                                            <a href="users.php?edit-user=<?php echo $admin['id']; ?>"
                                                style="color:green;" onMouseOut="style.color='green'" 
                                                onMouseOver="style.color='aqua'">
                                                <span class="fa fa-pencil btn edit"></span>
                                            </a>
                                        </td>
                                        <td class="table-icon">
                                            <a href="users.php?delete-user=<?php echo $admin['id']; ?>"
                                                style="color:red;" onMouseOut="style.color='red'" 
                                                onMouseOver="style.color='aqua'">
                                            <span class="fa fa-trash btn delete"></span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php endif ?>
                    
                </div>

            </div>
        </main>
        <!--X============================= Main =============================X-->

    </div>

    <!--X============================= Main-content =============================X-->


    <!-- ============================= Javascript ============================= -->
    <script src="<?php echo BASE_URL; ?>js/jquery3.6.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>js/all.js"></script>
    <script src="<?php echo BASE_URL; ?>js/admin-script.js"></script>

    <!--X============================= Javascript =============================X-->
</body>
</html>