<?php

require '../config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare(
"DELETE FROM rooms WHERE id=?"
);

$stmt->execute([$id]);

header("Location:kamar.php");
exit;