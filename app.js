const apiKey = '35c6e80d6bad0abe525432fcce1ca69f';
let favMovies = [];

// Initialize event listeners on DOM content load
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('searchForm').addEventListener('keyup', handleSearch);
    document.getElementById('submitFavoritesBtn').addEventListener('click', openForm);
    document.getElementById('viewFavoritesBtn').addEventListener('click', () => {
        window.location.href = 'display_favorites.php';
    });
});

// Handle search input and fetch movies from API
function handleSearch(event) {
    const query = event.target.value.trim();
    if (query.length > 2) {
        fetchMovies(query);
    }
}

// Fetch movies from the API based on the search query
function fetchMovies(query) {
    axios.get(`https://api.themoviedb.org/3/search/movie?api_key=${apiKey}&query=${encodeURIComponent(query)}`)
        .then(response => {
            displayResults(response.data.results);
        })
        .catch(error => {
            console.error('Error fetching search results:', error);
            alert('Error fetching search results. Please try again.');
        });
}

// Display movie search results
function displayResults(movies) {
    const main = document.getElementById('main');
    main.innerHTML = '';
    movies.forEach(movie => {
        const movieDiv = document.createElement('div');
        movieDiv.className = 'movie';
        movieDiv.innerHTML = `
            <h3>${escapeHtml(movie.title)}</h3>
            <button onclick="addFavorite('${escapeHtml(movie.title)}')">Add to Favorites</button>
        `;
        main.appendChild(movieDiv);
    });
    handleSubmit() 
}

// Add movie to favorites with a limit of 3 movies
function addFavorite(movie) {
    if (favMovies.includes(movie)) {
        alert('This movie is already in your favorites.');
        return;
    }
    if (favMovies.length < 3) {
        favMovies.push(movie);
        localStorage.setItem('favMovies', JSON.stringify(favMovies));
        alert('Movie added to favorites: ' + movie);
        
        // Notify the WebSocket server
        notifyServer(movie);
    } else {
        alert('You can only add up to 3 favorite movies.');
    }
}


// Open form for submitting favorites
function openForm() {
    const name = prompt('Enter your name:');
    const regno = prompt('Enter your registration number:');

    if (validateInputs(name, regno)) {
        submitForm(name, regno);
    } else {
        alert('Please enter valid name, registration number, and at least one favorite movie.');
    }
}

// Validate user inputs
function validateInputs(name, regno) {
    return name && regno && favMovies.length > 0;
}

// Submit the form with user details and favorite movies
function submitForm(name, regno) {
    const formData = new FormData();
    formData.append('name', name);
    formData.append('regno', regno);
    formData.append('favmovie1', favMovies[0] || '');
    formData.append('favmovie2', favMovies[1] || '');
    formData.append('favmovie3', favMovies[2] || '');

    axios.post('process_form.php', formData)
        .then(response => {
            alert('Favorite movies and details saved successfully!');
            const userEmail = prompt('Enter your email to receive a confirmation:');
            if (userEmail) {
                sendConfirmationEmail(userEmail);
            }
        })
        .catch(error => {
            console.error('Error saving data:', error);
            alert('Error saving data. Please try again.');
        });
}

// Send confirmation email to the user
function sendConfirmationEmail(email) {
    axios.post('send_email.php', { email })
        .then(response => {
            alert('Confirmation email sent successfully!');
        })
        .catch(error => {
            console.error('Error sending email:', error);
            alert('Failed to send confirmation email.');
        });
}

// Escape HTML to prevent XSS attacks
function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function sanitizeInput(input) {
    // Replace < and > characters with HTML entities
    return input.replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function validateInput(input) {
    // Example validation: Check if input contains only alphanumeric characters
    return /^[a-zA-Z0-9]+$/.test(input);
}

function handleSubmit() {
    const userInput = document.getElementById('userInput').value;
    
    // Sanitize input to prevent XSS attacks
    const sanitizedInput = sanitizeInput(userInput);

    // Validate input to prevent SQL injections or other malicious input
    if (validateInput(userInput)) {
        // Safe to proceed with the sanitized input
        console.log('Sanitized input:', sanitizedInput);
        // Send sanitizedInput to server for further processing
        // Example: Use AJAX (e.g., fetch or axios) to send data to server
    } else {
        // Validation failed, handle error (e.g., show error message to user)
        console.error('Invalid input:', userInput);
        alert('Invalid input. Please enter alphanumeric characters only.');
    }
}