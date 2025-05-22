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

$data = getDummyData();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sterrenwacht Dashboard</title>
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
          --chart-grid: #475569;
          --chart-line: #38bdf8;
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
        
        .dashboard-container {
          max-width: 1800px;
          margin: 0 auto;
          padding: 1rem;
        }
        
        header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 1.5rem;
          padding: 1rem;
          background-color: var(--secondary-color);
          border-radius: 8px;
        }
        
        header h1 {
          font-size: 1.8rem;
          font-weight: 600;
        }
        
        .controls {
          display: flex;
          align-items: center;
          gap: 1rem;
        }
        
        button {
          background-color: var(--accent-color);
          color: var(--primary-color);
          border: none;
          padding: 0.5rem 1rem;
          border-radius: 4px;
          cursor: pointer;
          font-weight: 600;
          transition: background-color 0.2s;
        }
        
        button:hover {
          background-color: #d97706;
        }
        
        .last-updated {
          font-size: 0.9rem;
          opacity: 0.8;
        }
        
        .dashboard {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          grid-auto-rows: minmax(300px, auto);
          gap: 1rem;
        }
        
        .panel {
          background-color: var(--panel-bg);
          border: 1px solid var(--panel-border);
          border-radius: 8px;
          padding: 1rem;
          display: flex;
          flex-direction: column;
        }
        
        .panel h2 {
          font-size: 1.2rem;
          margin-bottom: 1rem;
          padding-bottom: 0.5rem;
          border-bottom: 1px solid var(--panel-border);
        }
        
        .temperature {
          grid-column: 1;
          grid-row: 1 / span 2;
        }
        
        .wind {
          grid-column: 2;
          grid-row: 1 / span 2;
        }
        
        .pressure {
          grid-column: 3;
          grid-row: 1;
        }
        
        .humidity {
          grid-column: 3;
          grid-row: 2;
        }
        
        .precipitation {
          grid-column: 1;
          grid-row: 3;
        }
        
        .info {
          grid-column: 2 / span 2;
          grid-row: 3;
        }
        
        .gauge-container {
          display: flex;
          justify-content: space-around;
          margin-bottom: 1rem;
        }
        
        .gauge {
          text-align: center;
          position: relative;
          width: 120px;
          height: 120px;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          border-radius: 50%;
          background: linear-gradient(to right, #ef4444, #f59e0b, #10b981);
          padding: 5px;
        }
        
        .gauge::before {
          content: "";
          position: absolute;
          top: 5px;
          left: 5px;
          right: 5px;
          bottom: 5px;
          background-color: var(--panel-bg);
          border-radius: 50%;
          z-index: 0;
        }
        
        .gauge-value {
          position: relative;
          z-index: 1;
          font-size: 1.5rem;
          font-weight: bold;
        }
        
        .gauge-label {
          position: relative;
          z-index: 1;
          font-size: 0.8rem;
          margin-top: 0.5rem;
        }
        
        .chart-container {
          flex: 1;
          position: relative;
          min-height: 150px;
        }
        
        .wind-info {
          display: flex;
          justify-content: space-around;
          margin-bottom: 1rem;
        }
        
        .wind-direction,
        .wind-speed {
          text-align: center;
        }
        
        .direction-compass {
          width: 80px;
          height: 80px;
          border-radius: 50%;
          border: 2px solid var(--panel-border);
          position: relative;
          margin: 0.5rem auto;
        }
        
        .compass-arrow {
          position: absolute;
          top: 50%;
          left: 50%;
          width: 4px;
          height: 40px;
          background-color: var(--accent-color);
          transform-origin: bottom center;
          transform: translate(-50%, -100%);
        }
        
        .compass-arrow::after {
          content: "";
          position: absolute;
          top: 0;
          left: 50%;
          transform: translateX(-50%);
          border-left: 8px solid transparent;
          border-right: 8px solid transparent;
          border-bottom: 12px solid var(--accent-color);
        }
        
        .pressure-value,
        .humidity-value,
        .precipitation-value {
          font-size: 2rem;
          font-weight: bold;
          text-align: center;
          margin: 1rem 0;
        }
        
        .info-content {
          padding: 1rem;
          line-height: 1.8;
        }
        
        /* Hide elements */
        .hidden {
          display: none;
        }
        
        /* Child dashboard iframe - FULL VIEWPORT */
        .child-iframe {
          width: 100vw;
          height: 100vh;
          border: none;
          overflow: hidden;
          position: fixed;
          top: 0;
          left: 0;
          margin: 0;
          padding: 0;
        }
        
        /* Responsive Styles */
        @media (max-width: 1200px) {
          .dashboard {
            grid-template-columns: repeat(2, 1fr);
          }
        
          .temperature {
            grid-column: 1;
            grid-row: 1 / span 2;
          }
        
          .wind {
            grid-column: 2;
            grid-row: 1 / span 2;
          }
        
          .pressure {
            grid-column: 1;
            grid-row: 3;
          }
        
          .humidity {
            grid-column: 2;
            grid-row: 3;
          }
        
          .precipitation {
            grid-column: 1;
            grid-row: 4;
          }
        
          .info {
            grid-column: 2;
            grid-row: 4;
          }
        }
        
        @media (max-width: 768px) {
          .dashboard {
            grid-template-columns: 1fr;
          }
        
          .temperature,
          .wind,
          .pressure,
          .humidity,
          .precipitation,
          .info {
            grid-column: 1;
            grid-row: auto;
          }
        
          header {
            flex-direction: column;
            gap: 1rem;
          }
        
          .gauge-container {
            flex-direction: column;
            align-items: center;
            gap: 1rem;
          }
        
          .wind-info {
            flex-direction: column;
            gap: 1rem;
          }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Sterrenwacht Dashboard</h1>
            <div class="controls">
                <button id="toggle-view">Kindervriendelijke Weergave</button>
                <span class="last-updated">Laatste update: <?php echo $data['last_updated']; ?></span>
            </div>
        </header>
        
        <main id="adult-dashboard" class="dashboard">
            <div class="panel temperature">
                <h2>Temperatuur</h2>
                <div class="gauge-container">
                    <div class="gauge" id="indoor-temp-gauge">
                        <div class="gauge-value">
                            <span class="value"><?php echo $data['indoor_temp']; ?></span>
                            <span class="unit">°C</span>
                        </div>
                        <div class="gauge-label">Binnen Temperatuur</div>
                    </div>
                    <div class="gauge" id="outdoor-temp-gauge">
                        <div class="gauge-value">
                            <span class="value"><?php echo $data['outdoor_temp']; ?></span>
                            <span class="unit">°C</span>
                        </div>
                        <div class="gauge-label">Buiten Temperatuur</div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="temperature-chart"></canvas>
                </div>
            </div>
            
            <div class="panel wind">
                <h2>Wind</h2>
                <div class="wind-info">
                    <div class="wind-direction">
                        <div class="direction-label">Windrichting</div>
                        <div class="direction-value"><?php echo $data['wind_direction']; ?></div>
                        <div class="direction-compass">
                            <div class="compass-arrow" style="transform: rotate(145deg)"></div>
                        </div>
                    </div>
                    <div class="wind-speed">
                        <div class="speed-label">Windsnelheid</div>
                        <div class="speed-value"><?php echo $data['wind_speed']; ?> km/h</div>
                        <div class="gust-label">Windstoten</div>
                        <div class="gust-value"><?php echo $data['wind_gust']; ?> km/h</div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="wind-chart"></canvas>
                </div>
            </div>
            
            <div class="panel pressure">
                <h2>Luchtdruk</h2>
                <div class="pressure-value"><?php echo $data['pressure']; ?> hPa</div>
                <div class="chart-container">
                    <canvas id="pressure-chart"></canvas>
                </div>
            </div>
            
            <div class="panel humidity">
                <h2>Luchtvochtigheid</h2>
                <div class="humidity-value"><?php echo $data['humidity']; ?>%</div>
                <div class="chart-container">
                    <canvas id="humidity-chart"></canvas>
                </div>
            </div>
            
            <div class="panel precipitation">
                <h2>Neerslag</h2>
                <div class="precipitation-value"><?php echo $data['precipitation']; ?> mm</div>
                <div class="chart-container">
                    <canvas id="precipitation-chart"></canvas>
                </div>
            </div>
            
            <div class="panel info">
                <h2>Informatie</h2>
                <div class="info-content">
                    <p>Dit dashboard toont real-time weergegevens van de sterrenwacht.</p>
                    <p>De gegevens worden elke 5 minuten bijgewerkt.</p>
                </div>
            </div>
        </main>
        
        <main id="child-dashboard" class="dashboard hidden">
            <iframe src="child-dashboard.php" class="child-iframe"></iframe>
        </main>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Toggle between adult and child dashboard
      const toggleButton = document.getElementById("toggle-view")
      const adultDashboard = document.getElementById("adult-dashboard")
      const childDashboard = document.getElementById("child-dashboard")

      toggleButton.addEventListener("click", () => {
        adultDashboard.classList.toggle("hidden")
        childDashboard.classList.toggle("hidden")

        if (adultDashboard.classList.contains("hidden")) {
          toggleButton.textContent = "Standaard Weergave"
          // Remove any body padding when showing child dashboard
          document.body.style.padding = "0";
          document.body.style.margin = "0";
          document.body.style.overflow = "hidden";
        } else {
          toggleButton.textContent = "Kindervriendelijke Weergave"
          // Restore normal body styling
          document.body.style.padding = "";
          document.body.style.margin = "";
          document.body.style.overflow = "";
        }
      })

      // Generate random data for charts
      function generateRandomData(min, max, count) {
        const data = []
        for (let i = 0; i < count; i++) {
          data.push(Math.random() * (max - min) + min)
        }
        return data
      }

      function generateTimeLabels(count) {
        const labels = []
        const now = new Date()

        for (let i = count - 1; i >= 0; i--) {
          const time = new Date(now - i * 30 * 60000) // 30 minutes intervals
          labels.push(time.getHours() + ":" + (time.getMinutes() < 10 ? "0" : "") + time.getMinutes())
        }

        return labels
      }

      const timeLabels = generateTimeLabels(24)

      // Temperature Chart
      const temperatureCtx = document.getElementById("temperature-chart")
      if (temperatureCtx) {
        const temperatureChart = new Chart(temperatureCtx.getContext("2d"), {
          type: "line",
          data: {
            labels: timeLabels,
            datasets: [
              {
                label: "Binnen Temperatuur",
                data: generateRandomData(-18, -15, 24),
                borderColor: "#ef4444",
                backgroundColor: "rgba(239, 68, 68, 0.1)",
                tension: 0.4,
                fill: true,
              },
              {
                label: "Buiten Temperatuur",
                data: generateRandomData(-5, -2, 24),
                borderColor: "#3b82f6",
                backgroundColor: "rgba(59, 130, 246, 0.1)",
                tension: 0.4,
                fill: true,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                },
              },
              x: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                  maxRotation: 45,
                  minRotation: 45,
                },
              },
            },
            plugins: {
              legend: {
                labels: {
                  color: "#f8fafc",
                },
              },
            },
          },
        })
      }

      // Wind Chart
      const windCtx = document.getElementById("wind-chart")
      if (windCtx) {
        const windChart = new Chart(windCtx.getContext("2d"), {
          type: "line",
          data: {
            labels: timeLabels,
            datasets: [
              {
                label: "Windsnelheid (km/h)",
                data: generateRandomData(0, 2, 24),
                borderColor: "#10b981",
                backgroundColor: "rgba(16, 185, 129, 0.1)",
                tension: 0.4,
                fill: true,
              },
              {
                label: "Windstoten (km/h)",
                data: generateRandomData(0.5, 3, 24),
                borderColor: "#f59e0b",
                backgroundColor: "rgba(245, 158, 11, 0.1)",
                tension: 0.4,
                fill: true,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                },
              },
              x: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                  maxRotation: 45,
                  minRotation: 45,
                },
              },
            },
            plugins: {
              legend: {
                labels: {
                  color: "#f8fafc",
                },
              },
            },
          },
        })
      }

      // Pressure Chart
      const pressureCtx = document.getElementById("pressure-chart")
      if (pressureCtx) {
        const pressureChart = new Chart(pressureCtx.getContext("2d"), {
          type: "line",
          data: {
            labels: timeLabels,
            datasets: [
              {
                label: "Luchtdruk (hPa)",
                data: generateRandomData(1010, 1020, 24),
                borderColor: "#8b5cf6",
                backgroundColor: "rgba(139, 92, 246, 0.1)",
                tension: 0.4,
                fill: true,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                },
              },
              x: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                  maxRotation: 45,
                  minRotation: 45,
                },
              },
            },
            plugins: {
              legend: {
                labels: {
                  color: "#f8fafc",
                },
              },
            },
          },
        })
      }

      // Humidity Chart
      const humidityCtx = document.getElementById("humidity-chart")
      if (humidityCtx) {
        const humidityChart = new Chart(humidityCtx.getContext("2d"), {
          type: "line",
          data: {
            labels: timeLabels,
            datasets: [
              {
                label: "Luchtvochtigheid (%)",
                data: generateRandomData(65, 85, 24),
                borderColor: "#06b6d4",
                backgroundColor: "rgba(6, 182, 212, 0.1)",
                tension: 0.4,
                fill: true,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                },
              },
              x: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                  maxRotation: 45,
                  minRotation: 45,
                },
              },
            },
            plugins: {
              legend: {
                labels: {
                  color: "#f8fafc",
                },
              },
            },
          },
        })
      }

      // Precipitation Chart
      const precipitationCtx = document.getElementById("precipitation-chart")
      if (precipitationCtx) {
        const precipitationChart = new Chart(precipitationCtx.getContext("2d"), {
          type: "bar",
          data: {
            labels: timeLabels,
            datasets: [
              {
                label: "Neerslag (mm)",
                data: generateRandomData(0, 0.5, 24),
                backgroundColor: "#0ea5e9",
                borderColor: "#0284c7",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                },
              },
              x: {
                grid: {
                  color: "rgba(71, 85, 105, 0.2)",
                },
                ticks: {
                  color: "#f8fafc",
                  maxRotation: 45,
                  minRotation: 45,
                },
              },
            },
            plugins: {
              legend: {
                labels: {
                  color: "#f8fafc",
                },
              },
            },
          },
        })
      }
    })
    </script>
</body>
</html>
