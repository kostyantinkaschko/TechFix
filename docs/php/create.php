<?php
session_start();

// Перевірка, чи користувач увійшов в систему
function isLoggedIn()
{
    return isset($_SESSION['id']) && isset($_SESSION['username']);
}

// Перевірка, чи адміністратор увійшов в систему
if (!isLoggedIn()) {
    header("Location: logininadminka.php");
    exit();
}

// З'єднання з базою даних
$servername = "localhost";
$database = "techfix";
$username = "root";
$password = "!L-fKdz@9TR6i*b";

// Обробка відправленої форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Отримання даних з форми
        $passwordHash = $_POST['password'];
        $status = $_POST['status'];
        $deviceType = $_POST['deviceType'];
        $repairInfo = $_POST['repairInfo'];

        // Підготовка та виконання запиту на вставку даних в базу
        $stmt = $conn->prepare("INSERT INTO users (password_hash, status, type, infoAboutRepair) VALUES (:password_hash, :status, :type, :infoAboutRepair)");
        $stmt->bindParam(':password_hash', $passwordHash);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':type', $deviceType);
        $stmt->bindParam(':infoAboutRepair', $repairInfo);

        $stmt->execute();

        header("Location: adminka.php");
        exit();
    } catch (PDOException $e) {
        echo "Помилка: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        сontent="TechFix - ваш партнер у світі комп'ютерів. Надійний сервіс та уважний підхід до ремонту та збірки ПК, щоб забезпечити оптимальну продуктивність та задоволення від використання вашого обладнання." />
    <meta name="keywords" content="Techfix, ремонт, відремонтувати, купити комп'ютер, замовити пк" />
    <meta name="author" content="Кашко Костянтин" />
    <meta name="publisher" content="Кашко Костянтин" />
    <meta name="copyright" lang="uk" content="TechFix Ремонт, Оновлення та збірка для вашого Комп'ютера!" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="apple-touch-icon" sizes="57x57" href="../img/favicon/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="../img/favicon/apple-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="../img/favicon/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon/apple-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="../img/favicon/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="../img/favicon/apple-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="../img/favicon/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="../img/favicon/apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-icon-180x180.png" />
    <link rel="icon" type="image/png" sizes="192x192" href="../img/favicon/android-icon-192x192.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="96x96" href="../img/favicon/favicon-96x96.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../mg/favicon/favicon-16x16.png" />
    <link rel="manifest" href="../manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../img/favicon/ms-icon-144x144.png" />
    <meta name="theme-color" content="#ffffff">
    <meta property="og:title" content="TechFix Ремонт, Оновлення та збірка для вашого Комп'ютера!" />
    <meta property="og:description"
        content="TechFix - комп'ютерний сервіс з максимальною ефективністю ремонту вашого пк." />
    <meta property="og:image" content="../img/logo.png">
    <meta property="og:url" content="https://kostyantinkaschko.github.io/TechFix/" />
    <meta property="og:type" content="business.business">
    <title>Створення нового запиту</title>
</head>

<body>
    <div class="admin-panel">
        <h1>Створення нового запиту</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="password">Пароль:</label>
            <input type="text" id="password" name="password">

            <label for="status">Статус:</label>
            <input type="text" id="status" name="status">

            <label for="deviceType">Тип пристрою:</label>
            <input type="text" id="deviceType" name="deviceType">

            <label for="repairInfo">Праця яку потрібно зробити:</label>
            <input type="text" name="repairInfo" id="repairInfo">

            <input type="submit" value="Створити запит">
        </form>
    </div>

</body>

</html>