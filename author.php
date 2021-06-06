<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                        $conn = mysqli_connect("localhost","root","","news-site");
                        $a_id = $_GET['aid'];
                        $sql2 = "SELECT *
                                 FROM user
                                 WHERE user_id = {$a_id}";
                        $result2 = mysqli_query($conn,$sql2);
                        if(mysqli_num_rows($result2) > 0){
                            while($row2 = mysqli_fetch_assoc($result2)){

                            
                    ?>
                  <h2 class="page-heading"><?php echo $row2['username']?></h2>
                  <?php
                        }
                    }
                  ?>
                    <?php 

                        $conn = mysqli_connect("localhost","root","","news-site");
                        $a_id = $_GET['aid'];

                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                        }
                        else{
                            $page = 1;
                        }
                        
                        $limit = 2;
                        $offset = ($limit - 1) * $page;

                        $sql = "SELECT *
                                FROM post P
                                LEFT JOIN category c ON p.category = c.category_id
                                LEFT JOIN user u ON p.author = u.user_id
                                WHERE author = {$a_id}
                                ORDER BY post_date DESC LIMIT {$offset}, {$limit}";

                        $result = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?post=<?php echo $row['post_id']?>"><img src="admin/upload/<?php echo $row['post_img']?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href="single.php?post=<?php echo $row['post_id']?>"><?php echo $row['title']?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href="category.php?cid=<?php echo $row['category_id']?>"><?php echo $row['category_name']?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href="author.php?aid=<?php echo $row['author']?>"><?php echo $row['username']?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']?>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo substr($row['description'],0,130) . "..."?>
                                    </p>
                                    <a class='read-more pull-right' href="single.php?post=<?php echo $row['post_id']?>">read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                         }
                      }
                        $sql1 = "SELECT *
                                 FROM post
                                 WHERE author = {$a_id}";
                        $result1 = mysqli_query($conn,$sql1);
                        if(mysqli_num_rows($result1) > 0){

                            $total_records = mysqli_num_rows($result1);
                            $limit = 2;
                            $total_pages = ceil($total_records / $limit);

                            echo "<ul class='pagination'>";
                            if($page > 1){
                                echo '<li><a href="author.php?aid='. $a_id .'&page='. ($page - 1) .'">Prev</li>';
                            }
                            for($i = 1; $i <= $total_pages; $i++){

                                echo '<li><a href="author.php?aid='. $a_id .'&page='. $i .'">'. $i .'</a></li>';
                            }
                            if($page < $total_pages){
                                echo '<li><a href="author.php?aid='. $a_id .'&page='. ($page + 1) .'">Next</li>';
                            }
                            echo "</ul>";
                        }
                    ?>
                    
                        <!-- <li class="active"><a href="">1</a></li> -->
                    
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
