<?php
// Simple authentication
session_start();

// Check if user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // User is logged in, continue to admin panel
} else {
    // Check login credentials
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
        // This is a simple example - in a real application, use proper authentication
        if ($_POST['username'] === 'admin' && $_POST['password'] === 'password') {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_POST['username'];
        } else {
            $error = "Ongeldige gebruikersnaam of wachtwoord";
        }
    }
    
    // If not logged in, show login form
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        ?>
        <!DOCTYPE html>
        <html lang="nl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Login - Sterrenwacht Dashboard</title>
            <link rel="stylesheet" href="css/style.css">
            <style>
                .login-container {
                    max-width: 400px;
                    margin: 100px auto;
                    padding: 2rem;
                    background-color: var(--panel-bg);
                    border-radius: 8px;
                    border: 1px solid var(--panel-border);
                }
                
                .login-form {
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
                
                input[type="text"], input[type="password"] {
                    padding: 0.75rem;
                    border-radius: 4px;
                    border: 1px solid var(--panel-border);
                    background-color: var(--secondary-color);
                    color: var(--text-color);
                }
                
                .login-btn {
                    background-color: var(--accent-color);
                    color: var(--primary-color);
                    border: none;
                    padding: 0.75rem 1rem;
                    border-radius: 4px;
                    cursor: pointer;
                    font-weight: 600;
                    transition: background-color 0.2s;
                }
                
                .login-btn:hover {
                    background-color: #d97706;
                }
                
                .error {
                    color: var(--danger-color);
                    margin-bottom: 1rem;
                }
            </style>
        </head>
        <body>
            <div class="login-container">
                <h1>Admin Login</h1>
                
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form class="login-form" action="admin.php" method="post">
                    <div class="form-group">
                        <label for="username">Gebruikersnaam:</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Wachtwoord:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    
                    <button type="submit" class="login-btn">Inloggen</button>
                </form>
                
                <p style="margin-top: 1.5rem;"><a href="index.php" style="color: var(--accent-color);">Terug naar dashboard</a></p>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sterrenwacht Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: var(--secondary-color);
            border-radius: 8px;
        }
        
        .admin-nav {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .nav-item {
            padding: 0.75rem 1.5rem;
            background-color: var(--panel-bg);
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .nav-item:hover, .nav-item.active {
            background-color: var(--accent-color);
            color: var(--primary-color);
        }
        
        .admin-content {
            background-color: var(--panel-bg);
            border-radius: 8px;
            padding: 2rem;
            min-height: 500px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th, .data-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid var(--panel-border);
        }
        
        .data-table th {
            background-color: var(--secondary-color);
        }
        
        .action-btn {
            background-color: var(--accent-color);
            color: var(--primary-color);
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.2s;
        }
        
        .action-btn:hover {
            background-color: #d97706;
        }
        
        .action-btn.delete {
            background-color: var(--danger-color);
        }
        
        .action-btn.delete:hover {
            background-color: #b91c1c;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        input, select, textarea {
            padding: 0.75rem;
            border-radius: 4px;
            border: 1px solid var(--panel-border);
            background-color: var(--secondary-color);
            color: var(--text-color);
        }
        
        .submit-btn {
            grid-column: span 2;
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
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Panel</h1>
            <div>
                <span>Ingelogd als: <?php echo $_SESSION['username']; ?></span>
                <a href="admin.php?logout=1" style="margin-left: 1rem; color: var(--accent-color);">Uitloggen</a>
            </div>
        </div>
        
        <div class="admin-nav">
            <div class="nav-item active" data-tab="dashboard">Dashboard</div>
            <div class="nav-item" data-tab="data">Data Beheren</div>
            <div class="nav-item" data-tab="settings">Instellingen</div>
            <div class="nav-item" data-tab="users">Gebruikers</div>
        </div>
        
        <div class="admin-content">
            <!-- Dashboard Tab -->
            <div class="tab-content" id="dashboard-tab">
                <h2>Dashboard Overzicht</h2>
                <p>Welkom bij het admin panel van het Sterrenwacht Dashboard.</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; margin-top: 2rem;">
                    <div style="background-color: var(--secondary-color); padding: 1.5rem; border-radius: 8px;">
                        <h3>Totaal Metingen</h3>
                        <p style="font-size: 2rem; font-weight: bold;">1,245</p>
                    </div>
                    
                    <div style="background-color: var(--secondary-color); padding: 1.5rem; border-radius: 8px;">
                        <h3>Laatste Update</h3>
                        <p style="font-size: 1.2rem;"><?php echo date('d-m-Y H:i:s'); ?></p>
                    </div>
                    
                    <div style="background-color: var(--secondary-color); padding: 1.5rem; border-radius: 8px;">
                        <h3>Systeem Status</h3>
                        <p style="font-size: 1.2rem; color: var(--success-color);">Online</p>
                    </div>
                    
                    <div style="background-color: var(--secondary-color); padding: 1.5rem; border-radius: 8px;">
                        <h3>Sensoren Actief</h3>
                        <p style="font-size: 2rem; font-weight: bold;">8/8</p>
                    </div>
                </div>
                
                <div style="margin-top: 2rem;">
                    <h3>Snelle Acties</h3>
                    <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                        <a href="upload.php" class="action-btn">Upload Data</a>
                        <a href="index.php" class="action-btn">Bekijk Dashboard</a>
                        <button class="action-btn">Ververs Sensoren</button>
                        <button class="action-btn">Backup Data</button>
                    </div>
                </div>
            </div>
            
            <!-- Data Tab -->
            <div class="tab-content" id="data-tab" style="display: none;">
                <h2>Data Beheren</h2>
                
                <div style="margin: 1.5rem 0; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <label for="data-filter">Filter op type: </label>
                        <select id="data-filter" style="padding: 0.5rem; margin-left: 0.5rem;">
                            <option value="all">Alle data</option>
                            <option value="temperature">Temperatuur</option>
                            <option value="wind">Wind</option>
                            <option value="pressure">Luchtdruk</option>
                            <option value="humidity">Luchtvochtigheid</option>
                            <option value="precipitation">Neerslag</option>
                        </select>
                    </div>
                    
                    <button class="action-btn">Nieuwe Meting Toevoegen</button>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Datum</th>
                            <th>Type</th>
                            <th>Waarde</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2023-05-22 14:30:00</td>
                            <td>Temperatuur</td>
                            <td>-16.7 °C</td>
                            <td>
                                <button class="action-btn">Bewerken</button>
                                <button class="action-btn delete">Verwijderen</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2023-05-22 14:30:00</td>
                            <td>Luchtdruk</td>
                            <td>1013.5 hPa</td>
                            <td>
                                <button class="action-btn">Bewerken</button>
                                <button class="action-btn delete">Verwijderen</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>2023-05-22 14:30:00</td>
                            <td>Wind</td>
                            <td>0.524 km/h</td>
                            <td>
                                <button class="action-btn">Bewerken</button>
                                <button class="action-btn delete">Verwijderen</button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>2023-05-22 14:30:00</td>
                            <td>Luchtvochtigheid</td>
                            <td>78 %</td>
                            <td>
                                <button class="action-btn">Bewerken</button>
                                <button class="action-btn delete">Verwijderen</button>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>2023-05-22 14:30:00</td>
                            <td>Neerslag</td>
                            <td>0 mm</td>
                            <td>
                                <button class="action-btn">Bewerken</button>
                                <button class="action-btn delete">Verwijderen</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Settings Tab -->
            <div class="tab-content" id="settings-tab" style="display: none;">
                <h2>Dashboard Instellingen</h2>
                
                <form class="form-grid" style="margin-top: 1.5rem;">
                    <div class="form-group">
                        <label for="site-title">Dashboard Titel</label>
                        <input type="text" id="site-title" value="Sterrenwacht Dashboard">
                    </div>
                    
                    <div class="form-group">
                        <label for="refresh-rate">Verversingsinterval (seconden)</label>
                        <input type="number" id="refresh-rate" value="300">
                    </div>
                    
                    <div class="form-group">
                        <label for="theme">Thema</label>
                        <select id="theme">
                            <option value="dark">Donker</option>
                            <option value="light">Licht</option>
                            <option value="auto">Automatisch (systeem)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="language">Taal</label>
                        <select id="language">
                            <option value="nl">Nederlands</option>
                            <option value="en">Engels</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="temp-unit">Temperatuur Eenheid</label>
                        <select id="temp-unit">
                            <option value="celsius">Celsius (°C)</option>
                            <option value="fahrenheit">Fahrenheit (°F)</option>
                            <option value="kelvin">Kelvin (K)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="wind-unit">Wind Eenheid</label>
                        <select id="wind-unit">
                            <option value="kmh">Kilometer per uur (km/h)</option>
                            <option value="ms">Meter per seconde (m/s)</option>
                            <option value="mph">Mijl per uur (mph)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="date-format">Datum Formaat</label>
                        <select id="date-format">
                            <option value="d-m-Y H:i:s">DD-MM-YYYY HH:MM:SS</option>
                            <option value="Y-m-d H:i:s">YYYY-MM-DD HH:MM:SS</option>
                            <option value="m/d/Y h:i:s A">MM/DD/YYYY hh:MM:SS AM/PM</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="chart-days">Aantal Dagen in Grafieken</label>
                        <input type="number" id="chart-days" value="7">
                    </div>
                    
                    <button type="submit" class="submit-btn">Instellingen Opslaan</button>
                </form>
            </div>
            
            <!-- Users Tab -->
            <div class="tab-content" id="users-tab" style="display: none;">
                <h2>Gebruikers Beheren</h2>
                
                <div style="margin: 1.5rem 0; text-align: right;">
                    <button class="action-btn">Nieuwe Gebruiker Toevoegen</button>
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gebruikersnaam</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Laatste Login</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>admin</td>
                            <td>admin@sterrenwacht.nl</td>
                            <td>Administrator</td>
                            <td><?php echo date('d-m-Y H:i:s'); ?></td>
                            <td>
                                <button class="action-btn">Bewerken</button>
                                <button class="action-btn delete">Verwijderen</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>gebruiker</td>
                            <td>gebruiker@sterrenwacht.nl</td>
                            <td>Gebruiker</td>
                            <td>21-05-2023 10:15:22</td>
                            <td>
                                <button class="action-btn">Bewerken</button>
                                <button class="action-btn delete">Verwijderen</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        // Tab navigation
        const navItems = document.querySelectorAll('.nav-item');
        const tabContents = document.querySelectorAll('.tab-content');
        
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all nav items
                navItems.forEach(nav => nav.classList.remove('active'));
                
                // Add active class to clicked nav item
                this.classList.add('active');
                
                // Hide all tab contents
                tabContents.forEach(tab => tab.style.display = 'none');
                
                // Show the selected tab content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).style.display = 'block';
            });
        });
        
        // Handle logout
        if (window.location.search.includes('logout=1')) {
            // In a real application, you would destroy the session here
            window.location.href = 'admin.php';
        }
    </script>
</body>
</html>
