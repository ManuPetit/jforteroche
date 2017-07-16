<?php $this->title = "Admin : Mon profil"; ?>
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
            <p>Identifiant de connexion : <?php echo $user->getLogin(); ?></p>
            <p>Email de contact : <?php echo $user->getEmail(); ?></p>
            <p>Dernière connexion : <?php echo $user->getDateLastLogin(); ?></p>
        </article>
    </div>
</section>
<?php if (isset($message)): ?>
    <script>
        window.alert("<?php echo $message; ?>");
    </script>
<?php endif; ?>