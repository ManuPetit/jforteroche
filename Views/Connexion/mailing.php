<?php $this->title = "JF - Mot de passe oublié"; ?>
<section id="intro">
    <div class="container">
        <h1>Nouveau mot de passe</h1>
    </div>
</section>
<section id="main">
    <div class="container">
        <article> 
            <?php if (isset($message)): ?>
                <?php echo $message; ?>
            <?php endif; ?>
        </article>
    </div>
</section>