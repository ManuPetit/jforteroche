<?php $this->title = "Admin : Modifier mon profil"; ?>
<section id="intro">
    <div class="container">
        <h1>Profil d'utilisateur</h1>
    </div>
</section>
<section id="main-admin">
    <div class="container">
        <aside id="sidebar">
            <nav>
                <h3>Menu</h3>
                <ul>
                    <?php echo $adminMenu; ?>
                </ul>
            </nav>
        </aside>
        <article id="main-col">
            <h2><?php echo $user->getFullname(); ?></h2>
            
        </article>
    </div>
</section>