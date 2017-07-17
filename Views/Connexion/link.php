<?php $this->title = "JF - Mot de passe oublié"; ?>
<section id="intro">
    <div class="container">
        <h1>Vous avez oublié votre mot de passe.</h1>
    </div>
</section>
<article>
    <div class="connexion">
        <p>Afin de changer ce dernier, entrez votre adresse email.<br />Un nouveau mot de passe<br />vous sera adressé directement.</p>
        <p>Merci</p>
        <form class="login" action="connexion/mail" method="post">
            <?php $forms->createInputEmail('email', 'Votre adresse email', true, 'Tapez votre email...', $value, $errors); ?>
            <button type="submit" class="button-submit">Créer mot de passe</button>  
        </form>
    </div>
</article>