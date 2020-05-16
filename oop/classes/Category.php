<?php

class Category
{
    // table name definition and database connection
    private $db_conn;
    private $table_name = "item_category_relations";

    // object properties
    public $id;
    public $name;

    public function __construct($db)
    {
        $this->db_conn = $db;
    }


    public function getAllCategory(){

        $query="SELECT item_category_relations.categoryId,count(item_category_relations.ItemNumber) as ItemNumber,category.Name FROM item_category_relations JOIN category ON category.id = item_category_relations.categoryId GROUP BY item_category_relations.categoryId ORDER by ItemNumber DESC";
        $prep_state = $this->db_conn->prepare($query);
        $prep_state->execute();

        $row = $prep_state->fetchAll();
        return $row;
        
        }
        

    public  function getCountofCategoryItem($categoryId) {
            $query = "SELECT * FROM item_category_relations  WHERE categoryId = '" . $categoryId . "'";
            $prep_state = $this->db_conn->prepare($query);
            $prep_state->bindParam(':id', $categoryId);
            $prep_state->execute();
            

             $row = $prep_state->fetchColumn();
            //  $row = $prep_state->fetch(PDO::FETCH_ASSOC);
            return $row;

        }


   public function itemCategoryList(){
    $query="SELECT item_category_relations.categoryId,count(item_category_relations.ItemNumber) as ItemNumber,category.Name "
    . "FROM category "
    . "JOIN catetory_relations ON category.id = catetory_relations.categoryId "
    . "JOIN item_category_relations ON catetory_relations.categoryId = item_category_relations.categoryId "
    . "GROUP BY item_category_relations.categoryId ORDER by ItemNumber DESC";
    $prep_state = $this->db_conn->prepare($query);
    $prep_state->execute();

    $row = $prep_state->fetchAll();
    return $row;
    

   }     

   public function childcategories($id){
    $query="SELECT catetory_relations.categoryId,catetory_relations.ParentcategoryId,category.Name "
    . "FROM catetory_relations "
    . "JOIN category ON category.id = catetory_relations.categoryId "
    . " WHERE catetory_relations.ParentcategoryId = '" . $id . "' ORDER by categoryId DESC";
    $prep_state = $this->db_conn->prepare($query);
    $prep_state->bindParam(':id', $id);
    $prep_state->execute();

    $row = $prep_state->fetchAll();
    return $row;
   }

}
