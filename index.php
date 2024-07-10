<?php
session_start();

$_SESSION['user'] = 'PriyanshuNiranjan';

setcookie('user', 'PriyanshuNiranjan', time() + (86400 * 30), "/");
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_timeout = 30 * 60;

$api_url = "http://api.weatherstack.com/current?access_key=21905c30f7909d26e1c5f9d535320b6c&query=Puducherry";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response, true);

$temperature = $data['current']['temperature'];

$current_time = time();
$elapsed_time = $current_time - $_SESSION['start_time'];
$remaining_time = $session_timeout - $elapsed_time;

$remaining_minutes = floor($remaining_time / 60);
$remaining_seconds = $remaining_time % 60;

if ($remaining_time <= 0) {
    session_destroy();
    $remaining_minutes = 0;
    $remaining_seconds = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Vault</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f0f0f0;
        }
        .footer p {
            margin: 0;
            font-size: 14px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js"></script>
    <script defer src="app.js"></script>
</main>
</head>
<body>
    <header>
        <form id="searchForm">
            <input type="text" id="search" placeholder="Search for a movie..." class="search" />
        </form>
        <button id="submitFavoritesBtn">Submit Favorites</button>
        <button id="viewFavoritesBtn">View Favorite Movies</button>
    </header>
    <main id="main">
    </main>
    <footer class="footer">
        <p>Current Weather: <?php echo $temperature; ?>°C, Puducherry</p>
        <p id="sessionTime">Session Time Remaining: <?php echo sprintf('%02d:%02d', $remaining_minutes, $remaining_seconds); ?></p>
    </footer>
    <script>
        let i = 0;
        const ws = new WebSocket('ws://localhost:8080'); // Note the ws:// protocol and port 8080

        ws.onopen = () => {
            console.log('WebSocket connection established.');
        };

        ws.onmessage = (event) => {
            const message = event.data;
            console.log('Received:', message);
        };

        ws.onclose = () => {
            console.log('WebSocket connection closed.');
        };

        ws.onerror = (error) => {
            console.error('WebSocket error:', error);
        };

        // Notify server with a favorite movie
        function notifyServer(movie) {
            if (ws.readyState === WebSocket.OPEN) {
                ws.send(`Favorite movie Number ${i} added: ${movie}`);
                i++;
            }
        }

        // Update session time
        function updateSessionTime() {
            const sessionTimeElement = document.getElementById('sessionTime');
            let remainingTime = <?php echo $remaining_time; ?>;

            setInterval(() => {
                if (remainingTime <= 0) {
                    sessionTimeElement.textContent = 'Session Time Remaining: 00:00';
                    clearInterval();
                    return;
                }

                remainingTime--;

                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;
                sessionTimeElement.textContent = `Session Time Remaining: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        window.onload = updateSessionTime;
    </script>
</body>
</html>
