<?php include "header.php"; ?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                <?php
                    $conn = mysqli_connect("localhost","root","","news-site");
                    $limit = 3;
                  
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }
                    else{
                      $page = 1;
                    }
                    $offset = ($page - 1) * $limit;
                    // $sql = "SELECT * FROM post ORDER BY post_id ASC LIMIT {$offset} , {$limit}";

                    if($_SESSION["user_role"] == '1'){
                            $sql = "SELECT *
                                     FROM post ORDER BY post_id ASC LIMIT {$offset} , {$limit}";
                    }
                    if($_SESSION["user_role"] == '0'){
                            $sql = "SELECT *
                                    FROM post
                                    WHERE author = {$_SESSION['user_id']}
                                    ORDER BY post_id ASC LIMIT {$offset} , {$limit}";
                    }

                    $result = mysqli_query($conn,$sql) or die("query is faild..");

                    if(mysqli_num_rows($result) > 0){
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                          <?php 
                            while($row = mysqli_fetch_assoc($result)){                            
                          ?>
                          <tr>
                              <td class='id'><?php echo $row['post_id']?></td>
                              <td><?php echo $row['title']?></td>
                              <td><?php echo $row['category']?></td>
                              <td><?php echo $row['post_date']?></td>
                              <td><?php echo $row['author']?></td>
               <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id']?>&cid=<?php echo $row['category']?>'><i class='fa fa-edit'></i></a></td>
             <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id']?>&cid=<?php echo $row['category']?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php 
                             }
                          ?>
                      </tbody>
                  </table>
                  <?php 
                } 
                  if($_SESSION["user_role"] == '1'){
                            $sql1 = "SELECT *
                                     FROM post";
                    }
                    if($_SESSION["user_role"] == '0'){
                            $sql1 = "SELECT *
                                    FROM post
                                    WHERE author = {$_SESSION['user_id']}";
                    }

                  $result1 = mysqli_query($conn,$sql1) or die("query is wrong");

                  if(mysqli_num_rows($result1) > 0){
                    $total_records = mysqli_num_rows($result1);
                    $limit = 3;
                    $total_pages = ceil($total_records / $limit);

                    echo "<ul class='pagination admin-pagination'>";
                      if($page > 1){
                          echo "<li><a href = 'post.php?page=".($page - 1)."'>Prev</a></li>";
                      }
                      for($i = 1; $i <= $total_pages; $i++){
                        if($i == $page){
                          $active = "active";
                        }
                        else{
                          $active = "";
                        }
                          echo '<li><a class = "'.$active.'" href="post.php?page='. $i .'">'. $i .'</a></li>';
                      }
                      if($page < $total_pages){
                          echo "<li><a href = 'post.php?page=".($page + 1)."'>Next</a></li>";
                      }
                    echo "</ul>";
                  }
                ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
