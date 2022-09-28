<?php require_once('include/admin-header-section.php'); 
    $page_name = "Manage Adverts";
    $current_selection = 9; 

    $ad_types = ["Banner", "Slide-Show", "Home"];
    $ads = Get_Adverts();
?>

    <title>Xpress Media | Manage FAQs</title>
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
                    <?php if($isEditingAdvert === true): ?>
                        <h4 class="page-title">Update Advert</h4>
                    <?php else: ?>
                        <h4 class="page-title">New Advert</h4>
                    <?php endif ?>

                    <form action="<?php echo BASE_URL . 'admin/adverts.php'; ?>" method="POST" 
                        enctype='multipart/form-data' class="modal-content animate">
                            <!-- editing a faq requires id --> 
                            <?php if($isEditingAdvert === true): ?>
                                <input type="hidden" name="advert-id" value="<?php echo $advert_id; ?>">
                            <?php endif ?>

                            <select name="ad-type" required>
                                <option value="" selected disabled>Select Ad Type</option>
                                <?php foreach ($ad_types as $key => $ad): ?>
                                    <option value="<?php echo $ad; ?>"><?php echo $ad; ?></option>
                                <?php endforeach ?>
                            </select>
                            <input type="text" name="ad-slogan" value="<?php echo $ad_slogan; ?>" placeholder="Slogan ..."
                                required>
                            <input type="text" name="ad-link" value="<?php echo $ad_link; ?>" 
                                placeholder="Ad link ..." required>

                            <label for="">Date From/Starting Date</label>
                            <input type="date" name="ad-date-from" value="<?php echo $date_from; ?>" placeholder="Start date ...">

                            <label for="">Date To/Ending Date</label>
                            <input type="date" name="ad-date-to" value="<?php echo $date_to; ?>" placeholder="End date ...">
                            
                            <label for="">Upload picture</label>
                            <input type="file" name="ad-picture[]" value="<?php echo $ad_picture; ?>" 
                                placeholder="Upload pics ..." multiple>

                            <div class="admin-button-wrapper">
                                <?php if ($isEditingAdvert === true): ?> 
                                    <button type="submit" class="admin-btn" name="update-ad">Update</button>
                                <?php else: ?>
                                    <button type="submit" class="admin-btn" name="create-ad">Save</button>
                                <?php endif ?>
                            </div>
                    </form>

                    <?php if($isEditingAdvert === true): ?>
                        <?php $ad_slides = Get_Ad_Slides_By_Ad_Id($advert_id); ?>
                        <div class="table-div">
                            <!-- display notification message -->
                            <?php include(ROOT_PATH . 'admin/include/messages.php'); ?>

                            <?php if(empty($ad_slides)): ?>
                                <h1></h1>
                            <?php else: ?>
                                <h1 style="margin:1rem">Ad Slides</h1>
                                <table class="table">
                                    <thead>
                                        <th>N</th>
                                        <th>Filepath</th>
                                        <th colspan="2">Action</th>
                                    </thead>

                                    <tbody>
                                        <?php foreach($ad_slides as $key => $ad): ?>
                                            <tr>
                                                <td><?php echo $key + 1; ?></td>

                                                <?php if($ad_slide_id != $ad['id']): ?>
                                                    <td><?php echo $ad['filepath']; ?></td>
                                                <?php else: ?>
                                                    <td colspan="10">
                                                        <form action="<?php echo BASE_URL . 'admin/adverts.php'; ?>" 
                                                            method="POST" enctype="multipart/form-data">
                                                            <input type="hidden" name="slide-id" value="<?php echo $ad['id']; ?>">
                                                            <label for="">Upload picture</label>
                                                            <input type="file" name="ad-slide-path" 
                                                                value="<?php echo $ad_slide_path; ?>" 
                                                                placeholder="Upload pics ...">
                                                            <button type="submit" class="admin-btn" 
                                                                name="update-ad-slide">Update</button>
                                                        </form>
                                                    </td>
                                                <?php endif ?>

                                                <td class="table-icon">
                                                    <a href="adverts.php?edit-ad-slide=<?php echo $ad['id'] ?>,<?php echo $ad['advert_id'] ?>"
                                                        style="color:green;" onMouseOut="style.color='green'" 
                                                        onMouseOver="style.color='aqua'">
                                                        <span class="fa fa-pencil btn edit"></span>
                                                    </a>
                                                </td>
                                                <td class="table-icon">
                                                    <a href="adverts.php?delete-ad-slide=<?php echo $ad['id'] ?>"
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
                    <?php endif ?>

                </div>

                <!-- display records from db -->
                <div class="table-div">
                    <!-- display notification message -->
                    <?php include(ROOT_PATH . 'admin/include/messages.php'); ?>

                    <?php if(empty($ads)): ?>
                        <h1>No Ads in the database</h1>
                    <?php else: ?>
                        <h1 style="margin:1rem">All Ads</h1>
                        <table class="table">
                            <thead>
                                <th>N</th>
                                <th>Slogan</th>
                                <th>Type</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Slide Count</th>
                                <th colspan="2">Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($ads as $key => $ad): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $ad['slogan']; ?></td>
                                        <td><?php echo $ad['type']; ?></td>
                                        <td><?php echo $ad['date_from']; ?></td>
                                        <td><?php echo $ad['date_to']; ?></td>
                                        <td><?php echo $ad['TotalSlides']; ?></td>
                                        <td class="table-icon">
                                            <a href="adverts.php?edit-ad=<?php echo $ad['id'] ?>"
                                                style="color:green;" onMouseOut="style.color='green'" 
                                                onMouseOver="style.color='aqua'">
                                                <span class="fa fa-pencil btn edit"></span>
                                            </a>
                                        </td>
                                        <td class="table-icon">
                                            <a href="adverts.php?delete-ad=<?php echo $ad['id'] ?>"
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
    <script src="<?php echo BASE_URL; ?>js/ckeditor.js"></script>
    <script src="<?php echo BASE_URL; ?>js/admin-script.js"></script>

    <!--X============================= Javascript =============================X-->
</body>
</html>