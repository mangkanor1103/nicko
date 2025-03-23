<?php
require 'config.php'; // Database connection


$tagalogTranslation = '';
$mangyanTranslation = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['tagalog_word'])) {
        $word = $_GET['tagalog_word'];
        $query = "SELECT * FROM translations WHERE tagalog_word='$word'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $mangyanTranslation .= "Mangyan: " . $row['mangyan_word'] . " (" . $row['dialect'] . ")<br>";
            }
        } else {
            $mangyanTranslation = "Walang nahanap na translation.";
        }
    }

    if (isset($_GET['mangyan_word'])) {
        $word = $_GET['mangyan_word'];
        $query = "SELECT * FROM translations WHERE mangyan_word='$word'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tagalogTranslation .= "Tagalog: " . $row['tagalog_word'] . " (" . $row['dialect'] . ")<br>";
            }
        } else {
            $tagalogTranslation = "Walang nahanap na translation.";
        }
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
            background-color: #0d0d0d; /* Dark background */
            color: #e0e0e0; /* Light text color */
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Full height for footer positioning */
        }

        header {
            background: #1a1a1a; /* Darker header */
            color: #00ff00; /* Neon green text */
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5); /* Neon glow effect */
            position: relative;
        }

        .container {
            flex: 1; /* Allow the container to grow */
            display: flex;
            justify-content: space-between; /* Align items to the left and right */
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
            overflow-y: auto; /* Allow scrolling */
        }

        .form-box {
            background: #1a1a1a; /* Dark background for forms */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5); /* Neon glow effect */
            width: 45%; /* Adjust width as needed */
            margin: 10px; /* Space between forms */
            position: relative;
            overflow: hidden; /* Hide overflow for animations */
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px 40px; /* Add padding for icons */
            margin-bottom: 10px;
            border: 1px solid #00ff00; /* Neon green border */
            border-radius: 5px;
            background: #121212; /* Dark input background */
            color: #00ff00; /* Neon green text */
        }

        .icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #00ff00; /* Neon green icon color */
            font-size: 20px;
        }

        button {
            background: #00ff00; /* Neon green button */
            color: #121212; /* Dark text color */
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* Full width button */
            transition: background 0.3s; /* Smooth transition */
        }

        button:hover {
            background: #00cc00; /* Darker green on hover */
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background: rgba(0, 255, 0, 0.1); /* Light neon green background */
            border-radius: 5px;
        }

        /* Animation for moving icons */
        .moving-icon {
            position: absolute;
            font-size: 50px; /* Icon size */
            color: #00ff00; /* Neon green color */
            animation: move 10s linear infinite;
        }

        @keyframes move {
            0% { transform: translate(0, 0); }
            20% { transform: translate(100px, 50px); }
            40% { transform: translate(0, 100px); }
            60% { transform: translate(-100px, 50px); }
            80% { transform: translate(50px, 0); }
            100% { transform: translate(0, 0); }
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #1a1a1a; /* Dark footer */
            color: #00ff00; /* Neon green text */
            box-shadow: 0 -1px 10px rgba(0, 255, 0, 0.5); /* Neon glow effect */
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column; /* Stack forms on smaller screens */
            }

            .form-box {
                width: 100%; /* Full width on small screens */
                margin: 0; /* Remove margin */
                margin-bottom: 20px; /* Space between stacked forms */
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
                    <i class="fas fa-comment icon"></i>
                    <input type="text" name="tagalog_word" placeholder="Enter Tagalog word..." required>
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
                    <i class="fas fa-comment-dots icon"></i>
                    <input type="text" name="mangyan_word" placeholder="Enter Mangyan word..." required>
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