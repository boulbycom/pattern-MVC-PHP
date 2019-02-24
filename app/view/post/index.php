<?php
include 'navbar.php'?>
<div class="container">
    <div class="row">
        <div class="col col-12">
            <br><h1>Tous les posts</h1>
            <hr>
        </div>
    </div>

    <?php foreach ($posts as $post):?>
    <div class="row">
        <div class="col-12">
            <h2><?=$post->name;?></h2>
            <p><?=$post->content;?></p>
            <a href="<?=ROOT?>post/<?=$post->id?>">lire &rarr;</a>
        </div>
    </div>
    <?php endforeach;?>
</div>

