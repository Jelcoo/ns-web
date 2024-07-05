<nav>
    <a href="/">Live</a>
    <a href="/trains.php">Trains</a>
    <a href="/history.php">History</a>
    <a href="/statistics.php">Statistics</a>
</nav>

<script>
    const nav = document.querySelector('nav');
    const navLinks = nav.querySelectorAll('a');
    const url = new URL(window.location.href);
    const path = url.pathname;
    navLinks.forEach(link => {
        if (link.getAttribute('href') === path) {
            link.classList.add('active');
        }
    });
</script>
