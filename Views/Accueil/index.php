<?php $this->title = "JF - Accueil"; ?>
<section id="cover">
    <div class="container">
        <h1>Billet simple pour l'Alaska</h1>
        <p>Un thriller de Jean Forteroche.</p>
    </div>
</section>
<section id="intro">
    <div class="container">
        <p>Avec ce nouveau roman, j'ai souhaité innover. Ce livre sera publié sur ce site, épisode par épisode. Ce thriller, pourra également être commenté par vous, mes fidèles lecteurs, mais aussi par l'ensemble des internautes qui prendront la peine de venir sur ce site. Bonne lecture...</p>
        <p class="signature">Jean Forteroche</p>
    </div>
</section>
<section id="boxes">
    <div class="container">
        <?php if (isset($lastChapters)): ?>
            <h1>Les derniers chapitres publiés</h1>
            <?php foreach ($lastChapters as $chapter): ?>
                <div class="box">
                    <h3><?php echo $this->sanitizeHtml($chapter->getTitle()); ?></h3>
                    <h4>par <?php echo $this->sanitizeHtml($chapter->getUserName()); ?></h4>
                    <p>
                        <?php echo $chapter->getContent(); ?></p>
                    <p>Publié le <?php echo $chapter->getDateLastModif(); ?>.<p>
                    <p>
                        <a href="chapitre/index/<?php echo $this->sanitizeHtml($chapter->getId()); ?>">Lire la suite</a>                          
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h1>Aucun chapitre publié.</h1>
            <h3>Revenez bientôt pour découvrir le livre....</h3>
        <?php endif; ?>
    </div>
</section>

