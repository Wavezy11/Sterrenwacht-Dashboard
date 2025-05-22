<?php
// Function to get dummy data (this would be replaced with real data fetching later)
function getDummyData() {
    return [
        'indoor_temp' => -16.7,
        'outdoor_temp' => -3.73,
        'wind_direction' => 'Zuid zuidoost',
        'wind_speed' => 0.524,
        'wind_gust' => 1.25,
        'pressure' => 1013.5,
        'humidity' => 78,
        'precipitation' => 0,
        'last_updated' => date('Y-m-d H:i:s')
    ];
}

// Get data whether included or accessed directly
$data = getDummyData();

// Function to get weather emoji based on temperature
function getWeatherEmoji($temp) {
    if ($temp > 25) return "🔥";
    if ($temp > 15) return "😎";
    if ($temp > 5) return "😊";
    if ($temp > 0) return "🥶";
    return "❄️";
}

// Function to get wind direction emoji
function getWindDirectionEmoji($direction) {
    switch ($direction) {
        case "Noord": return "⬆️";
        case "Noord-Oost": return "↗️";
        case "Oost": return "➡️";
        case "Zuid-Oost": return "↘️";
        case "Zuid": return "⬇️";
        case "Zuid-West": return "↙️";
        case "West": return "⬅️";
        case "Noord-West": return "↖️";
        default: return "🧭";
    }
}

// Random fun facts about space
$funFacts = [
    "De zon is 100 keer groter dan de Aarde!",
    "Een dag op Venus duurt langer dan een jaar op Venus!",
    "Jupiter heeft 79 manen!",
    "De sterren die we 's nachts zien, zijn eigenlijk heel ver weg!",
    "De maan draait in ongeveer 27 dagen om de aarde!",
    "Saturnus heeft ringen die je met een telescoop kunt zien!",
    "De aarde draait met ongeveer 1600 km per uur om haar as!",
    "Licht van de zon doet er 8 minuten over om de aarde te bereiken!"
];

