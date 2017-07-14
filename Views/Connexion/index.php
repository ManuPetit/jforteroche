<?php $this->title = "JF - Connexion admin"; ?>
<section id="intro">
    <div class="container">
        <p>Veuillez vous connecter.</p>
    </div>
</section>
<article>
    <div class="connexion"> 
        <form class="login" action="connexion/connecter" method="post">
            <?php $forms->createInputText("login", "Nom", true, "Nom de connexion...", $value, $errors); ?>
            <?php $forms->createInputPassword("password", "Mot de passe"); ?>
            <button type="submit" class="button-submit">Connexion</button>          
        </form>
    </div>
</article>

