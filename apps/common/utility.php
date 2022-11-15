<?php
declare(strict_types=1);

/**
 * htmlspecialcharsのラッパー関数
 */
function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES);
}

