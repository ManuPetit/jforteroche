<?php $this->title = "Admin : Messages"; ?>
<section id="intro">
    <div class="container">
        <h1>Messages des internautes</h1>
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
            <?php if ($totalComment != 0): ?>
                <h2>Tableau récapitulatif</h2>
                <?php if ($option == 0): ?>
                    <p>Légende des couleurs :<br />
                        <span class="waiting">- En bleu : nouveau message en attente de validation</span><br />
                        <span class="validated">- En vert : message validé</span><br />
                        <span class="signaled">- En orange : message signalé par un internaute, demande nouvelle validation</span><br />
                        <span class="hidden">- En rouge : message masqué</span>
                    </p>
                <?php endif; ?>
                <table>
                    <tr>
                        <td colspan="2">
                            <form action ="admin/messages" method="post">
                                <label for="approval">Choisissez de visionner : </label>
                                <select name="approval">
                                    <option value="0"<?php if ($option == 0) echo " selected"; ?>>Tous les messages</option>
                                    <option value="1"<?php if ($option == 1) echo " selected"; ?>>Nouveaux messages en attente de validation</option>
                                    <option value="2"<?php if ($option == 2) echo " selected"; ?>>Messages validés</option>
                                    <option value="3"<?php if ($option == 3) echo " selected"; ?>>Messages signalés pour vérification</option>
                                    <option value="4"<?php if ($option == 4) echo " selected"; ?>>Messages masqués</option>
                                </select>
                                <button type="submit" name="submit" class="button-admin">Filtrer</button>
                                <input type="hidden" name="prevoption" value="<?php echo $prevoption; ?>" />
                                <input type="hidden" name="start" value="<?php echo $start; ?>" />
                                <input type="hidden" name="pages" value="<?php echo $pages; ?>" />
                                <input type="hidden" name="display" value="<?php echo $display; ?>" />
                                
                            </form>
                        </td>
                    </tr>
                    <?php if (isset($allComments)): ?>
                        <?php foreach ($allComments as $comment): ?>
                            <?php $forms->createMessageRow($comment); ?>
                        <?php endforeach; ?>
                        <?php $forms->createPagination($start, $pages, $display, $option, $prevoption); ?>
                    <?php else: ?>
                        <tr><td colspan="2">Aucun commentaire dans cette sélection.<br />
                                Essayez une autre sélection.</td></tr>
                    <?php endif; ?>
                </table>
            <?php else: ?>
                <h2>Il n'y a aucun commentaire dans cette section, pour le moment.</h2>                   
            <?php endif; ?>
        </article>
    </div>
</section>