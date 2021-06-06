<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                        $conn = mysqli_connect("localhost","root","","news-site");
                        $cat_id = $_GET['cid'];
                        $sql2 = "SELECT *
                                 FROM category
                                 WHERE category_id = {$cat_id}";
                        $result1 = mysqli_query($conn,$sql2);
                        if(mysqli_num_rows($result1) > 0){
                            while($row2 = mysqli_fetch_assoc($result1)){
                    ?>
                     <h2 class="page-heading"><?php echo $row2['category_name']?></h2>
                    <?php 
                            }   

                        }
                    ?>

                        <?php
                            $conn = mysqli_connect("localhost","root","","news-site");

                            if(isset($_GET['cid'])){
                                 $cat_id = $_GET['cid'];   
                            }



                            if(isset($_GET['page'])){
                                $page = $_GET['page'];    
                            }
                            else{
                                $page = 1;
                            }
                            $limit = 2;
                            $offset = ($page - 1) * $limit;

                            $sql = "SELECT *
                                    FROM post p
                                    LEFT JOIN category c ON p.category = c.category_id
                                    LEFT JOIN user u ON p.author = u.user_id
                                    WHERE category = {$cat_id}
                                    ORDER BY p.post_id DESC LIMIT {$offset} , {$limit}";
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
                                        <h3><a href='single.php?post=<?php echo $row['post_id']?>'><?php echo $row['title']?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cid=<?php echo $row['category_id']?>'><?php echo $row['category_name']?></a>
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
                                           <?php echo substr($row['description'],0,150) . "...";?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?post=<?php echo $row['post_id']?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }
                            $sql1 = "SELECT *
                                     FROM post
                                     WHERE category = {$cat_id}";
                            $result1 = mysqli_query($conn,$sql1);

                            if(mysqli_num_rows($result1) > 0){

                                $total_records = mysqli_num_rows($result1);
                                $limit = 2;
                                $total_pages = ceil($total_records / $limit);

                                echo "<ul class='pagination'>";

                                if($page > 1){
                                    echo '<li><a href = "category.php?cid='.$cat_id.'&page='. ($page - 1) .'">Prev</a></li>';
                                }
                                for($i = 1; $i <= $total_pages; $i++){
                                    echo '<li><a href="category.php?cid='.$cat_id.'&page='. $i .'">'. $i .'</a></li>';
                                }
                                if($page < $total_pages){
                                    echo '<li><a href = "category.php?cid='.$cat_id.'&page= '. ($page + 1) .'">Next</a></li>';
                                }
                                echo "</ul>";
                            }
                        ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
