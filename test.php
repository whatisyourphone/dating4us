<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//test

class DB {

protected $db_name = 'yourdatabasename';
protected $db_user = 'databaseusername';
protected $db_pass = 'databasepassword';
protected $db_host = 'localhost';

public function connect() {
$connection = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
mysql_select_db($this->db_name);
return true;
}




class ShopProduct {

public $title = "Standart tovar";
public $productMainName = "product name";
function getproducer(){
 return "{$this->title}";
}
}

$product1= new ShopProduct();

print $product1->title;
print $product1->getproducer();

?>
