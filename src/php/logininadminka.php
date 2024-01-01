<?php
session_start();

// Параметри підключення до бази даних
$servername = "localhost";
$database = "techfix";
$username = "root";
$password = "!L-fKdz@9TR6i*b";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $_SESSION['username'] = $_POST["username"];
        // Вибірка хешованого паролю з бази даних за логіном
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hashedPasswordFromDB = $result['password'];

            if ($password == $hashedPasswordFromDB) {
                // Логін та пароль вірні, створення сесії для авторизації
                $_SESSION['user_id'] = $result['id'];
                header("Location: adminka.php"); // Перенаправлення на сторінку після входу
                exit();
            }
        }
    }
} catch (PDOException $e) {
    echo "<p>Помилка підключення до бази даних: " . $e->getMessage() . "</p>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" сontent="TechFix - ваш партнер у світі комп'ютерів. Надійний сервіс та уважний підхід до ремонту та збірки ПК, щоб забезпечити оптимальну продуктивність та задоволення від використання вашого обладнання.">
    <meta name="keywords" content="Techfix, ремонт, відремонтувати, купити комп'ютер, замовити пк">
    <meta name="author" content="Кашко Костянтин">
    <meta name="publisher" content="Кашко Костянтин">
    <meta name="copyright" lang="uk" content="TechFix Ремонт, Оновлення та збірка для вашого Комп'ютера!">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="apple-touch-icon" sizes="57x57" href="../img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../mg/favicon/favicon-16x16.png">
    <link rel="manifest" href="../manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:title" content="TechFix Ремонт, Оновлення та збірка для вашого Комп'ютера!">
    <meta property="og:description"
        content="TechFix - комп'ютерний сервіс з максимальною ефективністю ремонту вашого пк.">
    <meta property="og:image" content="img/logo.png">
    <meta property="og:url" content="https://kostyantinkaschko.github.io/TechFix/">
    <meta property="og:type" content="business.business">
    <title>Вхід</title>
</head>

<body>
    <div class="vignette"></div>
    <div class="admin-panel mw320">
        <div>
            <h2>Вхід в акаунт</h2>
            <form class="form" method="post" action="logininadminka.php">
                <label for="username">Логін:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Пароль:</label>
                <input type="password" name="password" id="password" required>
                <?php
                    if(isset($_POST['password'])){
                        if ($password == $hashedPasswordFromDB) {
                        } else {
                            echo "<p>Неправильний логін, або пароль.</p>";
                        }
                    }
                ?>
                <input type="submit" value="Увійти">
            </form>
        </div>
    </div>

    </div>
</body>

</html>