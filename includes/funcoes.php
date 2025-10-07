<?php
// Funções auxiliares (exemplo)
// Escape seguro para HTML
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>