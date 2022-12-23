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

<?php
$page_name = 'Add';
 //get data specific id
if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $id = $_GET["id"];
    $edit_data = $obj->specific_id_data("students", $id);
    $page_name = 'Edit';
}
?>


                         <h2><?php echo $page_name?> Student</h2>
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
<?php
//get data specific id
if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $id = $_GET["id"];
    $edit_data = $obj->specific_id_data("students", $id);
}
//delete record
if (isset($_GET["delete_id"]) && $_GET["delete_id"] > 0) {
    $id = $_GET["delete_id"];
    if ($obj->delete("students", $id)) {
        $_SESSION['msg'] = 'Student record deleted successfully';
        $_SESSION['status'] = 'success';
        echo '<script>window.location.href="view_student.php?msg=deleted";</script>';
    } else {
        $_SESSION['msg'] = 'Student record not deleted';
        $_SESSION['status'] = 'danger';
        echo '<script>window.location.href="view_student.php?msg=delete_error";</script>';
    }
}
//add new student
if (isset($_POST["save_btn"])) {
    // echo "<pre>";
    // print_r($_POST);die;
     $name = $_POST["name"];
     $address = $_POST["address"];
     $dob = $_POST["dob"];
     $city_id = $_POST["city_id"];
     $qualification_ids = implode(',', $_POST["qualification_ids"]);
    // photo upload
    $new_file_name = str_replace(' ','-',strtolower(rand(1000,100000)."-".$_FILES['photo']['name']));
    $file_temp = $_FILES['photo']['tmp_name'];
    //check folder
    if (!file_exists('student_upload/')) {
      mkdir('student_upload', 0777, true);
    }
    $folder="student_upload/";
    if(move_uploaded_file($file_temp,$folder.$new_file_name)){
        if ($obj->addStudent($name,$address,$dob,$city_id,$qualification_ids,$new_file_name)) {
            $_SESSION['msg'] = 'Student added successfully';
            $_SESSION['status'] = 'success';
            echo '<script>window.location.href="manage_student.php?msg=added";</script>';
        } else {
            $_SESSION['msg'] = 'Not added student record!';
            $_SESSION['status'] = 'danger';
            echo '<script>window.location.href="manage_student.php?msg=added_error";</script>';
        }
    }

}
//update
if (isset($_POST["update_btn"])) {
    //  echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // die;
    $id = $_POST["id"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $photo = $_POST["old_photo"];
    $dob = $_POST["dob"];
    $city_id = $_POST["city_id"];
    $qualification_ids = implode(',', $_POST["qualification_ids"]);
    $folder="student_upload/";
     // edit photo upload
    if(!empty($_FILES['photo']['name'])){
        unlink($folder.$photo);
        $photo = str_replace(' ','-',strtolower(rand(1000,100000)."-".$_FILES['photo']['name']));
        $file_temp = $_FILES['photo']['tmp_name'];
        move_uploaded_file($file_temp,$folder.$photo);
    }
    if ($obj->updateStudent($id,$name,$address,$dob,$city_id,$qualification_ids,$photo)) {
         $_SESSION['msg'] = 'student updated successfully';
         $_SESSION['status'] = 'success';
        echo '<script>window.location.href="view_student.php?msg=updated";</script>';
    } else {
        $_SESSION['msg'] = 'student record not updated';
        $_SESSION['status'] = 'danger';
        echo '<script>window.location.href="view_student.php?msg=update_error";</script>';
    }
}
?>  

       <div class="col-lg-12 col-md-12 col-sm-12">
          <form action="" method="post" enctype="multipart/form-data">
               <div class="card">
                  <div class="card-body">

                     <div class="form-group">
                        <label for="name" class="control-label mb-1">Name</label>
                        <input name="name" type="text" class="form-control" value="<?php if (
                            isset($edit_data["name"])
                        ) {
                            echo $edit_data["name"];
                        } ?>">
                     </div>

                    <div class="form-group">
                        <label for="address" class="control-label mb-1">Address</label>
                         <textarea class="form-control" rows="2" name="address"><?php if (
                             isset($edit_data["address"])
                         ) {
                             echo $edit_data["address"];
                         } ?></textarea>
                     </div>
                    <div class="form-row">
                     <div class="col">
                        <label for="dob" class="control-label mb-1">Date Of Birth</label>
                        <input name="dob" type="date" class="form-control" value="<?php if (
                            isset($edit_data["dob"])
                        ) {
                            echo $edit_data["dob"];
                        } ?>">
                     </div>
                     <div class="col">
                        <label for="photo" class="control-label mb-1"> Photo</label>
                         <input name="photo" type="file" class="form-control">
                         <?php if(isset($edit_data["photo"])){
                            ?>
                         <input name="old_photo" type="hidden" value="<?php echo $edit_data['photo']?>">
                         <img src="student_upload/<?php echo $edit_data['photo']?>" width="50" height="50" class="img-thumbnail">
                         <?php }?>
                     </div>
                    </div>
                      <div class="form-row">
                          <div class="col">
                              <label for="city_id" class="control-label mb-1"> City</label>
                                <select name="city_id" class="form-control" required>
                                 <option value="">Select City</option>
                                 <?php
                                 $cities = $obj->fetch_data('cities','id','asc');
                                 if($cities){
                                    foreach ($cities as $list) {
                                        ?>
                          <option value="<?php echo $list['id']?>"  <?php 
                                 if(isset($edit_data["city_id"])){
                                   echo $edit_data["city_id"] == $list['id'] ? 'selected':'';
                                 }?>><?php echo $list['name']?></option>
                                         <?php }}?>
                                </select>
                        </div>
                         <div class="col">
                              <label for="qualification_ids" class="control-label mb-1"> Qualification</label>
                              <select name="qualification_ids[]" class="form-control select2" required multiple id="qualification_ids">
                                 <option value="">Select Qualification</option>
                            <?php 
                                 $qualification = $obj->fetch_data('qualification','id','asc');
                                 if($qualification){
                                    foreach ($qualification as $list) {
                                        ?>
                                           <option value="<?php echo $list['id']?>"


<?php 
 if(isset($edit_data["qualification_ids"])){
     $ids = explode(',', $edit_data["qualification_ids"]);
      echo in_array($list['id'],$ids) ? 'selected':'';
                                 }?>


                                            ><?php echo $list['name']?></option>
                                <?php }}?>
                              </select>
                        </div>
                        </div>
                      <div class="mt-2">
                        <?php if (isset($id)) { ?>
                             <input name="id" type="hidden" value="<?php if (
                                 isset($edit_data["id"])
                             ) {
                                 echo $edit_data["id"];
                             } ?>">
 <button id="update_btn" name="update_btn" type="submit" class="btn btn-lg btn-primary">
            Update 
            </button>
                            <?php } else { ?>
<button name="save_btn" type="submit" class="btn btn-lg btn-primary">
            Save 
            </button>
<?php } ?>
         </div>
                  </div>
               </div>
           </form>
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

   <script>
$(document).ready(function(){
  $("#qualification_ids").select2();
});
   </script>
