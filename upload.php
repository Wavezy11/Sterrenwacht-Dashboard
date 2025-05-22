<?php
// This file will handle data uploads in the future

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["dataFile"]) && $_FILES["dataFile"]["error"] == 0) {
        $allowed = array("csv" => "text/csv", "json" => "application/json");
        $filename = $_FILES["dataFile"]["name"];
        $filetype = $_FILES["dataFile"]["type"];
        $filesize = $_FILES["dataFile"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Error: Please select a valid file format (CSV or JSON).");
        }
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            die("Error: File size is larger than the allowed limit (5MB).");
        }
    
        // Verify MIME type of the file
        if (in_array($filetype, $allowed)) {
            // Check whether file exists before uploading it
            if (file_exists("uploads/" . $filename)) {
                echo $filename . " already exists.";
            } else {
                if (!is_dir("uploads")) {
                    mkdir("uploads", 0777, true);
                }
                
                move_uploaded_file($_FILES["dataFile"]["tmp_name"], "uploads/" . $filename);
                echo "Your file was uploaded successfully.";
                
                // Process the file based on type
                if ($ext == "csv") {
                    processCSV("uploads/" . $filename);
                } else if ($ext == "json") {
                    processJSON("uploads/" . $filename);
                }
            }
        } else {
            echo "Error: There was a problem with your upload. Please try again.";
        }
    } else {
        echo "Error: " . $_FILES["dataFile"]["error"];
    }
}

// Function to process CSV files
function processCSV($filepath) {
    // This function will process CSV data in the future
    echo "<p>CSV file processed successfully.</p>";
}

// Function to process JSON files
function processJSON($filepath) {
    // This function will process JSON data in the future
    echo "<p>JSON file processed successfully.</p>";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Data - Sterrenwacht Dashboard</title>
    <style>
        :root {
            --primary-color: #1e293b;
            --secondary-color: #334155;
            --accent-color: #f59e0b;
            --text-color: #f8fafc;
            --panel-bg: #0f172a;
            --panel-border: #475569;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--primary-color);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .upload-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 2rem;
            background-color: var(--panel-bg);
            border-radius: 8px;
            border: 1px solid var(--panel-border);
        }
        
        .upload-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        label {
            font-weight: 600;
        }
        
        input[type="file"] {
            background-color: var(--secondary-color);
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid var(--panel-border);
            color: var(--text-color);
        }
        
        select {
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid var(--panel-border);
            background-color: var(--secondary-color);
            color: var(--text-color);
        }
        
        .submit-btn {
            background-color: var(--accent-color);
            color: var(--primary-color);
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        
        .submit-btn:hover {
            background-color: #d97706;
        }
        
        .instructions {
            margin-top: 2rem;
            padding: 1rem;
            background-color: var(--secondary-color);
            border-radius: 4px;
        }
        
        .instructions h3 {
            margin-bottom: 0.5rem;
        }
        
        .instructions ul {
            padding-left: 1.5rem;
        }
        
        a {
            color: var(--accent-color);
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h1>Upload Data</h1>
        <p>Upload CSV or JSON files to update the dashboard data.</p>
        
        <form class="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="dataFile">Select file:</label>
                <input type="file" name="dataFile" id="dataFile" required>
            </div>
            
            <div class="form-group">
                <label for="dataType">Data type:</label>
                <select name="dataType" id="dataType">
                    <option value="temperature">Temperatuur</option>
                    <option value="wind">Wind</option>
                    <option value="pressure">Luchtdruk</option>
                    <option value="humidity">Luchtvochtigheid</option>
                    <option value="precipitation">Neerslag</option>
                    <option value="all">Alle data</option>
                </select>
            </div>
            
            <button type="submit" class="submit-btn">Upload</button>
        </form>
        
        <div class="instructions">
            <h3>Instructies</h3>
            <ul>
                <li>Upload alleen CSV of JSON bestanden</li>
                <li>Maximale bestandsgrootte: 5MB</li>
                <li>CSV formaat: datum,waarde (bijv. 2023-05-22 14:30:00,21.5)</li>
                <li>JSON formaat: {"datum": "2023-05-22 14:30:00", "waarde": 21.5}</li>
            </ul>
        </div>
        
        <p style="margin-top: 1.5rem;"><a href="index.php">Terug naar dashboard</a></p>
    </div>
</body>
</html>
