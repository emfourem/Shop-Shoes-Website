<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * This file contains all the functions used by ajax requests and that access the database directly.
 * All ajax requests use the post method.
 * Each ajax request sets a parameter in _POST called action that invokes the correct function to use.
 * A series of cascading ifs perform the checks on this field and when a match is found, the associated function is called.
 */
if (!isset($_SESSION)) { session_start(); }

if(isset($_POST,$_POST['action'])){
    if ($_POST['action'] == "load") { load(); }
    if ($_POST['action'] == "checkInWishlist") { checkInWishlist(); }
    if ($_POST['action'] == "checkWishlist") { addToWishlist(); }
    if ($_POST['action'] == "checkInCart") { checkInCart(); }
    if ($_POST['action'] == "addToCart") { addToCart(); }
    if ($_POST['action'] == "loadCart") { loadCart(); }
    if ($_POST['action'] == "completeOrder") { completeOrder(); }
    if ($_POST['action'] == "removeAllCartElement") { removeAllCartElement(); }
    if ($_POST['action'] == "loadWishlist") { loadWishlist(); }
    if ($_POST['action'] == "loadOrder") { loadOrder(); }
    if ($_POST['action'] == "retrieveItems") { retrieveItems(); }
    if ($_POST['action'] == "allOrder") { allOrder(); }
    if ($_POST['action'] == "retrieveAllItems") { retrieveAllItems(); }
    if ($_POST['action'] == "findProduct") { findProduct(); }
    if ($_POST['action'] == "checkCart") { checkCart(); }
    if ($_POST['action'] == "findComments") { findComments(); }
    if ($_POST['action'] == "addComment") { addComment(); }
    if ($_POST['action'] == "findLastComment") { findLastComment(); }
    if ($_POST['action'] == "removeComment") { removeComment(); }
    if ($_POST['action'] == "toRemove") { toRemove(); }
    if ($_POST['action'] == "removeProduct") { removeProduct(); }
    if ($_POST['action'] == "insertProduct") {insertProduct(); }
    if ($_POST['action'] == "loginInitial") { loginInitial(); }
    if ($_POST['action'] == "registrationInitial") { registrationInitial(); }
}

/*
 * Function that establishes the connection to the database and returns the PDO associated with that connection
 */
