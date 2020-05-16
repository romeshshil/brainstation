<?php 

// include database and object files
include_once 'classes/DB.php';
include_once 'classes/Category.php';

// db conneciton 
$database = new Database();
$db = $database->getConnection();

echo "ddd";

// instantiate database and category object
$categoryobj = new Category($db);
$categoryList=$categoryobj->getAllCategory();
// $category->getCountofCategoryItem(1);
// print_r($test);
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
            
        <?php  foreach($categoryList as $key=>$category): ?>
            <li><span class="caret"><?php echo $category["Name"]; ?> &nbsp;&nbsp; &nbsp;(<?php echo $categoryobj->getCountofCategoryItem($category['categoryId']);  ?>)</span>
                        <ul class="child-child">
                        <?php  foreach($categoryobj->childcategories($category['categoryId']) as $key=>$child): ?>
                                 <li><?php echo $child["Name"]; ?> &nbsp;&nbsp; &nbsp;(<?php echo $categoryobj->getCountofCategoryItem($child['categoryId']); ?>)</li>
                        <?php endforeach;?>
                        </ul>
               
                </li>
                        
            <?php endforeach;?>
        </ul>


    </body>
</html>
