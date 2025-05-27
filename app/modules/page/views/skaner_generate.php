<?php
// barcode_generator.php
// Генерація штрих-кодів для працівників барбершопу

// Підключення до бази даних
$host = 'localhost';
$dbname = 'l_sklo';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Помилка підключення: " . $e->getMessage());
}

// Функція для генерації штрих-коду (використовуємо просту бібліотеку)
function generateBarcode($code, $type = 'C128') {
    // Для простоти, генеруємо SVG штрих-код
    $barcode_svg = '
    <svg width="200" height="80" xmlns="http://www.w3.org/2000/svg">
        <rect width="200" height="80" fill="white"/>
        <text x="100" y="20" text-anchor="middle" font-family="Arial" font-size="14">ID: ' . htmlspecialchars($code) . '</text>
        <g transform="translate(10, 30)">';
    
    // Простий алгоритм для створення штрихів
    $binary = str_pad(decbin(intval($code)), 40, '0', STR_PAD_LEFT);
    $x = 0;
    
    for ($i = 0; $i < strlen($binary); $i++) {
        if ($binary[$i] == '1') {
            $barcode_svg .= '<rect x="' . ($x * 4) . '" y="0" width="3" height="40" fill="black"/>';
        }
        $x++;
    }
    
    $barcode_svg .= '
        </g>
        <text x="100" y="75" text-anchor="middle" font-family="Arial" font-size="12">' . htmlspecialchars($code) . '</text>
    </svg>';
    
    return $barcode_svg;
}

// API для обробки запитів
if (isset($_GET['action'])) {
    
    switch ($_GET['action']) {
        
        // Отримати всіх працівників з їх штрих-кодами
        case 'get_workers':
            $stmt = $pdo->prepare("
                SELECT u.id, u.firstname, u.lastname, u.job_title, u.role,
                       GROUP_CONCAT(s.title SEPARATOR ', ') as shops
                FROM users u
                LEFT JOIN users_shops us ON u.id = us.user_id
                LEFT JOIN shops s ON us.shop_id = s.id
                WHERE u.role IN ('master', 'admin', 'moder') 
                AND u.deleted = 'no'
                GROUP BY u.id
                ORDER BY u.firstname, u.lastname
            ");
            $stmt->execute();
            $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            header('Content-Type: application/json');
            echo json_encode($workers);
            break;
            
        // Генерувати штрих-код для конкретного працівника
        case 'generate_barcode':
            if (!isset($_GET['user_id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID користувача не вказано']);
                exit;
            }
            
            $user_id = intval($_GET['user_id']);
            
            // Перевіряємо, чи існує користувач
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND deleted = 'no'");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                http_response_code(404);
                echo json_encode(['error' => 'Користувача не знайдено']);
                exit;
            }
            
            // Генеруємо SVG штрих-код
            header('Content-Type: image/svg+xml');
            echo generateBarcode($user_id);
            break;
            
        // Перевірити штрих-код (для сканера)
        case 'verify_barcode':
            if (!isset($_POST['code'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Код не вказано']);
                exit;
            }
            
            $code = $_POST['code'];
            
            // Шукаємо користувача по ID
            $stmt = $pdo->prepare("
                SELECT u.id, u.firstname, u.lastname, u.job_title,
                       GROUP_CONCAT(s.title SEPARATOR ', ') as shops
                FROM users u
                LEFT JOIN users_shops us ON u.id = us.user_id
                LEFT JOIN shops s ON us.shop_id = s.id
                WHERE u.id = ? AND u.deleted = 'no'
                GROUP BY u.id
            ");
            $stmt->execute([$code]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Записуємо відвідування
                $stmt = $pdo->prepare("
                    INSERT INTO attendance (user_id, shop_id, check_in, date, status)
                    VALUES (?, ?, NOW(), CURDATE(), 'present')
                    ON DUPLICATE KEY UPDATE
                    check_out = NOW(),
                    hours_worked = TIMESTAMPDIFF(HOUR, check_in, NOW())
                ");
                
                // Беремо перший заклад користувача (в реальності можна вибирати)
                $shop_id = 1; // За замовчуванням
                $stmt->execute([$user['id'], $shop_id]);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'user' => $user,
                    'time' => date('Y-m-d H:i:s')
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Користувача не знайдено']);
            }
            break;
            
        // Отримати звіт відвідуваності
        case 'get_attendance':
            $where = [];
            $params = [];
            
            if (isset($_GET['date_from'])) {
                $where[] = "a.date >= ?";
                $params[] = $_GET['date_from'];
            }
            
            if (isset($_GET['date_to'])) {
                $where[] = "a.date <= ?";
                $params[] = $_GET['date_to'];
            }
            
            if (isset($_GET['user_id'])) {
                $where[] = "a.user_id = ?";
                $params[] = $_GET['user_id'];
            }
            
            if (isset($_GET['shop_id'])) {
                $where[] = "a.shop_id = ?";
                $params[] = $_GET['shop_id'];
            }
            
            $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";
            
            $stmt = $pdo->prepare("
                SELECT a.*, 
                       u.firstname, u.lastname, u.job_title,
                       s.title as shop_name
                FROM attendance a
                JOIN users u ON a.user_id = u.id
                JOIN shops s ON a.shop_id = s.id
                $whereClause
                ORDER BY a.date DESC, a.check_in DESC
            ");
            $stmt->execute($params);
            $attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            header('Content-Type: application/json');
            echo json_encode($attendance);
            break;
    }
}

// Сторінка для друку штрих-кодів
else {
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Генератор штрих-кодів - Папа+Син</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .barcode-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .barcode-card {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            background: #fafafa;
        }
        .barcode-card h3 {
            margin: 0 0 10px 0;
            color: #555;
            font-size: 16px;
        }
        .barcode-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #777;
        }
        .barcode-image {
            margin: 15px 0;
            border: 1px solid #ddd;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        .print-btn {
            background: #f39c12;
            color: white;
            border: none;
            padding: 10px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px auto;
            display: block;
        }
        .print-btn:hover {
            background: #e67e22;
        }
        @media print {
            body {
                margin: 0;
                background: white;
            }
            .container {
                box-shadow: none;
            }
            .print-btn {
                display: none;
            }
            .barcode-card {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Штрих-коди працівників - Папа+Син</h1>
        <button class="print-btn" onclick="window.print()">Друкувати штрих-коди</button>
        
        <div class="barcode-grid">
            <?php
            // Отримуємо всіх працівників
            $stmt = $pdo->prepare("
                SELECT u.id, u.firstname, u.lastname, u.job_title,
                       GROUP_CONCAT(s.title SEPARATOR ', ') as shops
                FROM users u
                LEFT JOIN users_shops us ON u.id = us.user_id
                LEFT JOIN shops s ON us.shop_id = s.id
                WHERE u.role IN ('master', 'admin', 'moder') 
                AND u.deleted = 'no'
                GROUP BY u.id
                ORDER BY u.firstname, u.lastname
            ");
            $stmt->execute();
            $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($workers as $worker) {
                echo '<div class="barcode-card">';
                echo '<h3>' . htmlspecialchars($worker['firstname'] . ' ' . $worker['lastname']) . '</h3>';
                echo '<p><strong>Посада:</strong> ' . htmlspecialchars($worker['job_title']) . '</p>';
                echo '<p><strong>Заклад:</strong> ' . htmlspecialchars($worker['shops'] ?: 'Не призначено') . '</p>';
                echo '<div class="barcode-image">';
                echo generateBarcode($worker['id']);
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
<?php
}
?>