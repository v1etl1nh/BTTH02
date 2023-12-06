<?php
include_once './config/Database.php';
class Articles {
    private $id;
    private $postTable;
    private $categoryTable;
    private $userTable;
    private $conn = $conn -> getConnection();

public function getArticles()
{

  $query = '';
  if ($this->id) {
    $query = " AND p.id ='" . $this->id . "'";
  }
  $sqlQuery = "
  SELECT p.id, p.title, p.message, p.category_id, u.first_name, 
u.last_name, p.status, p.created, p.updated, c.name as category
  FROM " . $this->postTable . " p
  LEFT JOIN " . $this->categoryTable . " c ON c.id = p.category_id
  LEFT JOIN " . $this->userTable . " u ON u.id = p.userid
  WHERE p.status ='published' $query ORDER BY p.id DESC";

  $stmt = $this->conn->prepare($sqlQuery);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result;
}

public function formatMessage(){}

}