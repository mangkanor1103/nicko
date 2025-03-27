<?php
require 'config.php'; // Database connection

$tagalogTranslation = '';
$mangyanTranslation = '';

// Function to get translations word by word
function translateSentence($conn, $sentence, $sourceColumn, $targetColumn) {
    $words = explode(" ", trim($sentence)); // Split sentence into words
    $translatedWords = [];

    $stmt = $conn->prepare("SELECT $targetColumn FROM translations WHERE $sourceColumn = ?");

    foreach ($words as $word) {
        $stmt->bind_param("s", $word);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $translatedWords[] = htmlspecialchars($row[$targetColumn]); // Prevent XSS
        } else {
            $translatedWords[] = htmlspecialchars($word); // Keep original word if not found
        }
    }

    $stmt->close();
    return implode(" ", $translatedWords); // Reconstruct translated sentence
}

// Process GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['tagalog_sentence'])) {
        $tagalogSentence = $_GET['tagalog_sentence'];
        $mangyanTranslation = translateSentence($conn, $tagalogSentence, 'tagalog_word', 'mangyan_word');
    }

    if (!empty($_GET['mangyan_sentence'])) {
        $mangyanSentence = $_GET['mangyan_sentence'];
        $tagalogTranslation = translateSentence($conn, $mangyanSentence, 'mangyan_word', 'tagalog_word');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mangyan-Tagalog Translator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff; /* White background */
            color: #006600; /* Dark green text color */
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background: #008000; /* Green header */
            color: #ffffff; /* White text */
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 128, 0, 0.5);
        }
        .container {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
            overflow-y: auto;
        }
        .form-box {
            background: #f0fff0; /* Light greenish background */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 128, 0, 0.5);
            width: 45%;
            margin: 10px;
        }
        .input-container {
            position: relative;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%; /* Full width */
            padding: 12px; /* Adjust padding for better spacing */
            margin-bottom: 10px;
            border: 1px solid #008000;
            border-radius: 5px;
            background: #ffffff;
            color: #008000;
            box-sizing: border-box; /* Prevents overflow */
        }
        .icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #008000;
            font-size: 20px;
        }
        button {
            background: #008000;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        button:hover {
            background: #006600;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background: rgba(0, 128, 0, 0.1);
            border-radius: 5px;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background: #008000;
            color: #ffffff;
            box-shadow: 0 -1px 10px rgba(0, 128, 0, 0.5);
        }
        .moving-icon {
            position: absolute;
            font-size: 50px;
            color: rgba(0, 128, 0, 0.5);
            animation: move 10s linear infinite;
        }
        @keyframes move {
            0% { transform: translateY(0); }
            100% { transform: translateY(-100vh); }
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .form-box {
                width: 100%;
                margin: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Mangyan-Tagalog Translator</h1>
        <i class="fas fa-language moving-icon" style="top: 10px; left: 10px;"></i>
        <i class="fas fa-language moving-icon" style="top: 10px; right: 10px;"></i>
        <i class="fas fa-globe moving-icon" style="top: 50px; left: 50px;"></i>
        <i class="fas fa-globe moving-icon" style="top: 50px; right: 50px;"></i>
    </header>

    <div class="container">
        <div class="form-box">
            <h2>Tagalog to Mangyan Translation</h2>
            <form action="" method="GET">
                <div class="input-container">
                    <i class="fas fa-language icon"></i>
                    <input type="text" name="tagalog_sentence" placeholder="Enter Tagalog sentence...">
                </div>
                <button type="submit">Translate</button>
            </form>
            <div class="result">
                <?php if ($mangyanTranslation): ?>
                    <h3>Translation Result:</h3>
                    <p><?php echo $mangyanTranslation; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-box">
            <h2>Mangyan to Tagalog Translation</h2>
            <form action="" method="GET">
                <div class="input-container">
                    <i class="fas fa-language icon"></i>
                    <input type="text" name="mangyan_sentence" placeholder="Enter Mangyan sentence...">
                </div>
                <button type="submit">Translate</button>
            </form>

            <div class="result">
                <?php if ($tagalogTranslation): ?>
                    <h3>Translation Result:</h3>
                    <p><?php echo $tagalogTranslation; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Translation App</p>
        <p><a href="admin.php" style="color: #00ff00; text-decoration: none;">Add Another Translation</a></p>
    </footer>

</body>
</html>