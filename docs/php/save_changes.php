<?php
session_start();

// Перевірте, чи отримані необхідні дані
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $passwordHash = $_POST['password_hash'];
    $status = $_POST['status'];
    $type = $_POST['type'];
    $infoAboutRepair = $_POST['infoAboutRepair'];

    $servername = "localhost";
    $database = "techfix";
    $username = "root";
    $password = "!L-fKdz@9TR6i*b";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Оновлення запису в базі даних
        $stmt = $conn->prepare("UPDATE users SET password_hash = :passwordHash, status = :status, type = :type, infoAboutRepair = :infoAboutRepair WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':passwordHash', $passwordHash);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':infoAboutRepair', $infoAboutRepair);

        $stmt->execute();

        // Повернення успіху
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // Повернення помилки у випадку виникнення виключення
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    // Повернення помилки, якщо дані не були надіслані правильно
    echo json_encode(['success' => false, 'error' => 'Invalid data sent']);
}
?>
