<?php

$logDir = __DIR__ . '/../logs';

if (!is_dir($logDir)) {
    echo "Папка логов не найдена: $logDir\n";
    exit(1);
}

$deleted = 0;
foreach (scandir($logDir) as $file) {
    if (in_array($file, ['.', '..'])) continue;

    $path = $logDir . '/' . $file;
    if (is_file($path)) {
        unlink($path);
        echo "Удалён: $file\n";
        $deleted++;
    }
}

echo $deleted > 0
    ? "Логи успешно очищены.\n"
    : "Логи уже были пусты.\n";