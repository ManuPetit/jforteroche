<?php $this->title = "Admin : Modifier un épisode"; ?>
<section id="intro">
    <div class="container">
        <h1>Modifier un épisode</h1>
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
            <h2>Détails de cet épisode :</h2>
            <form action="admin/miseajour" method="post">
                <?php $forms->createLargeInputText('title', 'Titre de l\'épisode', true, 'Tapez le titre de l\'épisode', $value, $errors, true); ?>
                <?php //$forms->createTinymceTextarea('episode', 'Le texte de l\'épisode', true, $value, $errors); ?>
                <p>
                    <label for="episode">Texte de l'épisode :</label><br />
                    <textarea id="episode" name="episode" class="tinymce" required>
                        <?php if (isset($value['episode'])): ?>
                            <?php echo $value['episode']; ?>
                        <?php endif; ?>
                    </textarea>  
                    <?php if (isset($errors['episode'])): ?>
                        <?php echo '<br /><span class="error">Attention : ' . $errors['err_episode'] . '</span>'; ?>
                    <?php endif; ?>
                </p>
                <p>
                    <label for="state">Etat de l'épisode : </label>
                    <select name="state">
                        <option value="1"<?php if ($option == 1) echo " selected"; ?>>Brouillon</option>
                        <option value="2"<?php if ($option == 2) echo " selected"; ?>>Publier cet épisode</option>
                    </select>
                </p>
                <input type="hidden" value="<?php echo $value['id']; ?>" name="id" />
                <button type="submit" class="button-submit">Enregistrer cet épisode</button>                
            </form>
        </article>
    </div>
</section>
<!-- javascript pour tinymce -->
<script src="../Contents/js/jquery.min.js"></script>
<script src="../Contents/js/tinymce/tinymce.min.js"></script>
<script src="../Contents/js/tinymce/init-tinymce.js"></script>
<?php if (isset($message)): ?>
    <script>
        window.alert("<?php echo $message; ?>");
    </script>
<?php endif; ?>
<!-- fin de javascript -->