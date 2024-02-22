<?php
include("../modules/db.php");

$street = $_GET['street'];

$sql = "SELECT id, number FROM housing WHERE street = '$street'";
$result = $db->query($sql);

$html = '<option selected disabled value="">Выберите номер дома</option>';
while ($row = $result->fetch_assoc()) {
    $html .= '<option value="' . $row['id'] . '">' . $row['number'] . '</option>';
}

echo $html;

$db->close();
?>