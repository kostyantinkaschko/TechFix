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
        $id = $_POST["id"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hashedPasswordFromDB = $result['password_hash'];

            if ($password == $hashedPasswordFromDB) {
                $_SESSION['id'] = $result['id']; // Зберігаємо ID користувача у сесії
                header("Location: dashboard.php");
                exit();

            } else {
                $error = "Невірний логін або пароль. Спробуйте ще раз.";
            }
        } else {
            $error = "Користувача з таким логіном не знайдено.";
        }
    }


} catch (PDOException $e) {
    echo "<p>Помилка підключення до бази даних: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        сontent="TechFix - ваш партнер у світі комп'ютерів. Надійний сервіс та уважний підхід до ремонту та збірки ПК, щоб забезпечити оптимальну продуктивність та задоволення від використання вашого обладнання.">
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
    <title>TechFix - знайти своє замовлення</title>
</head>

<body>
    <div class="vignette"></div>
    <div class="frame1"></div>
    <div class="frame2"></div>
    <div class="frame3"></div>
    <div class="frame4"></div>
    <div class="second-page-wrapper">
        <div class="wrapper">
            <header itemscope="itemscope" itemtype="https://schema.org/WPHeader">
                <a class="logo" href="../index.html" itemprop="logo" itemscope="itemscope">
                    <img itemtype="https://schema.org/ImageObject" src="../img/techfix.png" alt="Сервісний центр TechFix"  title="Сервісний центр TechFix">
                    <h1 itemprop="headline">Що з моїм пк?</h1>
                </a>
            </header>
            <main>
                <div class="sides second-page">
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
                    <hr class="vertical">
                    <div class="rightside forma">
                        <h2>Форма:</h2>
                        <form action="#" method="post" class="login-form">
                            <div>
                                <p>Номер замовлення:</p>
                                <input type="number" name="id" placeholder="Ваш ID">
                            </div>
                            <hr class="underinput">
                            <div>
                                <p>Пароль:</p>
                                <input type="password" name="password">
                            </div>
                            <hr class="underinput">
                            <div>
                                <input type="submit" value="Увійти">
                            </div>
                        </form>

                        <?php if (isset($error)): ?>
                            <p>
                                <?php echo '<p class="error">' . $error . '</p>'; ?>
                            </p>
                        <?php endif; ?>


                    </div>
                </div>
            </main>
            <footer itemscope="itemscope" itemtype="https://schema.org/WPFooter">
                <p itemprop="legalName">TechFix</p>
            </footer>
        </div>
    </div>
</body>

</html>