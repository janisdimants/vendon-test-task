<?php require('partials/head.php'); ?>

<div class="result">
  <h1>Thanks, <?= $user->name; ?>!</h1>
  <div class="result__text">
    You answered correctly <?= $result->score ?> of <?= $question_count ?> questions.
  </div>
</div>


<?php require('partials/footer.php'); ?>
