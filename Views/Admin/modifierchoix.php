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
            <?php if (isset($chapters)): ?>
                <h2>Choisissez un épisode à modifier :</h2>
                <form action="admin/modifier" method="post">
                    <p>
                        <label for="id">Les épisodes :</label><br />
                        <select id="id" name="id">
                            <?php foreach ($chapters as $chapter): ?>
                                <option value="<?php echo $chapter->getId(); ?>">
                                    <?php echo $chapter->getTitle(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <button type="submit" name="submit" class="button-admin">Modifier</button>
                </form>
            <?php else: ?>
                <h2>Il n'y a aucun épisode à modifier.</h2>
            <?php endif; ?>
        </article>
    </div>
</section>