function dbConnect(): PDO
{
    $string = "mysql:dbname=shop_shoes;host=localhost";
    $user = "root";
    $password = "";
    $db = new PDO($string, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

/*
 * Function that returns the list with all product information in the products table
 * Param: none
 * Return : json
 */
function load(){
    if(isset($_SESSION["username"])){
        try {
            $db = dbConnect();
            $json= array();
            $query=$db->query("SELECT * FROM products");
            if($query != null && $query->rowCount() >0) {
                while ($row = $query->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that returns the list with all product names in the user’s wishlist. User username is in _SESSION["username"]"]
 * Param: none
 * Return : json
 */
function checkInWishlist(){
    if(isset($_SESSION["username"])){
        try {
            $db = dbConnect();
            $username = $db->quote($_SESSION['username']);
            $json=array();
            $rows=$db->query("SELECT p.product_name FROM products p JOIN wishlist w ON p.id=w.id   WHERE username=$username");
            if ($rows != null && $rows->rowCount() > 0) {
                while($row=$rows->fetch()){
                    $json[]=$row[0];
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that inserts a product specified in product_name in the wishlist of the user in _SESSION["username"]
 * if it is not already present while removing it from the same if there is already.
 * Param: product_name
 * Return : "inserted" in case of success, "removed" otherwise
 */
function addToWishlist(){
    if(isset($_SESSION["username"],$_POST["product_name"])){
        try {
            $db = dbConnect();
            $username = $db->quote($_SESSION['username']);
            $product_name = $db->quote($_POST['product_name']);
            $rows=$db->query("SELECT id FROM products  WHERE product_name=$product_name");
            $id=-1;
            if ($rows != null && $rows->rowCount() === 1) {
                $row = $rows->fetch();
                $id = $row[0];
                /*id founded*/
                $result = $db->query("SELECT id FROM wishlist WHERE id=$id AND username=$username;");
                if ($result != null && $result->rowCount() === 1) {
                    /*already in wishlist*/
                    $db->query("DELETE FROM wishlist WHERE id=$id AND username=$username;");
                    echo "removed";
                } else {
                    /*inserted in wishlist*/
                    $my_date = date('Y-m-d H:i:s');
                    $db->query("INSERT INTO wishlist (id, username, insert_date) VALUES ($id, $username, STR_TO_DATE('$my_date', '%Y-%m-%d %H:%i:%s'))");
                    echo "inserted";
                }
            }
            return 1;
        }catch(PDOException ){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that returns the list with all product names in the user’s cart. User username is in _SESSION["username"]
 * Param: none
 * Return : json
 */
function checkInCart(){
    if(isset($_SESSION["username"])){
        try {
            $db = dbConnect();
            $username = $db->quote($_SESSION['username']);
            $json=array();
            $rows=$db->query("SELECT p.product_name FROM products p JOIN cart c ON p.id=c.id   WHERE username=$username");
            if ($rows != null && $rows->rowCount() > 0) {
                while($row=$rows->fetch()){
                    $json[]=$row[0];
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that inserts a product specified in product_name in the cart of the user in _SESSION["username"]
 * if it is not already present while removing it from the same if there is already.
 * Param: product_name
 * Return : "inserted" in case of success, "removed" otherwise
 */
function addToCart(){
    if (isset($_SESSION['username'],$_POST['product_name'])) {
        try {
            $db = dbConnect();
            $username = $db->quote($_SESSION['username']);
            $name = $db->quote($_POST['product_name']);
            $my_date=date('Y-m-d H:i:s');
            $find=$db->query("SELECT id FROM products WHERE product_name=$name");
            if($find != null && $find->rowCount() > 0) {
                $row = $find->fetch();
                $id = $row[0];
                /*id founded*/
                $result = $db->query("SELECT id FROM cart WHERE id=$id AND username=$username");
                if ($result != null && $result->rowCount() === 1) {
                    /*already in cart*/
                    $db->query("DELETE FROM cart WHERE id=$id AND username=$username;");
                    echo "removed";
                } else {
                    /*insert in cart*/
                    $db->query("INSERT INTO cart (id, username, insert_date) VALUES ($id, $username, STR_TO_DATE('$my_date', '%Y-%m-%d %H:%i:%s'))");
                    echo "insert";
                }
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that returns all product information in the user’s cart. User username is in _SESSION["username"]
 * Param: none
 * Return : json
 */
function loadCart(){
    if (isset($_SESSION['username'])) {
        try {
            $db = dbConnect();
            $json=array();
            $username = $db->quote($_SESSION['username']);
            $query = $db->query("SELECT p.* FROM (cart c JOIN users u ON c.username=u.username)JOIN products p on p.id=c.id WHERE c.username=$username ORDER BY insert_date desc");
            if($query != null) {
                while ($row = $query->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that inserts the user order with that total_price in the bought table
 * Param: total_price
 * Return : "complete" in case of success, "notComplete" otherwise
 */
function completeOrder(){
    if (isset($_SESSION['username'],$_POST['total_price'])) {
        try {
            $db = dbConnect();
            $username = $db->quote($_SESSION['username']);
            $total=$db->quote($_POST['total_price']);
            $my_date=date('Y-m-d H:i:s');
            $query=$db->query("SELECT p.id,p.product_name,p.price FROM products p JOIN cart c on p.id=c.id WHERE username=$username;");
            if($query!=null && $query->rowCount() > 0) {
                while($row=$query->fetch()){
                    $id=$db->quote($row[0]);
                    $product_name=$db->quote($row[1]);
                    $price=$db->quote($row[2]);
                    $sql = $db->prepare("INSERT INTO bought (id, username,product_name,price,total_price, date_of) VALUES ($id, $username,$product_name,$price,$total, STR_TO_DATE('$my_date', '%Y-%m-%d %H:%i:%s'))");
                    $sql->execute();
                }
                echo "complete";
            }else{
                echo "notComplete";
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that deletes all items in the user’s cart. User username is in _SESSION["username"]
 * Param: none
 * Return : "empty" in case of success, "full" otherwise
 */
function removeAllCartElement(){
    if (isset($_SESSION['username'])) {
        try {
            $db = dbConnect();
            $username = $db->quote($_SESSION['username']);
            $query=$db->prepare("DELETE FROM cart WHERE username=$username;");
            if($query->execute()){
                echo "empty";
            }else{
                echo "full";
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that returns all product information in the user’s wishlist. User username is in _SESSION["username"]
 * Param: none
 * Return : json
 */
function loadWishlist(){
    if (isset($_SESSION['username'])) {
        try {
            $db = dbConnect();
            $json=array();
            $username = $db->quote($_SESSION['username']);
            $query = $db->query("SELECT p.* FROM (wishlist w JOIN users u ON w.username=u.username)JOIN products p on p.id=w.id WHERE w.username=$username  ORDER BY insert_date desc");
            if($query != null) {
                while ($row = $query->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that returns data and total price of each order for the user. User username is in _SESSION["username"]
 * Param: none
 * Return : json
 */
function loadOrder(){
    if (isset($_SESSION['username'])) {
        try {
            $db = dbConnect();
            $json=array();
            $username = $db->quote($_SESSION['username']);
            $query = $db->query("SELECT DISTINCT b.date_of,b.total_price FROM bought b WHERE b.username=$username ORDER BY b.date_of desc");
            if($query != null) {
                while ($row = $query->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that returns the name and price of all items in the user order on that date. User username is in _SESSION["username"]
 * Param: date
 * Return : json
 */
function retrieveItems(){
    if (isset($_SESSION['username'],$_POST["date"])) {
        try {
            $db = dbConnect();
            $json=array();
            $username = $db->quote($_SESSION['username']);
            $date = $db->quote($_POST["date"]);
            $query = $db->query("SELECT  b.product_name,b.price FROM bought b WHERE b.username=$username AND b.date_of=$date");
            if($query != null) {
                while ($row = $query->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function executable by only root users that returns, for each order in the bought table , username, total_price and date of the same
 * Param: none
 * Return : json
 */
function allOrder(){
    if (isset($_SESSION['username'],$_SESSION["typeof"]) &&  strcmp($_SESSION['typeof'],"root")==0) {
        try {
            $db = dbConnect();
            $json=array();
            $query = $db->query("SELECT DISTINCT b.username,b.date_of,b.total_price FROM bought b ORDER BY b.date_of desc");
            if($query != null) {
                while ($row = $query->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function executable by only root users that returns, for each order referenced by date and username,
 * product_name and price of all the articles that compose it
 * Param: date, user
 * Return : json
 */
function retrieveAllItems(){
    if (isset($_SESSION['username'],$_POST["date"],$_POST["user"],$_SESSION["typeof"]) &&  strcmp($_SESSION['typeof'],"root")==0) {
        try {
            $db = dbConnect();
            $json=array();
            $username = $db->quote($_POST["user"]);
            $date = $db->quote($_POST["date"]);
            $query = $db->query("SELECT  b.product_name,b.price FROM bought b WHERE b.username=$username AND b.date_of=$date");
            if($query != null) {
                while ($row = $query->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that returns all product information referenced by product_name.
 * Param: product_name
 * Return : json
 */
function findProduct(){
    if (isset($_SESSION['username'],$_POST['product_name'])) {
        try {
            $db = dbConnect();
            $name = $db->quote($_POST['product_name']);
            $json=array();
            $find=$db->query("SELECT * FROM products WHERE product_name=$name");
            if($find != null && $find->rowCount()!==0){
                $row=$find->fetch();
                $json[]=$row;
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that checks that the product referenced by the id is present in the user’s cart. User username is in _SESSION["username"]
 * Param: id
 * Return : "already present" if it is already present, "not present" otherwise
 */
function checkCart(){
    if (isset($_SESSION['username'],$_POST['id'])) {
        try {
            $db = dbConnect();
            $username = $db->quote($_SESSION['username']);
            $id=$db->quote($_POST['id']);
            $rows=$db->query("SELECT c.* FROM cart c  WHERE username=$username AND id=$id");
            if ($rows != null && $rows->rowCount() > 0) {
                echo "already present";
            }else{
                echo "not present";
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that returns author’s email and all the information of all comments related to the product referenced by id.
 * Param: id
 * Return : json
 */
function findComments(){
    if (isset($_SESSION['username'],$_POST['id'])) {
        try {
            $db = dbConnect();
            $id = $db->quote($_POST['id']);
            $json=array();
            $find=$db->query("SELECT u.email, r.* FROM users u, reviews r WHERE r.id=$id AND r.username=u.username ORDER BY r.insert_date asc");
            if($find != null) {
                while ($row = $find->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * A function that takes a text and a product as input and inserts a comment in the reviews table
 * with that text for that product written by the user. User username is in _SESSION["username"]
 * Param: text, product_name
 * Return : "inserted" in case of success, "not inserted" otherwise
 */
function addComment(){
    if (isset($_SESSION['username'],$_POST['text'],$_POST["product_name"])) {
        try {
            $db = dbConnect();
            $username = $db->quote($_SESSION['username']);
            $text1=htmlspecialchars($_POST['text']);
            $text = $db->quote($text1);
            $product_name = $db->quote($_POST['product_name']);
            $my_date=date('Y-m-d H:i:s');
            $find=$db->query("SELECT id FROM products WHERE product_name=$product_name");
            if($find!=null && $find->rowCount()>0) {
                $row = $find->fetch();
                $id = $row[0];
                /*id founded*/
                $insert = $db->query("INSERT INTO reviews (id,username,insert_date,text) VALUES ($id,$username, STR_TO_DATE('$my_date', '%Y-%m-%d %H:%i:%s'),$text);");
                if($insert){
                    echo $my_date;
                }else{
                    echo "not inserted";
                }
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that takes in input id and date and returns the comment for the product referenced by id with that date
 * Param: id, date
 * Return : json
 */
function findLastComment(){
    if (isset($_SESSION['username'],$_POST['id'],$_POST['date'])) {
        try {
            $db = dbConnect();
            $id = $db->quote($_POST['id']);
            $date = $db->quote($_POST['date']);
            $json=array();
            $find=$db->query("SELECT u.email, r.* FROM users u JOIN reviews r on u.username=r.username WHERE r.id=$id AND r.insert_date=$date");
            if($find != null) {
                while ($row = $find->fetch()) {
                    $json[] = $row;
                }
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function executable only by root users that takes in input id, date and username
 * and removes the referenced comment from the triple just described by the table reviews
 * Param: id, date, name
 * Return : "removed" in case of success, "not removed" otherwise
 */
function removeComment(){
    if (isset($_SESSION['username'],$_POST['id'],$_POST['data'],$_SESSION['typeof'],$_POST["name"]) &&  strcmp($_SESSION['typeof'],"root")==0) {
        try {
            $db = dbConnect();
            $id = $db->quote($_POST['id']);
            $user = $db->quote($_POST['name']);
            $my_date=$db->quote($_POST['data']);
            $find=$db->query("DELETE FROM reviews WHERE id=$id AND insert_date=$my_date AND username=$user");
            if($find){
                echo ("removed");
            }else{
                echo ("not removed");
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function executable only by root users returning id and product_name of all products in the products table
 * Param: id, date, name
 * Return : json
 */
function toRemove(){
    if (isset($_SESSION['username'])) {
        try {
            $db = dbConnect();
            $json=array();
            $rows=$db->query("SELECT id,product_name FROM products ");
            if($rows != null) {
                $json[] = $rows->fetchAll();
            }
            header("Content-type: application/json");
            echo json_encode($json);
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function executable only by root users that takes the id of a product and removes it from the product table
 * Param: rm
 * Return : "removed" in case of success, "not removed" otherwise
 */
function removeProduct(){
    if (isset($_SESSION['username'],$_POST["rm"],$_SESSION['typeof']) &&  strcmp($_SESSION['typeof'],"root")==0) {
        try {
            $db = dbConnect();
            $remove = $db->quote($_POST['rm']);
            $id=filter_var($remove, FILTER_SANITIZE_NUMBER_INT);
            $check=$db->prepare("DELETE FROM products WHERE id=$id;");
            if($check->execute()){
                echo "removed";
            }else{
                echo "not removed";
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function executable only by root users that takes in input all the information that define a product and inserts it in the product table
 * Param: photo, field, height, material, price
 * Return : "inserted" in case of success, "not inserted" in case of failure and "already" if a product with that name already exists
 */
function insertProduct(){
    if (isset($_SESSION['username'],$_SESSION['typeof'],$_POST["field"],$_POST["height"], $_POST["material"],$_POST["price"],$_POST["photo"]) &&  strcmp($_SESSION['typeof'],"root")==0) {
        try {
            if ((!filter_input(INPUT_POST, "field", FILTER_SANITIZE_STRING))
                && (!filter_input(INPUT_POST, "height", FILTER_SANITIZE_NUMBER_FLOAT))
                && (!filter_input(INPUT_POST, "material", FILTER_SANITIZE_STRING))
                && (!filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT))
                && !((strlen($_POST["field"]) <= 32 && strlen($_POST["material"]) <= 32 && strlen($_POST["photo"]) <=37))){
                $_SESSION["error"]="Date inserted are not secure!";
                header("Location: ../php/login.php");
            }
            $db = dbConnect();
            $img = $db->quote($_POST["photo"]);
            $field = $_POST['field'];
            $height = $_POST['height'];
            $material = $_POST['material'];
            $price = $_POST['price'];
            $img=str_replace("'", "", $img);
            $poss=array(".jpg",".jpeg",".png");
            $product_name=str_replace($poss, "", $img);
            $product=$db->quote($product_name);
            $img1="../new_image/".$img;
            $rows=$db->query("SELECT MAX(id) FROM products ");
            if ($rows != null && $rows->rowCount() === 1) {
                $row = $rows->fetch();
                $index=$row[0]+1;
            }
            $check=$db->query("SELECT id FROM products WHERE product_name=$product");
            if($check != null && $check->rowCount() >0){
                echo "already";
            }else {
                $query = $db->prepare("INSERT INTO products (id, product_name, price, field, height_cleats, material, image) VALUES (:id,:product_name,:price,:field,:height_cleats,:material,:image);");
                $query->bindParam(":id", $index);
                $query->bindParam(":product_name", $product_name);
                $query->bindParam(":price", $price);
                $query->bindParam(":field", $field);
                $query->bindParam(":height_cleats", $height);
                $query->bindParam(":material", $material);
                $query->bindParam(":image", $img1);
                if ($query->execute()) {
                    //new record created successfully
                    echo "inserted";
                } else {
                    echo "not inserted";
                }
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that checks if there is a user in the users table with username and password provided in input.
 * Param: username, password
 * Return : "find" in case of success, "not find" otherwise
 */
function loginInitial(){
    if (isset($_SESSION,$_POST["username"],$_POST["password"])) {
        try {
            $db = dbConnect();
            if ((!filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING))
                && (!filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING))
                && !((strlen($_POST["username"]) >= 4 && strlen($_POST["username"]) <= 16 && strlen($_POST["password"]) == 10))){
                $_SESSION["error"]="Date inserted are not secure!";
                header("Location: ../php/login.php");
            }
            $username = $db->quote($_POST["username"]);
            $new_password = md5($_POST["password"]);
            $rows = $db->query("SELECT * FROM users WHERE username=$username");
            if ($rows != null && $rows->rowCount() === 1) {
                $row = $rows->fetch();
                if ($new_password === $row['password']) {
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['surname'] = $row['surname'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['typeof'] = $row['typeof'];
                    echo "find";
                }
            }
            echo "not find";
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/login.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/login.php");
    }
}

/*
 * Function that takes in input all the data of a user and inserts the user with the user typeof in the users table
 * Param: name, surname, username, email, password
 * Return : "added" in case of success, "error" in case of failure and "username" if a user with that username already exists
 */
function registrationInitial(){
    if (isset($_SESSION,$_POST['name'],$_POST['surname'],$_POST['username'],$_POST['email'],$_POST['password'])) {
        try {
            $db = dbConnect();
            if ((!filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING))
                && (!filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING))
                && (!filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING))
                && (!filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))
                && (!filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL))
                && (!filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING))
                && !((strlen($_POST["username"]) >= 4 && strlen($_POST["username"]) <= 16 && strlen($_POST["password"]) == 10))
                && !((strlen($_POST["name"]) <= 32 && strlen($_POST["surname"]) <= 32 && strlen($_POST["email"]) <=32))){
                $_SESSION["error"]="Date inserted are not secure!";
                header("Location: ../php/login.php");
            }
            $name = $db->quote($_POST["name"]);
            $surname = $db->quote($_POST["surname"]);
            $username = $db->quote($_POST["username"]);
            $email = $db->quote($_POST["email"]);
            $typeof = "user";
            $password = md5(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
            $checkUsername=$db->query("SELECT username FROM users WHERE username=$username");
            if($checkUsername != null && $checkUsername->rowCount() >= 1){
                echo "username";
            }else {
                $sql = $db->prepare("INSERT INTO users (username, name, surname, email, password, typeof) VALUES ($username, $name, $surname, $email, :password, :typeof)");
                $sql->bindParam(":password", $password);
                $sql->bindParam(":typeof", $typeof);
                if ($sql->execute()) {
                    //new user created successfully
                    $_SESSION['username'] = str_replace("'","",$username);
                    $_SESSION['name'] = str_replace("'","",$name);
                    $_SESSION['surname'] = str_replace("'","",$surname);
                    $_SESSION['email'] = str_replace("'","",$email);
                    $_SESSION['typeof'] = str_replace("'","",$typeof);
                    echo "added";
                }
                echo "error";
            }
            return 1;
        }catch(PDOException){
            $_SESSION["error"]="Something went wrong in connection to database. Please try again later!";
            header("Location: ../php/registration.php");
        }
    }else{
        $_SESSION["error"]="Something went wrong. Please log in and try again!";
        header("Location: ../php/registration.php");
    }
}