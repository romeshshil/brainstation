<?php 

// include database and object files
include_once 'classes/DB.php';
include_once 'classes/Category.php';

// db conneciton 
$database = new Database();
$db = $database->getConnection();

echo "ddd";

// instantiate database and category object
$category = new Category($db);
$categoryList=$category->getAllCategory();
// $category->getCountofCategoryItem(1);
// print_r($test);
?>
<html>
    <head>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 50%;
                margin-left: 30%;
            }
            td, th {
                border: 1px solid #efefefef;
                text-align: left;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #efefefef;
            }
        </style>
    </head>
    <body>
        <a href="task1.php">Task 1</a>
        <a href="task2.php">Task 2</a>
        <table>
            <tr>
                <th>Category Name</th>
                <th>Total Items</th>
            </tr>
            <?php  foreach($categoryList as $key=>$category): ?>
                    <tr>
                        <td><?=$category['Name'];?></td>
                        <td><?=$category['ItemNumber'];?></td>
                    </tr>
            <?php endforeach;?>
        </table>

        // for test 


    </body>
</html>
