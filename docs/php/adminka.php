<script>
    window.onload = function () {
        // Перенаправлення, якщо ширина екрану менше 900px
        if (window.innerWidth < 900) {
            window.location.href = 'error.php';
        }
    };
</script>
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

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Отримання списку користувачів з таблиці "users"
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Помилка: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Адмін-панель</title>
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
    <title>Вхід</title>
</head>

<body>
    <main>
        <div class="admin-panel">
            <h1>Адмін-панель</h1>
            <a href="../index.html">Повернутись на головну</a>
            <a href="create.php">Створити новий запит</a>
            <div class="sides">
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Пароль</th>
                            <th>Стан</th>
                            <th>Тип пристрою</th>
                            <th>Робота яку потрібно зробити</th>
                            <th>Кнопка</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?= $user['id'] ?>
                                </td>
                                <td>
                                    <?= $user['password_hash'] ?>
                                </td>
                                <td>
                                    <?= $user['status'] ?>
                                </td>
                                <td>
                                    <?= $user['type'] ?>
                                </td>
                                <td>
                                    <?= $user['infoAboutRepair'] ?>
                                </td>
                                <td>
                                    <button onclick="enableEdit(this)">Редагувати</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

    </main>

    </div>

    <script>
        function enableEdit(button) {
            const row = button.parentNode.parentNode;
            const cells = row.getElementsByTagName('td');
            if (button.innerText === 'Зберегти') {
                const id = cells[0].innerText;
                const passwordHash = cells[1].querySelector('input').value;
                const status = cells[2].querySelector('input').value;
                const type = cells[3].querySelector('input').value;
                const infoAboutRepair = cells[4].querySelector('input').value;

                fetch('save_changes.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: id,
                        password_hash: passwordHash,
                        status: status,
                        type: type,
                        infoAboutRepair: infoAboutRepair
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            for (let i = 1; i < cells.length - 1; i++) {
                                const cell = cells[i];
                                const inputField = cell.querySelector('input');
                                const value = inputField.value;
                                cell.removeChild(inputField);
                                cell.innerText = value;
                            }
                            button.innerText = 'Редагувати';
                        } else {
                            alert('Помилка збереження змін');
                        }
                    })
                    .catch(error => {
                        console.error('Помилка:', error);
                    });
            } else {
                for (let i = 1; i < cells.length - 1; i++) {
                    const cell = cells[i];
                    const currentValue = cell.innerText;
                    const inputField = document.createElement('input');
                    inputField.value = currentValue;
                    cell.innerText = '';
                    cell.appendChild(inputField);
                }
                button.innerText = 'Зберегти';
            }
        }
        // Зміни функції enableEdit
        function enableEdit(button) {
            const row = button.parentNode.parentNode;
            const cells = row.getElementsByTagName('td');
            if (button.innerText === 'Зберегти') {
                const id = cells[0].innerText;
                const passwordHash = cells[1].querySelector('input').value;
                const status = cells[2].querySelector('input').value;
                const type = cells[3].querySelector('input').value;
                const infoAboutRepair = cells[4].querySelector('input').value;

                fetch('save_changes.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&password_hash=${passwordHash}&status=${status}&type=${type}&infoAboutRepair=${infoAboutRepair}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            for (let i = 1; i < cells.length - 1; i++) {
                                const cell = cells[i];
                                const inputField = cell.querySelector('input');
                                const value = inputField.value;
                                cell.removeChild(inputField);
                                cell.innerText = value;
                            }
                            button.innerText = 'Редагувати';
                        } else {
                            alert('Помилка збереження змін');
                        }
                    })
                    .catch(error => {
                        console.error('Помилка:', error);
                    });
            } else {
                for (let i = 1; i < cells.length - 1; i++) {
                    const cell = cells[i];
                    const currentValue = cell.innerText;
                    const inputField = document.createElement('input');
                    inputField.value = currentValue;
                    cell.innerText = '';
                    cell.appendChild(inputField);
                }
                button.innerText = 'Зберегти';
            }
        }

    </script>
</body>

</html>