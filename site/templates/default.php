<?php snippet('header') ?>

<article>
    <h1 class="h1"><?= $page->title()->html() ?></h1>
    <ul>
        <?php foreach ($kirby->users() as $user) : ?>
            <li><?= $user->username() ?></li>
        <?php endforeach ?>
    </ul>
</article>

<?php snippet('footer') ?>