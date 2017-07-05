<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <base href="<?php echo $webRoot; ?>" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="../Contents/css/jfstyle.css" />
        <script src="https://use.fontawesome.com/6d7e5e9aa9.js"></script>
    </head>
    <body>
        <header>
            <div class="container">
                <div id="branding">
                    <h1>Jean <span class="highlight">Forteroche</span></h1>
                </div>
                <nav>
                    <ul>
                        <?php echo $mainMenu; ?>
                    </ul>
                </nav>
            </div>
        </header>
        <div id="content"> 
            <?php echo $content_for_layout; ?> <!-- Specific content -->
        </div> <!-- #content -->
        <footer>
            <p>Auteur : Jean Forteroche | Réalisation du site webcom Copyright &copy; 2017</p>
        </footer>
    </body>
</html>
