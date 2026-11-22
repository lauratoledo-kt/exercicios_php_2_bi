<?php if ($erros !== []): ?>
    <div class="aviso" role="alert">
        <strong>Confira os dados informados.</strong>
        <ul>
            <?php foreach ($erros as $erro): ?>
                <li><?= h($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
