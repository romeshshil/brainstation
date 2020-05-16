<?php
$mysqli = mysqli_connect("localhost", "root", "", "brain");
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

//will return total items of a category
function getItemsOfCategory($categoryId)
{
  $conn = mysqli_connect("localhost", "root", "", "brain");
  $itemCount = 0;

  $sql = "SELECT COUNT(Item_category_relations.ItemNumber) AS item_count
          FROM Item_category_relations WHERE categoryId=$categoryId";
  
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      $itemcounted = $result->fetch_assoc();
  }
  $itemCount += $itemcounted['item_count'];

  //check if the category has any child and get item counts for them
  $sql = "SELECT categoryId FROM catetory_relations WHERE ParentcategoryId=$categoryId";
  
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      $childCategories = $result->fetch_all(MYSQLI_ASSOC);

      foreach ($childCategories as $childCategory) {
        $childCategoryItemsCount = getItemsOfCategory($childCategory['categoryId']);
        $itemCount += $childCategoryItemsCount;
      }
  }
  return $itemCount;
}


//get the top parent categories
$sql = "SELECT category.Id, category.Name FROM category 
        WHERE id NOT IN (SELECT catetory_relations.categoryId FROM catetory_relations) AND category.Disabled=0";

if ($result = $mysqli->query($sql)) {
     $parent_categories = $result->fetch_all(MYSQLI_ASSOC);
}

$categories = array();
foreach ($parent_categories as $parent_category) {
  //get childs of the category
  $data['categoryName'] = $parent_category['Name'];
  $data['item_count'] = getItemsOfCategory($parent_category['Id']);

  array_push($categories, $data);
}

usort($categories, function ($item1, $item2) {
    return $item2['item_count'] <=> $item1['item_count'];
});


?>
<html>
    <head>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 60%;
                margin-left: 20%;
            }
            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #dddddd;
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

            <?php  foreach($categories as $key=>$category): ?>
                    <tr>
                        <td><?=$category['categoryName'];?></td>
                        <td><?=$category['item_count'];?></td>
                    </tr>
            <?php endforeach;?>

        </table>
    </body>
</html>


