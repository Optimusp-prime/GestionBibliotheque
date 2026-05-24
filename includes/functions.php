<?php

function h($value)
{
    if ($value instanceof DateTimeInterface) {
        $value = $value->format('Y-m-d');
    }

    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function countRows($conn, $sql, $params = [])
{
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return (int) $stmt->fetchColumn();
}

function redirectWithMessage($url, $type, $message)
{
    header('Location: ' . $url . '?message_type=' . urlencode($type) . '&message=' . urlencode($message));
    exit;
}

function showMessage()
{
    if (empty($_GET['message'])) {
        return;
    }

    $type = $_GET['message_type'] ?? 'success';
    $class = 'alert-info-custom';
    $icon = 'bi-info-circle-fill';

    if ($type === 'success') {
        $class = 'alert-success-custom';
        $icon = 'bi-check-circle-fill';
    } elseif ($type === 'error') {
        $class = 'alert-danger-custom';
        $icon = 'bi-x-circle-fill';
    } elseif ($type === 'warning') {
        $class = 'alert-warning-custom';
        $icon = 'bi-exclamation-triangle-fill';
    }
    ?>
    <div class="alert-custom <?= h($class) ?>">
        <i class="bi <?= h($icon) ?>"></i>
        <?= h($_GET['message']) ?>
    </div>
    <?php
}

function currentDateSql()
{
    return 'CAST(GETDATE() AS date)';
}
