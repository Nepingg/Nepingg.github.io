<?php
/**
 * @var string $inputData
 * @var string $inputFormat
 * @var string $outputFormat
 * @var string $outputData
 */
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Michał Misiukiewicz (57878) - PTW LAB F</title>
    <link rel="stylesheet" href="./templates/styl.css" >
</head>
<body>
<h2>Konwerter Danych</h2>

<form method="POST">
    <div class="form-group">
        <label>Dane wejściowe:</label><br>
        <textarea name="inputData" rows="10"><?= htmlspecialchars($inputData) ?></textarea>
    </div>

    <div class="form-group">
        <label>Format wejściowy:</label>
        <select name="inputFormat">
            <?php foreach(['CSV', 'SSV', 'TSV', 'JSON', 'YAML'] as $format): ?>
                <option value="<?= $format ?>" <?= $inputFormat === $format ? 'selected' : '' ?>>
                    <?= $format ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Format wyjściowy:</label>
        <select name="outputFormat">
            <?php foreach(['CSV', 'SSV', 'TSV', 'JSON', 'YAML'] as $format): ?>
                <option value="<?= $format ?>" <?= $outputFormat === $format ? 'selected' : '' ?>>
                    <?= $format ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit">Konwertuj</button>
</form>

<?php if ($outputData !== ''): ?>
    <div class="form-group">
        <h3>Wynik konwersji:</h3>
        <pre><?= htmlspecialchars($outputData) ?></pre>
    </div>
<?php endif; ?>
</body>
</html>