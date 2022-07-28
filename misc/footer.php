<div class="footer-container"<?php if(!str_contains($_SERVER['REQUEST_URI'], '/search') && !str_contains($_SERVER['REQUEST_URI'], '/settings') || isset($_SESSION['gmxerror'])) echo ' style="position: absolute;"'; if(isset($_SESSION['gmxerror'])) unset($_SESSION['gmxerror']); ?>>
    <a href="/">GMX</a>
    <a href="https://github.com/gamemaster123356/gmx/">Source & Instance list</a>
    <a href="/api" target="_blank">API</a>
</div>
</body>
</html>