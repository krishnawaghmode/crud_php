<?php include "head.php"; ?>
<body class="animsition">
    <div class="page-wrapper">
<?php include "menu.php"; ?>
        <!-- PAGE CONTAINER-->
        <div class="page-container">
<?php include "right.php"; ?>
           <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                         <h2>View Student</h2>
                       <!-- show alert msg -->
                        <?php 
                           if(isset($_SESSION['status'])){
                            ?>
                           <div class="alert alert-<?php echo $_SESSION['status']?>" role="alert">
                                 <?php echo $_SESSION['msg']?>
                           </div>
                        <?php 
                          unset($_SESSION['status']);
                          unset($_SESSION['msg']);
                    }?>
                        <div class="row">

                            <div class="col-lg-12 col-sm-12">
                                <div class="table-responsive table--no-card m-b-30">
       <?php $students = $obj->fetch_students();
       if ($students) { ?>
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                             <tr>
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Address</th>
                                    <th>Profile</th>
                                    <th>City</th>
                                    <th>Qualification</th>
                                    <th>Action</th>
                                </tr>
                                        </thead>
                                        <tbody>
             <?php
                $i = 1;
                foreach ($students as $list) {
              ?>
                                <tr>
                                    <td><?php echo $i++?></td>
                                    <td><?php echo $list['name']?></td>
                                    <td><?php echo date('d-m-Y',strtotime($list['dob']))?></td>
                                    <td><?php echo $list['address']?></td>
                                    <td> <img src="student_upload/<?php echo $list['photo']?>" class="img-thumbnail" alt="profile image"></td>
                                    <td><?php echo $list['city_name']?></td>
                                    <td><?php echo $list['qualifications']?></td>
                                    <td width="5%"><a href="manage_student.php?id=<?php echo $list['id']?>" class="badge badge-pill badge-success">Edit</a>&nbsp;&nbsp;&nbsp;<a href="manage_student.php?delete_id=<?php echo $list['id']?>" class="badge badge-pill badge-danger" onClick="return confirm('are you sure delete?')">Delete</a></td>
                                </tr>
                            <?php }?>
                            </tbody>
                                    </table>
                                      <?php }else{
                                        echo "<div class='alert alert-warning' role='alert'>No Record Found!</div>";
                                      } ?>
                                </div>
                            </div>
                           
                        </div>
                      
                      
                     
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>
    </div>
   <?php include "footer.php"; ?>
