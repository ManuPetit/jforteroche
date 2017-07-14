<?php $livre = (isset($chapter)) ? $this->sanitizeHtml($chapter->getTitle()) : 'le livre'; ?>
<?php $this->title = "JF - " . $livre; ?>
<section id="intro">
    <div class="container">
        <h1>Billet simple pour l'Alaska 
            <?php if (isset($chapter)): ?>
                : <?php echo $chapter->getTitle(); ?>
            <?php endif; ?>
        </h1>
    </div>
</section>
<section id="main">
    <div class="container">
        <?php if (isset($chapter)): ?>
            <aside id="sidebar">
                <div class="dark">
                    <h4>Table des matières</h4>
                    <nav>
                        <ul>
                            <?php foreach ($menu as $item): ?>
                                <li<?php if ($chapter->getId() == $item['id']) echo ' class="current"'; ?>>
                                    <a href="chapitre/index/<?php echo $item['id']; ?>"><?php echo $this->sanitizeHtml($item['title']); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
            </aside>
            <article id="main-col">
                <h4>par <?php echo $this->sanitizeHtml($chapter->getUserName()); ?></h4>
                <p>
                    <?php echo $chapter->getContent(); ?><br />                        
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
                                        <a id="icon-response<?php echo $comment->getId(); ?>" onclick="answerComment('<?php echo $comment->getId(); ?>', '<?php echo $chapter->getId(); ?>')" title="Cliquez ici pour répondre à ce commentaire"><i class="fa fa-comments" aria-hidden="true"></i></a>
                                    <?php endif; ?>
                                    <a href="chapitre/signaler/<?php echo $comment->getId(); ?>" title="Signaler ce commentaire à l'administrateur du site"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>
                                </p>
                                <p id="frm<?php echo $comment->getId(); ?>"></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
            </article>
        <?php else: ?>
            <p>Il faut que je me mette au travail, car je n'ai pas encore publié un épisode de mon nouveau livre...</p>
            <p>Revenez bientôt !</p>
        <?php endif; ?>
    </div>
</section>
<?php if (isset($message)): ?>
    <script>
        window.alert("<?php echo $message; ?>");
    </script>
<?php endif; ?>