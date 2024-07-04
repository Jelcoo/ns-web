<nav>
    <a href="/">Live</a>
    <a href="/history">History</a>
    <a href="/statistics">Statistics</a>
</nav>

<script>
    const nav = document.querySelector('nav');
    const navLinks = nav.querySelectorAll('a');
    const url = new URL(window.location.href);
    const path = url.pathname;
    navLinks.forEach(link => {
        console.log(link.getAttribute('href'), path);
        if (link.getAttribute('href') === path) {
            link.classList.add('active');
        }
    });
</script>
