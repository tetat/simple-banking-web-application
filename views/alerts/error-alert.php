<div class="w-full">
<?php foreach ($errors['alert'] as $key => $value): ?>

    <div class="p-4 mx-auto w-1/2 text-md text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
        <?= $value ?>
    </div>

<?php endforeach ?>
</div>