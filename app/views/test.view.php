<?php require('partials/head.php'); ?>

<div class="questions">
    <?php foreach ($questions as $question): ?>
        <div class="question" data-id="<?= $question->id; ?>">
            <div class="question__text"><?= $question->text; ?></div>

            <div class="question__answers">
            
            <?php foreach ($question->getChoices() as $choice): ?>

                <button class="question__answer" data-id="<?= $choice->id; ?>"><?= $choice->text; ?></button>

            <?php endforeach; ?>

            </div>

        </div>


    <?php endforeach; ?>

    <button id="next_button" disabled >→</button>
    <div id="progress_bar" style="--question-count: <?= count($questions) ?>; --questions-answered: 0;">
        
    </div>
</div>

<?php require('partials/footer.php'); ?>
