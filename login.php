<?php
session_start();

if (!isset($_SESSION['Username'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #8094eb 0%, #eeacf696 100%);
            margin: 0;
            padding: 40px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dashboard-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            padding: 40px;
            text-align: center;
        }

        .welcome-header {
            margin-bottom: 30px;
        }

        .welcome-header h2 {
            color: #333;
            font-size: 28px;
            margin: 0;
        }

        .dashboard-grid {
            display: flex;
            gap: 30px;
            justify-content: space-between;
        }

        .dashboard-column {
            flex: 1;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .status-box {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .activity-box {
            background: #f3f6ff;
            border: 1px solid #d6e0ff;
            border-radius: 8px;
            padding: 20px;
        }

        .activity-box h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 20px;
            color: #333;
        }

        .activity-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .activity-list li {
            padding: 10px 0;
            border-bottom: 1px solid #e6eaf9;
            font-size: 14px;
            color: #555;
        }

        .activity-list li:last-child {
            border-bottom: none;
        }

        .logout-section {
            margin-top: 30px;
            text-align: center;
        }

        a.logout-link {
            display: inline-block;
            color: #ffffff;
            background: #dc3545;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s;
        }

        a.logout-link:hover {
            background: #c82333;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="welcome-header">
            <h2>Welcome <?php echo htmlspecialchars($_SESSION['Username']); ?>!</h2>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-column">
                <div class="status-box">
                    <?php
                    if (isset($_COOKIE['remember_username']) && isset($_COOKIE['remember_password'])) {
                        echo "Remember-Me Cookies Active";
                    } else {
                        echo "Session Active";
                    }
                    ?>
                </div>
            </div>

            <div class="dashboard-column">
                <div class="activity-box">
                    <h3>Recent Activity</h3>
                    <?php if (!empty($_SESSION['activity'])): ?>
                        <ul class="activity-list">
                            <?php foreach ($_SESSION['activity'] as $event): ?>
                                <li><?php echo htmlspecialchars($event); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No recent activity yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="logout-section">
            <a class="logout-link" href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>