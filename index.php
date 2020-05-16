<?php
$mysqli = mysqli_connect("localhost", "root", "", "brain");
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
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
            <?php
            $query = "SELECT item_category_relations.categoryId,count(item_category_relations.ItemNumber) as ItemNumber,category.Name FROM item_category_relations JOIN category ON category.id = item_category_relations.categoryId GROUP BY item_category_relations.categoryId ORDER by ItemNumber DESC";
            if ($result = $mysqli->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["Name"];  ?></td>
                        <td><?php echo $row["ItemNumber"]; ?></td>
                    </tr>
                    <?php
                }
                $result->free();
            }
            ?>

        </table>

    </body>
</html>


