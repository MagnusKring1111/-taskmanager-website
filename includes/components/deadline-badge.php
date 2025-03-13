<?php
function renderDeadlineBadge($deadlineRaw)
{
    $tz = new DateTimeZone('Europe/Copenhagen');
    $now = new DateTime('now', $tz);
    $now->setTime(0, 0, 0);

    try {
        $deadlineDate = new DateTime($deadlineRaw, $tz);
    } catch (Exception $e) {
        echo "<span class='deadline-badge deadline-error' title='Ugyldig deadline'>$deadlineRaw</span>";
        return;
    }

    $deadlineDateOnly = clone $deadlineDate;
    $deadlineDateOnly->setTime(0, 0, 0);
    $timeFormatted = $deadlineDate->format('H:i');
    $dateFormatted = $deadlineDate->format('d.m.Y');

    // Days difference (for tooltip wording)
    $daysDiff = (int)$now->diff($deadlineDateOnly)->format('%r%a');

    if ($deadlineDateOnly < $now) {
        $daysOverdue = abs($daysDiff);
        $label = "Overskredet";
        $tooltip = "Deadline: $dateFormatted kl. $timeFormatted – $daysOverdue dage forsinket";
        $badgeClass = "deadline-badge deadline-overdue";
    } elseif ($deadlineDateOnly == $now) {
        $label = "I dag kl. $timeFormatted";
        $tooltip = "Deadline: $dateFormatted kl. $timeFormatted";
        $badgeClass = "deadline-badge deadline-orange";
    } elseif ($daysDiff === 1) {
        $label = "I morgen kl. $timeFormatted";
        $tooltip = "Deadline: $dateFormatted kl. $timeFormatted (1 dag tilbage)";
        $badgeClass = "deadline-badge deadline-orange";
    } else {
        $label = "$dateFormatted kl. $timeFormatted";
        $tooltip = "Deadline: $dateFormatted kl. $timeFormatted ($daysDiff dage tilbage)";
        $badgeClass = "deadline-badge deadline-green";
    }

    echo "<div class='tooltip-wrapper'>
        <span class='$badgeClass'>" . htmlspecialchars($label) . "</span>
        <span class='tooltip'>" . htmlspecialchars($tooltip) . "</span>
    </div>";
}
?>
