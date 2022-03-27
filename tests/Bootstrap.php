<?php

namespace Pangolia\ServicesTests;

/**
 * The credentials file needs to be created with the following returned array
 *
 * @param array  {
 *
 * @param array $slack {
 * @type string $webhook
 * }
 *
 * @param array $cloudflare {
 * @type string $email
 * @type string $api_key
 * @type string $zone_id
 * @type string $domain
 * }
 *
 * @param array $notion {
 * @type string $secret_token
 * }
 *
 * @param array $tests Configurations for our tests {
 * @type array $cloudflare_files {@see https://api.cloudflare.com/#zone-purge-files-by-url}
 * @type string $notion_database_id {@see https://developers.notion.com/docs/working-with-databases#adding-pages-to-a-database}
 * @type string $notion_relation_id
 * }
 * }
 */
$GLOBALS['credentials'] = include_once __DIR__ . '/config/credentials.php';

define( 'PANGOLIA_PHPUNIT', true );
define( 'PANGOLIA_DIR', __DIR__ );
define( 'PANGOLIA_FILE', __FILE__ );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG', true );

$composer = require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/unit/ServicesTestCase.php';