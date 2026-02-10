<?php
// Hàm chống XSS (In ra màn hình an toàn)
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// Hàm format tiền tệ
function format_currency($n) {
    return '$' . number_format($n, 2);
}
?>