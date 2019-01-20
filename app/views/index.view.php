<?php require('partials/head.php'); ?>
    
    <form action="/test/start" method="POST" id="select_test_form">
        <div class="input-container">
            <label for="name_input">Name</label>
            <input type="text" id="name_input" name="name">
            <?php if (hasError('name')) { ?>
                <p><?= getErrorMessage('name'); ?></p>
            <?php } ?>
        </div>

        <div class="input-container">
            <label for="test_select">Select test</label>
            <select name="test_id" id="test_select">
                <?php foreach ($tests as $test): ?>

                    <option value="<?= $test->id ?>"><?= $test->name ?></option>

                <?php endforeach; ?>
            </select>
            <?php if (hasError('test_id')) { ?>
                <p><?= getErrorMessage('test_id'); ?></p>
            <?php }?>
        </div>

        <button type="submit">Start test</button>
    </form>

<?php require('partials/footer.php'); ?>
