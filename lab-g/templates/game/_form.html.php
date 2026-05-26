<?php
    /** @var $game ?\App\Model\Game */
?>
<div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="game[title]" value="<?= $game ? $game->getTitle() : '' ?>">
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="game[description]"><?= $game ? $game->getDescription() : '' ?></textarea>
</div>

<div class="form-group">
    <input type="submit" value="Submit">
</div>
