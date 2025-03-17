<?php
$conn = new mysqli("localhost", "root", "", "mangyan");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        header {
            background: #007bff;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
        }

        .form-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .form-box {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 45%; /* Adjust width as needed */
            margin: 10px; /* Space between forms */
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* Full width button */
        }

        button:hover {
            background: #0056b3;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background: #e9ecef;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .form-container {
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
    </header>

    <div class="container">
        <div class="form-container">
            <div class="form-box">
                <h2>Tagalog to Mangyan Translation</h2>
                <form action="" method="GET">
                    <input type="text" name="tagalog_word" placeholder="Enter Tagalog word..." required>
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
                    <input type="text" name="mangyan_word" placeholder="Enter Mangyan word..." required>
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
    </div>

    <footer>
        <p>&copy; 2023 Translation App</p>
    </footer>
</body>
</html>