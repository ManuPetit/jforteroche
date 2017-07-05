<?php $this->title = "JF : " . $this->sanitizeHtml($chapter->getTitle()); ?>
<section id="intro">
    <div class="container">
        <h1>Billet simple pour l'Alaska</h1>
    </div>
</section>
<section id="main">
    <div class="container">
        <aside id="sidebar">
            <p>Table des matières</p>
            <nav>
                <ul>
                    <?php foreach ($menu as $item): ?>
                        <li<?php if ($chapter->getId() == $item['id']) echo ' class="current"'; ?>>
                            <a href="chapitre/index/<?php echo $item['id']; ?>"><?php echo $this->sanitizeHtml($item['title']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <hr />
        </aside>
        <article id="main-col">
            <h1><?php echo $this->sanitizeHtml($chapter->getTitle()); ?></h1>
            <h4>par <?php echo $this->sanitizeHtml($chapter->getUserName()); ?></h4>
            <p>
                <?php echo $this->sanitizeHtml($chapter->getContent()); ?><br />                        
            </p>
            <?php if (isset($comments)): ?>
                <h1>Vos réactions</h1>
            <?php else: ?>
                <h1>Soyez le premier à réagir...</h1>
            <?php endif; ?>
            <div class="comment">
                <form class="message" action="chapitre/commenter" method="post">
                    <?php $forms->createInputText('author', 'Nom', true, 'Tapez votre nom...', $value, $errors); ?>
                    <?php $forms->createTextarea('comment', 'Votre message', true, 'Tapez votre message...', $value, $errors); ?>
                    <input type="hidden" name="id" value="<?php echo $chapter->getId(); ?>" />
                    <button type="submit" class="button-submit">Commentez ce chapitre...</button>
                </form>
            </div>
            <?php if (isset($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <?php if ($comment->getLevel() != 0): ?>
                        <div class="comment level<?php echo $comment->getLevel(); ?>">
                        <?php else: ?>
                            <div class="comment">    
                            <?php endif; ?>
                            <p>Commentaire de <span class="pseudo"><?php echo $this->sanitizeHtml($comment->getUserName()); ?></span>, 
                                posté le <?php echo $comment->getDateWritten(); ?> :</p>
                            <p><?php echo $this->sanitizeHtml($comment->getComment()); ?></p>
                            <p class="comment-icon">
                                <?php if ($comment->getLevel() != 2): ?>
                                    <a href="chapitre/repondre/<?php echo $chapter->getId() . '/' . $comment->getId(); ?>" title="Cliquez ici pour répondre à ce commentaire"><i class="fa fa-comments" aria-hidden="true"></i></a>
                                <?php endif; ?>
                                <a href="chapitre/signaler/<?php echo $comment->getId(); ?>" title="Signaler ce commentaire à l'administrateur du site"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
        </article>
    </div>
</section>
<?php if (isset($message)): ?>
    <script>
        window.alert("<?php echo $message; ?>");
    </script>
<?php endif; ?>