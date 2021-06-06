<?php include "header.php"; 
        if(isset($_POST['submit'])){
            $conn = mysqli_connect("localhost","root","","news-site") or die("connection not establish.");

            if(empty($_FILES['new-image']['name'])){
                $file_name = $_POST['old-image'];
            }
            else{
                $errors = array();

                $file_name = $_FILES['new-image']['name'];
                $file_size = $_FILES['new-image']['size'];
                $file_tmp = $_FILES['new-image']['tmp_name'];
                $file_type = $_FILES['new-image']['type'];
                $file_ext = end(explode('.',$file_name));
                $extensions = array("jpeg","jpg","png");

                if(in_array($file_ext,$extensions) === false){
                    $errors[] = "This extension file is not allowed please choose a JPG or PNG file.";
                }

                if($file_size > 2097152){
                    $errors[] = "File size must be 2mb or lower.";
                }

                if(empty($error) == true){
                    move_uploaded_file($file_tmp,"upload/".$file_name);
                }
                else{
                    print_r($errors);
                    die();
                }

            }
            $post_id = mysqli_real_escape_string($conn,$_POST['post_id']);
            $cat_id = mysqli_real_escape_string($conn,$_POST['cat_id']);
            $new_title = mysqli_real_escape_string($conn,$_POST['post_title']);
            $new_description = mysqli_real_escape_string($conn,$_POST['postdesc']);
            $new_category = mysqli_real_escape_string($conn,$_POST['category']);
        
            $sql3 = "UPDATE post
        SET title = '{$new_title}', description = '{$new_description}', category = {$new_category}, post_img = '{$file_name}'
                     WHERE post_id = {$post_id};";
            if($cat_id != $new_category){
                $sql3 .= "UPDATE category
                      SET post = post + 1
                      WHERE category_id = {$new_category};";
            
                $sql3 .= "UPDATE category
                          SET post = post -1 
                          WHERE category_id = {$cat_id};";
            }
             $result3 = mysqli_multi_query($conn,$sql3) or die("query is wrong.");
             header("Location: http://localhost/news-site/admin/post.php");
              mysqli_close($conn);

        }
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <?php
            $post_id = $_GET['id'];
            // $cat_id = $_GET['cid'];
            $conn = mysqli_connect("localhost","root","","news-site");

            $sql = "SELECT *
                    FROM post
                    WHERE post_id = {$post_id}";
            $result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['post_id'];?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
    <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title'];?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5">
                    <?php echo $row['description'];?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                    <?php
                        $conn = mysqli_connect("localhost","root","","news-site");

                        $sql1 = "SELECT *
                                 FROM category";
                        $result1 = mysqli_query($conn,$sql1);


                        if(mysqli_num_rows($result1) > 0){
                            while($row1 = mysqli_fetch_assoc($result1)){
                                if($row['category'] == $row1['category_id']){
                                    $selected = "selected";
                                }
                                else{
                                    $selected = "";
                                }
          echo "<option {$selected} value='{$row1['category_id']}'>{$row1['category_name']}</option>";
                         }
                      }
                    ?>
                </select>
                <input type="hidden" name="cat_id" value="<?php echo $row['category'];?>" placeholder="">

            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="upload/<?php echo $row['post_img']?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $row['post_img']?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
        <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>