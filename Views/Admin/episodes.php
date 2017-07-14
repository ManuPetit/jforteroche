<?php $this->title = "Admin : Episodes"; ?>
<section id="intro">
    <div class="container">
        <h1>Episodes du livre</h1>
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
            <?php if ($totalChapter != 0): ?>
                <h2>Tableau récapitulatif</h2>
                <?php if ($option == 0): ?>
                    <p>Légende des couleurs :<br />
                        <span class="editing">- En mauve : chapitre à l'état de brouillon</span><br />
                        <span class="published">- En vert : chapitre publié</span>
                    </p>
                <?php endif; ?>
                <table>
                    <tr>
                        <td colspan="2">
                            <form action="admin/episodes" method="post">
                                <label for="types">Choisissez de voir : </label>
                                <select name="types">
                                    <option value="0"<?php if ($option == 0) echo " selected"; ?>>Tous les chapitres</option>
                                    <option value="1"<?php if ($option == 1) echo " selected"; ?>>Chapitres à l'état de brouillon</option>
                                    <option value="2"<?php if ($option == 2) echo " selected"; ?>>Chapitres publiés</option>
                                </select>
                                <button type="submit" name="submit" class="button-admin">Filtrer</button>
                            </form>
                        </td>
                    </tr> 
                    <?php if (isset($allChapters)): ?>
                        <?php foreach ($allChapters as $chapter): ?>
                            <?php $forms->createChapterRow($chapter); ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="2">Aucun épisode dans cette sélection.<br />
                                Essayez une autre sélection.</td></tr>
                    <?php endif; ?>
                </table>
            <?php else: ?>
                <h2>Il n'y a aucun épisode pour le moment.</h2>   
            <?php endif; ?>
        </article>
    </div>
</section>
<?php if (isset($message)): ?>
    <script>
        window.alert("<?php echo $message; ?>");
    </script>
<?php endif; ?>

