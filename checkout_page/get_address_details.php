<?php
require_once "../init.php";

if(isset($_POST['addressId']) && !empty($_POST['addressId'])) {
    $addressId = $_POST['addressId'];
    $query = $conn->prepare("SELECT * FROM user_address WHERE id = ?");
    $query->bind_param("i", $addressId);
    $query->execute();
    $result = $query->get_result();

    if($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Address not found.']);
    }
} else {
    echo json_encode(['error' => 'No address ID provided.']);
}
?>
