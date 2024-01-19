<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stuffedpals_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productName = $_POST['product_name'];
    $productName = substr($productName, 0, 100);

    $productCategory = filter_var($_POST['product_category'], FILTER_SANITIZE_NUMBER_INT);
    $productCategory = (int)$productCategory;
    $productCategory = min(max($productCategory, PHP_INT_MIN), PHP_INT_MAX);

    $productSupplier = filter_var($_POST['product_supplier'], FILTER_SANITIZE_NUMBER_INT);
    $productSupplier = (int)$productSupplier;
    $productSupplier = min(max($productSupplier, PHP_INT_MIN), PHP_INT_MAX);

    $productPrice = filter_var($_POST['product_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $productPrice = round((float)$productPrice, 2);
    $productPrice = min(max($productPrice, -999.99), 999.99);

    $productQuantity = filter_var($_POST['product_quantity'], FILTER_SANITIZE_NUMBER_INT);
    $productQuantity = (int)$productQuantity;
    $productQuantity = min(max($productQuantity, PHP_INT_MIN), PHP_INT_MAX);

    $productImagePath = substr(filter_var($conn->real_escape_string($_POST['product_image_path']), FILTER_SANITIZE_STRING), 0, 200);
    $productImageDescription = substr(filter_var($conn->real_escape_string($_POST['product_image_description']), FILTER_SANITIZE_STRING), 0, 1000);
    $productDescription = $_POST['product_description'];
    $productDescription = substr($productDescription, 0, 1000);
   
    $stmt = $conn->prepare("CALL AddProduct(?, ?, ?, ?, ?, ?, ?, ?, @p_status, @p_message)");
    $stmt->bind_param("siidisss", $productName, $productCategory, $productSupplier, $productPrice, $productQuantity, $productImagePath, $productImageDescription, $productDescription);
    if ($stmt->execute()) {
        $select = $conn->query("SELECT @p_status AS status, @p_message AS message");
        $result = $select->fetch_assoc();
        $response = ["status" => $result['status'], "msg" => $result['message']];
    } else {
        $response = ["status" => 1, "msg" => "Error while adding product."];
    }
}
$stmt->close();
echo json_encode($response);
?>
