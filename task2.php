<?php
$mysqli = mysqli_connect("localhost", "root", "", "brain");
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

function getCountofCategoryItem($categoryId) {
    $mysqli = mysqli_connect("localhost", "root", "", "brain");
    $query = "SELECT * FROM item_category_relations  WHERE categoryId = '" . $categoryId . "'";
    if ($result = $mysqli->query($query)) {
        return $row = mysqli_num_rows($result);
    }
}
?>
<html>
    <head>
        <style>
            ul, #menu {
                list-style-type: none;
            }
            li {
                font-size:20px;
            }

            #menu {
                margin: 0;
                padding: 0;
                margin-left: 20%;
            }

            .caret {
                cursor: pointer;
                -webkit-user-select: none; 
                -moz-user-select: none; 
                -ms-user-select: none; 
                user-select: none;
            }

            .caret::before {
                content: "\25B6";
                color: black;
                display: inline-block;
                margin-right: 6px;
            }

            .caret-down::before {
                -ms-transform: rotate(90deg); 
                -webkit-transform: rotate(90deg); 
                transform: rotate(90deg);  
            }

        </style>
    </head>
    <body>

         <a href="task1.php">Task 1</a>
        <a href="task2.php">Task 2</a>

        <ul id="menu">
            <?php
            $sql = "SELECT item_category_relations.categoryId,count(item_category_relations.ItemNumber) as ItemNumber,category.Name "
                    . "FROM category "
                    . "JOIN catetory_relations ON category.id = catetory_relations.categoryId "
                    . "JOIN item_category_relations ON catetory_relations.categoryId = item_category_relations.categoryId "
                    . "GROUP BY item_category_relations.categoryId ORDER by ItemNumber DESC";
            if ($result = $mysqli->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    ?>  
                    <li><span class="caret"><?php echo $row["Name"]; ?> &nbsp;&nbsp; &nbsp;(<?php echo getCountofCategoryItem($row['categoryId']);  ?>)</span>
                        <ul class="child-child">
                            <?php
                            $sqlnested = "SELECT catetory_relations.categoryId,catetory_relations.ParentcategoryId,category.Name "
                                    . "FROM catetory_relations "
                                    . "JOIN category ON category.id = catetory_relations.categoryId "
                                    . " WHERE catetory_relations.ParentcategoryId = '" . $row['categoryId'] . "' ORDER by categoryId DESC";

                            if ($result2 = $mysqli->query($sqlnested)) {
                                while ($row2 = $result2->fetch_assoc()) {
                                    ?>  
                                    <li><?php echo $row2["Name"]; ?> &nbsp;&nbsp; &nbsp;(<?php echo getCountofCategoryItem($row2['categoryId']); ?>)</li>

                                    <?php
                                }
                            }
                            ?>

                        </ul>
                    </li>
                    <?php
                }
                $result->free();
            }
            ?>

        </ul>


    </body>
</html>