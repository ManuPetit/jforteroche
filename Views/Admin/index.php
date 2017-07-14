<?php $this->title = "Admin : Vue d'ensemble"; ?>
<section id="intro">
    <div class="container">
        <h1>Vue d'ensemble</h1>
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
            <h2>Bienvenue <?php echo $userName; ?></h2>
            <p>Votre dernière connexion date du <?php echo $lastLogin; ?></p>
            <h3 class="titles">Les épisodes du livre</h3>
            <?php $forms->createChaptersCount($chapDetails); ?>
            <h3 class="titles">Les messages des internautes</h3>
            <?php $forms->createMessageCount($comDetails); ?>
        </article>
    </div>
</section>
