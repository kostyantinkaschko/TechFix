<?php
session_start();

// Перевірка, чи користувач автентифікований
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Перенаправлення на сторінку входу, якщо користувач не автентифікований
    exit();
}

// Якщо користувач автентифікований, виводимо dashboard
$userID = $_SESSION['id'];

// Параметри підключення до бази даних
$servername = "localhost";
$database = "techfix";
$username = "root";
$password = "!L-fKdz@9TR6i*b";

try {
    // Підключення до бази даних
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Отримання інформації про користувача на основі його ID з сесії (за параметром :id)
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(":id", $userID); // Вставляємо значення $userID в запит
    $stmt->execute();

    $orderInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Якщо інформація про користувача знайдена
    if ($orderInfo) {
        $orderNumber = $orderInfo['id'];
        $deviceType = $orderInfo['type'];
        $status = $orderInfo['status'];
        $repairStartDate = $orderInfo['date'];
        $infoAboutRepair = $orderInfo['infoAboutRepair'];
    }
} catch (PDOException $e) {
    echo "<p>Помилка: " . $e->getMessage() . "</p>";
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
    <title>TechFix - замовлення номер
        <?php echo $userID; ?>
    </title>
</head>

<body>
    <div class="vignette"></div>
    <div class="frame1"></div>
    <div class="frame2"></div>
    <div class="frame3"></div>
    <div class="frame4"></div>
    <div class="wrapper">
        <header itemscope="itemscope" itemtype="https://schema.org/WPHeader">
            <div class="logo" itemprop="logo" itemscope="itemscope" itemtype="https://schema.org/ImageObject">
                <img src="../img/techfix.png" alt="Сервісний центр TechFix" />
                <h1 itemprop="headline">Замовлення номер
                    <?php echo $userID; ?>
                </h1>
            </div>
        </header>
        <main>
            <div class="sides">
                <div class="leftside">
                    <p>
                        TechFix - надає доступ дізнатись що відбувається з вашим ПК під час ремонту. Ввівши номер
                        замовлення та пароль до нього, можна дізнатись, що зараз відбувається з вашим ноутбуком і чи
                        відремонтували його.
                    </p>
                    <p>
                        Крім стану замовлення є багато іншої інформації, яка вам може знадобитись. Просто введіть
                        данні
                        в форму, і дізнайтесь, як проводить день ваш ПК :0.
                    </p>
                    <p>
                        Наші контакти тут: <a href="../">Сюди можна клікнути!</a>
                    </p>
                </div>
                <div class="vertical"></div>
                <div class="rightside order">
                    <div class="headline">
                        <h2>Ваше замовлення:</h2>
                    </div>
                    <div class="content">
                        <?php
                        echo "<p>Номер замовлення:  <span> $orderNumber</span></p>";
                        echo "<p>Тип пристрою: <span>$deviceType</span></p>";
                        echo "<p>Стан: <span>$status</span></p>";
                        echo "<p>Дата: <span>$repairStartDate</span></span></p>";
                        echo "<p>Вид ремонту: <span>$infoAboutRepair</span></p>"
                            ?>
                    </div>
                </div>

        </main>
        <footer itemscope="itemscope" itemtype="https://schema.org/WPFooter">
            <p itemprop="legalName">TechFix</p>
        </footer>
    </div>
</body>

</html>