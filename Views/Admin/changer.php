<?php $this->title = "Admin : Modifier mon profil"; ?>
<section id="intro">
    <div class="container">
        <h1>Modifier mon profil</h1>
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
            <fieldset>
                <legend> Changez votre email </legend>
                <form action="admin/email" method="post">
                    <?php $forms->createInputEmail('email', 'Votre email', true, 'Entrez votre email', $value, $errors); ?>
                    <button type="submit" class="button-submit">Enregistrer mon email</button>    
                </form>
            </fieldset>
            <fieldset>
                <legend> Changez votre mot de passe </legend>
                <form action="admin/motdepasse" method="post">
                    <?php $forms->createInputPassword('passone', 'Votre nouveau mot de passe', $errors); ?>
                    <?php $forms->createInputPassword('passtwo', 'Comfirmation de votre mot de passe', $errors); ?>
                    <button type="submit" class="button-submit">Modifier mon mot de passe</button>    
                </form>
            </fieldset>
        </article>
    </div>
</section>