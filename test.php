<?php
// mangyan_translator.php

// Database connection
$servername = "localhost";  // Change to your database server
$username = "root";         // Change to your database username
$password = "";             // Change to your database password
$dbname = "mangyan";        // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get translation from the database
function getTranslation($word, $conn) {
    $word = $conn->real_escape_string($word);
    $sql = "SELECT english, tagalog FROM translation WHERE word = '$word' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the translation data
        $row = $result->fetch_assoc();
        return [
            'english' => $row['english'],
            'tagalog' => $row['tagalog']
        ];
    } else {
        return null; // No translation found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mangyan Keyboard Translator</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function to add letter and speak it
        function addLetter(letter) {
            document.getElementById("mangyan_text").value += letter;
            const utterance = new SpeechSynthesisUtterance(letter);
            window.speechSynthesis.speak(utterance);
        }

        // Function to backspace
        function backspace() {
            const textBox = document.getElementById("mangyan_text");
            textBox.value = textBox.value.slice(0, -1);
        }

        // Function to translate the text in the textbox
        function translateText() {
            const text = document.getElementById("mangyan_text").value;
            const words = text.split(' '); // Split text into words
            let translation = "";

            // Reset the translation area before starting
            document.getElementById("translated_text").innerHTML = "";

            // Loop through each word and fetch its translation
            words.forEach(function(word) {
                fetchTranslation(word);
            });
        }

        // Function to fetch translation from PHP
        function fetchTranslation(word) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_translation.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response) {
                        const translationDiv = document.getElementById("translated_text");
                        translationDiv.innerHTML += `
                            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                <p class="font-semibold text-lg text-gray-800">Word: <span class="text-blue-500">${word}</span></p>
                                <p class="text-gray-600">English: <span class="font-bold">${response.english}</span></p>
                                <p class="text-gray-600">Tagalog: <span class="font-bold">${response.tagalog}</span></p>
                            </div>
                        `;
                    } else {
                        document.getElementById("translated_text").innerHTML += `
                            <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-4">
                                <p class="text-gray-600">No translation found for: <span class="font-bold text-red-500">${word}</span></p>
                            </div>
                        `;
                    }
                }
            };
            xhr.send("word=" + word);
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex flex-col items-center justify-center py-8">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Mangyan Keyboard Translator</h2>
            <h3 class="text-2xl font-semibold text-center text-gray-700 mb-6">Hanuno</h3>


            <!-- Output Textbox -->
            <div class="mb-4">
                <label for="mangyan_text" class="block text-lg font-medium text-gray-600">Output:</label>
                <input type="text" id="mangyan_text" readonly class="w-full p-2 mt-2 border border-gray-300 rounded-md text-gray-700 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Virtual Keyboard -->
            <div class="mb-6">
                <h3 class="text-xl font-medium text-gray-600 mb-2">Virtual Mangyan Keyboard</h3>

                <!-- Vowels Section -->
                <div>
                    <h5 class="font-medium text-gray-600 mb-2">Vowels</h5>
                    <div class="flex space-x-4">
                        <img src="surat/vowel_a.png" onclick="addLetter('A')" class="w-12 h-12 cursor-pointer" alt="Vowel A">
                        <img src="surat/vowel_i.png" onclick="addLetter('I')" class="w-12 h-12 cursor-pointer" alt="Vowel I">
                        <img src="surat/vowel_u.png" onclick="addLetter('U')" class="w-12 h-12 cursor-pointer" alt="Vowel U">
                    </div>
                </div>
            </div>

            <!-- Backspace and Translate Buttons -->
            <div class="flex justify-between mb-6">
                <button class="bg-red-500 text-white py-2 px-4 rounded-full" onclick="backspace()">Backspace</button>
                <button class="bg-green-500 text-white py-2 px-4 rounded-full" onclick="translateText()">Translate</button>
            </div>

            <!-- Translated Text -->
            <div id="translated_text"></div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center py-4 bg-gray-200">
        <p class="text-sm text-gray-600">&copy; 2025 Mangyan Translator | All rights reserved</p>
    </div>
</body>
</html>
