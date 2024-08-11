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

<style>
    nav {
        width: 100%;
        height: 4rem;
        background-color: #3f3f43;
    }
    nav a {
        display: inline-block;
        padding: 1rem;
        color: #fff;
        text-decoration: none;
        font-size: 1.5rem;
        font-weight: bold;
        line-height: 2rem;
    }
    nav a:hover {
        color: #868686;
    }
    nav a.active {
        text-decoration: underline;
    }
</style>
