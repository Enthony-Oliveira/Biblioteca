<?php

if (!defined('DEBUG_MODE')) {
    define('DEBUG_MODE', true);
}

if (!defined('NOME_BIBLIOTECA')) {
    define('NOME_BIBLIOTECA', 'Sistema de Biblioteca');
}

if (!defined('VERSAO_SISTEMA')) {
    define('VERSAO_SISTEMA', '1.0.0');
}

if (!defined('MSG_SUCESSO')) {
    define('MSG_SUCESSO', 'sucesso');
}
if (!defined('MSG_ERRO')) {
    define('MSG_ERRO', 'erro');
}
if (!defined('MSG_AVISO')) {
    define('MSG_AVISO', 'aviso');
}

if (!defined('PRAZO_EMPRESTIMO_DIAS')) {
    define('PRAZO_EMPRESTIMO_DIAS', 7);
}

if (!defined('VALOR_MULTA_DIA')) {
    define('VALOR_MULTA_DIA', 2.50);
}

if (!defined('LIMITE_EMPRESTIMOS_CLIENTE')) {
    define('LIMITE_EMPRESTIMOS_CLIENTE', 3);
}
