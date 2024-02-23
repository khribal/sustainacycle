<div class="container mx-auto p-2">
<footer class="py-3 my-4">
<ul class="nav justify-content-center border-bottom pb-3 mb-3">
    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'team.php'){echo 'active';} ?>">
        <a class="nav-link px-2 text-muted" href="team.php">About Us</a>
    </li>

    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'project.php'){echo 'active';} ?>">
        <a class="nav-link px-2 text-muted" href="project.php">About the Project</a>
    </li>

    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'video.php'){echo 'active';} ?>">
        <a class="nav-link px-2 text-muted" href="video.php">Promotional Video</a>
    </li>
</ul>
<p class="text-center text-muted">&copy;IU INFO-I495 F23 Team 20, 2023-2024</p>
</footer>
</div>