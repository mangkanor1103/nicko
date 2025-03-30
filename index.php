<?php
require 'config.php'; // Database connection

$tagalogTranslation = '';
$mangyanTranslation = '';
$errorMessageTagalogToMangyan = '';
$errorMessageMangyanToTagalog = '';

// Function to get translations word by word
function translateSentence($conn, $sentence, $sourceColumn, $targetColumn) {
    $words = explode(" ", trim($sentence)); // Split sentence into words
    $translatedWords = [];
    $missingWordCount = 0; // Count of missing words

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
            $missingWordCount++; // Increment missing word count
        }
    }

    $stmt->close();
    if ($missingWordCount > 1) {
        return ['', true]; // Return empty if more than one word is missing
    } else {
        return [implode(" ", $translatedWords), false]; // Return translated sentence and no missing words
    }
}

// Process GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['tagalog_sentence'])) {
        $tagalogSentence = $_GET['tagalog_sentence'];
        list($mangyanTranslation, $noTranslation) = translateSentence($conn, $tagalogSentence, 'tagalog_word', 'mangyan_word');
        if ($noTranslation) {
            $errorMessageTagalogToMangyan = "No translation found for the given Tagalog sentence.";
        }
    }

    if (!empty($_GET['mangyan_sentence'])) {
        $mangyanSentence = $_GET['mangyan_sentence'];
        list($tagalogTranslation, $noTranslation) = translateSentence($conn, $mangyanSentence, 'mangyan_word', 'tagalog_word');
        if ($noTranslation) {
            $errorMessageMangyanToTagalog = "No translation found for the given Mangyan sentence.";
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
    background-image: url(1.jpg);
    background-size: cover; /* Ensures the image covers the entire screen */
    background-position: center; /* Centers the image */
    background-repeat: no-repeat; /* Prevents image tiling */
    background-attachment: fixed; /* Keeps the image fixed when scrolling */
    color: #006600; /* Dark green text color */
    margin: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

        header {
            background: #f0fff0; /* Light greenish background */
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
            color: #008 000;
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
            margin-top: 10px;
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
        .error {
            color: red; /* Error message color */
            margin-top: 10px;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background: #f0fff0; /* Light greenish background */
            color: #006600; /* Dark green text color */
            box-shadow: 0 -1px 10px rgba(0, 128, 0, 0.5);
        }
        .moving-icon {
            position: absolute;
            font-size: 50px;
            color: rgba(0, 128, 0, 0.5);
            animation: move 2s linear infinite;
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
        .input-container {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    padding-right: 35px; /* Space for the mic */
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.mic-icon {
    position: absolute;
    right: 10px;
    font-size: 18px;
    color: #666;
    cursor: pointer;
}

.mic-icon:hover {
    color: #000;
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
            <form id="tagalogForm" action="" method="GET">
    <div class="input-container">
        <input type="text" id="tagalogInput" name="tagalog_sentence" placeholder="Enter Tagalog sentence..." required>
        <i class="fas fa-microphone mic-icon" onclick="startRecognition('tagalogInput', 'tl-PH', 'tagalogForm')"></i>
    </div>
    <button type="submit">Translate</button>
    <button type="button" onclick="speakText('<?php echo $mangyanTranslation; ?>', 'mangyan-lang')">
        <i class="fas fa-volume-up"></i> Listen
    </button>
</form>
            <div class="result">
                <?php if ($mangyanTranslation): ?>
                    <h3>Translation Result:</h3>
                    <p><?php echo $mangyanTranslation; ?></p>
                <?php else: ?>
                    <p class="error"><?php echo $errorMessageTagalogToMangyan; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-box">
            <h2>Mangyan to Tagalog Translation</h2>
            <form id="mangyanForm" action="" method="GET">
    <div class="input-container">
        <input type="text" id="mangyanInput" name="mangyan_sentence" placeholder="Enter Mangyan sentence..." required>
        <i class="fas fa-microphone mic-icon" onclick="startRecognition('mangyanInput', 'tl-PH', 'mangyanForm')"></i>
    </div>
    <button type="submit">Translate</button>
    <button type="button" onclick="speakText('<?php echo $tagalogTranslation; ?>', 'tl-PH')">
        <i class="fas fa-volume-up"></i> Listen
    </button>
</form>
            <div class="result">
                <?php if ($tagalogTranslation): ?>
                    <h3>Translation Result:</h3>
                    <p><?php echo $tagalogTranslation; ?></p>
                <?php else: ?>
                    <p class="error"><?php echo $errorMessageMangyanToTagalog; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Translation App</p>
<p><a href="admin.php" style="    color: #006600; text-decoration: none;">Add Another Translation</a></p>
    </footer>

    <script>
        function startRecognition(inputId, lang, formId) {
            let SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                alert('Speech recognition is not supported in this browser. Try using Chrome or Edge.');
                return;
            }

            let recognition = new SpeechRecognition();
            recognition.lang = lang; // Set language based on the input
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.onresult = function(event) {
                document.getElementById(inputId).value = event.results[0][0].transcript;
                document.getElementById(formId).submit(); // Auto-submit after speech
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event);
            };

            recognition.start();
        }
        function speakText(text, lang) {
    if (!text) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'No text available to speak.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        return;
    }

    let synth = window.speechSynthesis;
    let utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = lang; // Set language dynamically
    synth.speak(utterance);
}

    </script>
</body>
</html>