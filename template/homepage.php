<?php $title = "Le blog de Ben"; ?>

<?php ob_start(); ?>
<h1>Mon super blog pro</h1>
<p>Derniers articles du blog :</p>

<?php
foreach ($recentArticles as $article) {
    ?>
    <div class="news">
        <h3>
            <?= htmlspecialchars($article->title); ?>
            <em>le <?= $article->creationDate; ?></em>
        </h3>
        <p>
            <?= nl2br(htmlspecialchars($article->content)); ?>
            <br>
        </p>
    </div>
    <?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
