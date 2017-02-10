<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa user o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'petvivo');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');


define('WP_LANG', 'pt_BR');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'J4i 2SNF`[=_e>3fLVPDhb^(!^&M(awz+qZ)Ineaj:eFGew@lq>_cBLIxOsuJg^z');
define('SECURE_AUTH_KEY',  ':WQ~^{n@P(g/@kS&Z%o<Z$%_vrs[cZ9}YRH7K9LM=fY-of{Ge-NFN&6[!f+VVEaC');
define('LOGGED_IN_KEY',    'jTLH9c9VGKp/pEn:a*G*ml&y5CCpMHoDoTot]Q$wR8nMqqBZnwq$FXCay`nPv&B3');
define('NONCE_KEY',        'QIi547q@1zrT%b-V`gNQN9dM7|O6vUc@$+jl}wLV-Q]}VzXJZ],{Rdk`s_Vj<>]d');
define('AUTH_SALT',        'q,AZ(#;k6{J/4k8%O-*z(=F?{#bc.6U -I-X$3d=QpNfp%w;`ec.Wt:=h0a]OF@`');
define('SECURE_AUTH_SALT', 'FSrt(W4{7}taC$TB*(C=-Xp8YN*v7RB99BCO`eA9uZQtS;pe3h2=V=2KpF;>RGP[');
define('LOGGED_IN_SALT',   'J*r+1((}x *,4,A/F~B2gQ;rT3Om`e/6=c1xiR)bly5nE5U!4,G!;SuL=CVIJ5Nh');
define('NONCE_SALT',       'e7[LB_@~z&%dpzxc5Ssa_ya:{_qjhInK;hVK#IjeE#;?YA0Jdn%LspTV>9#6M~[9');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * para cada um um único prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp82_';

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