// Get a random fun fact
$randomFact = $funFacts[array_rand($funFacts)];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sterrenwacht Halley - Kinder Dashboard</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100vw;
            height: 100vh;
            max-width: 100vw;
            max-height: 100vh;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Comic Sans MS", "Chalkboard SE", sans-serif;
            background: linear-gradient(to bottom, #1e3a8a, #0f172a);
            color: white;
            padding: 0;
        }

        /* Container styles - FULL VIEWPORT */
        .child-container {
            width: 100vw;
            height: 100vh;
            max-width: 100vw;
            max-height: 100vh;
            margin: 0;
            padding: 20px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Header styles */
        .child-header {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border: 3px solid #3b82f6;
            width: 100%;
        }

        .child-header h1 {
            font-size: 2.5rem;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Panel grid layout - FULL WIDTH GRID */
        .child-panels {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 100%;
        }

        /* Panel styles */
        .child-panel {
            background-color: #1e3a8a;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border: 3px solid #3b82f6;
            transition: transform 0.3s ease;
        }

        .child-panel:hover {
            transform: translateY(-5px);
        }

        .child-panel h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            position: relative;
            display: inline-block;
        }

        .child-panel h2::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: #f59e0b;
            border-radius: 3px;
        }

        /* Weather panel styles */
        .weather-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            font-size: 100px;
            line-height: 1;
        }

        .weather-text {
            font-size: 1.4rem;
            margin: 15px 0;
            font-weight: bold;
            color: #f8fafc;
        }

        .weather-temp {
            font-size: 2.5rem;
            font-weight: bold;
            color: #f8fafc;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .temp-label {
            font-size: 1.2rem;
            display: block;
            color: #93c5fd;
        }

        /* Sky panel styles */
        .sky-visual {
            width: 100%;
            height: 200px;
            background-color: #0f172a;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            border: 2px solid #3b82f6;
        }

        .moon {
            width: 60px;
            height: 60px;
            background-color: #f1f5f9;
            border-radius: 50%;
            position: absolute;
            top: 30px;
            left: 40px;
            box-shadow: 0 0 20px rgba(241, 245, 249, 0.7);
        }

        .stars {
            width: 100%;
            height: 100%;
            position: absolute;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background-color: white;
            border-radius: 50%;
        }

        .planet {
            position: absolute;
            border-radius: 50%;
        }

        .mars {
            width: 30px;
            height: 30px;
            background-color: #ef4444;
            top: 50px;
            right: 60px;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.7);
        }

        /* Photo panel styles */
        .photo-container {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            border: 3px solid #f59e0b;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.5);
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Facts panel styles */
        .fact-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .fact-icon {
            width: 80px;
            height: 80px;
            font-size: 70px;
            line-height: 1;
        }

        .fact-content p {
            font-size: 1.3rem;
            font-weight: bold;
            color: #f8fafc;
            text-align: center;
            line-height: 1.4;
        }

        .planet-icons {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 15px;
        }

        .planet-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .planet-icon img, .planet-icon span {
            font-size: 40px;
            margin-bottom: 5px;
        }

        .planet-icon span {
            font-size: 1rem;
            color: #93c5fd;
        }

        .telescope-icon {
            width: 60px;
            height: 60px;
            margin-top: 15px;
            font-size: 50px;
        }

        /* Weather data panel */
        .weather-data {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            width: 100%;
        }

        .weather-data-item {
            background-color: #2563eb;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .weather-data-icon {
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .weather-data-label {
            font-size: 0.9rem;
            color: #bfdbfe;
        }

        .weather-data-value {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Button styles */
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f59e0b;
            color: #0f172a;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #d97706;
            transform: scale(1.05);
        }

        /* Animation keyframes */
        @keyframes twinkle {
            0% { opacity: 0.2; }
            50% { opacity: 1; }
            100% { opacity: 0.2; }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Apply animations */
        .weather-icon, .fact-icon, .telescope-icon {
            animation: float 6s ease-in-out infinite;
        }

        .moon, .mars {
            animation: float 8s ease-in-out infinite;
        }

        /* Responsive styles */
        @media (max-width: 1200px) {
            .child-panels {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .child-panels {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="child-container">
        <header class="child-header">
            <h1>STERRENWACHT HALLEY</h1>
        </header>
        
        <div class="child-panels">
            <div class="child-panel weather">
                <h2>Het weer</h2>
                <div class="weather-icon">
                    <?php echo getWeatherEmoji($data['outdoor_temp']); ?>
                </div>
                <p class="weather-text">Goed weer om sterren te kijken!</p>
                <div class="weather-temp">
                    <span class="temp-value"><?php echo number_format($data['outdoor_temp'], 1); ?>°C</span>
                    <span class="temp-label">buiten</span>
                </div>
            </div>
            
            <div class="child-panel sky">
                <h2>De sterrenhemel van vanavond</h2>
                <div class="sky-visual">
                    <div class="moon"></div>
                    <div class="stars"></div>
                    <div class="planet mars"></div>
                </div>
                <p class="weather-text">Kijk omhoog en ontdek de sterren!</p>
            </div>
            
            <div class="child-panel photo">
                <h2>Astrofoto van de week</h2>
                <div class="photo-container">
                    <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiB2aWV3Qm94PSIwIDAgMzAwIDMwMCI+CiAgPHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiMxMTExMTEiLz4KICA8Y2lyY2xlIGN4PSIxNTAiIGN5PSIxNTAiIHI9IjEwMCIgZmlsbD0iI2YxZjVmOSIvPgogIDxjaXJjbGUgY3g9IjEyMCIgY3k9IjEwMCIgcj0iMjAiIGZpbGw9IiM5NDk0OTQiLz4KICA8Y2lyY2xlIGN4PSIxODAiIGN5PSIxNzAiIHI9IjMwIiBmaWxsPSIjOTQ5NDk0Ii8+CiAgPGNpcmNsZSBjeD0iODAiIGN5PSIxODAiIHI9IjE1IiBmaWxsPSIjOTQ5NDk0Ii8+Cjwvc3ZnPg==" alt="De maan">
                </div>
                <p>Dit is de maan!</p>
            </div>
            
            <div class="child-panel facts">
                <h2>Wist je dat...?</h2>
                <div class="fact-content">
                    <div class="fact-icon">
                        🌞
                    </div>
                    <p><?php echo $randomFact; ?></p>
                    <div class="planet-icons">
                        <div class="planet-icon">
                            <span>🌞</span>
                            <span>Zon</span>
                        </div>
                        <div class="planet-icon">
                            <span>🌎</span>
                            <span>Aarde</span>
                        </div>
                        <div class="planet-icon">
                            <span>🔴</span>
                            <span>Mars</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="child-panel">
                <h2>Weer Metingen</h2>
                <div class="weather-data">
                    <div class="weather-data-item">
                        <div class="weather-data-icon">🌡️</div>
                        <div class="weather-data-label">Temperatuur</div>
                        <div class="weather-data-value"><?php echo number_format($data['outdoor_temp'], 1); ?>°C</div>
                    </div>
                    <div class="weather-data-item">
                        <div class="weather-data-icon">💨</div>
                        <div class="weather-data-label">Wind</div>
                        <div class="weather-data-value"><?php echo number_format($data['wind_speed'], 1); ?> km/h</div>
                    </div>
                    <div class="weather-data-item">
                        <div class="weather-data-icon"><?php echo getWindDirectionEmoji($data['wind_direction']); ?></div>
                        <div class="weather-data-label">Windrichting</div>
                        <div class="weather-data-value"><?php echo $data['wind_direction']; ?></div>
                    </div>
                    <div class="weather-data-item">
                        <div class="weather-data-icon">☔</div>
                        <div class="weather-data-label">Neerslag</div>
                        <div class="weather-data-value"><?php echo number_format($data['precipitation'], 1); ?> mm</div>
                    </div>
                </div>
            </div>

            <div class="child-panel">
                <h2>Sterrenwacht Halley</h2>
                <div class="fact-content">
                    <div class="fact-icon">
                        🏛️
                    </div>
                    <p>Sterrenwacht Halley is een plek waar je alles kunt leren over sterren, planeten en het heelal!</p>
                    <div class="telescope-icon">
                        🔭
                    </div>
                    <a href="#" class="back-button">Terug naar hoofdpagina</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create stars animation
        function createStars() {
            const starsContainer = document.querySelector(".stars");
            if (!starsContainer) return;

            for (let i = 0; i < 50; i++) {
                const star = document.createElement("div");
                star.classList.add("star");
                star.style.width = Math.random() * 2 + 1 + "px";
                star.style.height = star.style.width;
                star.style.top = Math.random() * 100 + "%";
                star.style.left = Math.random() * 100 + "%";
                star.style.animation = `twinkle ${Math.random() * 3 + 1}s infinite`;
                starsContainer.appendChild(star);
            }
        }

        // Run when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            createStars();
            
            // Add click event to the back button
            const backButton = document.querySelector(".back-button");
            if (backButton) {
                backButton.addEventListener("click", function(e) {
                    e.preventDefault();
                    window.location.href = "index.php";
                });
            }
        });
    </script>
</body>
</html>
