<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = basename($_FILES['file']['name']);
    $uploadDir = __DIR__ . '/Attachments/upload/';
    $target = $uploadDir . $filename;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Stwórz folder, jeśli nie istnieje
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        echo "✅ Plik przesłany: <a href='Attachments/upload/" . htmlspecialchars($filename) . "'>Zobacz</a>";
    } else {
        echo "❌ Błąd przy uploadzie.";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit">Wyślij</button>
</form>
