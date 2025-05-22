import { Chart } from "@/components/ui/chart"
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
    } else {
      toggleButton.textContent = "Kindervriendelijke Weergave"
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
  const temperatureCtx = document.getElementById("temperature-chart").getContext("2d")
  const temperatureChart = new Chart(temperatureCtx, {
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

  // Wind Chart
  const windCtx = document.getElementById("wind-chart").getContext("2d")
  const windChart = new Chart(windCtx, {
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

  // Pressure Chart
  const pressureCtx = document.getElementById("pressure-chart").getContext("2d")
  const pressureChart = new Chart(pressureCtx, {
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

  // Humidity Chart
  const humidityCtx = document.getElementById("humidity-chart").getContext("2d")
  const humidityChart = new Chart(humidityCtx, {
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

  // Precipitation Chart
  const precipitationCtx = document.getElementById("precipitation-chart").getContext("2d")
  const precipitationChart = new Chart(precipitationCtx, {
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

  // Create stars animation for child dashboard
  function createStars() {
    const starsContainer = document.querySelector(".stars")
    if (!starsContainer) return

    for (let i = 0; i < 50; i++) {
      const star = document.createElement("div")
      star.classList.add("star")
      star.style.width = "2px"
      star.style.height = "2px"
      star.style.backgroundColor = "white"
      star.style.borderRadius = "50%"
      star.style.position = "absolute"
      star.style.top = Math.random() * 100 + "%"
      star.style.left = Math.random() * 100 + "%"
      star.style.animation = `twinkle ${Math.random() * 3 + 1}s infinite`
      starsContainer.appendChild(star)
    }
  }

  createStars()

  // Add CSS animation for twinkling stars
  const style = document.createElement("style")
  style.textContent = `
        @keyframes twinkle {
            0% { opacity: 0.2; }
            50% { opacity: 1; }
            100% { opacity: 0.2; }
        }
    `
  document.head.appendChild(style)
})
