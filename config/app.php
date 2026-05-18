<?php

define('APP_NAME', 'JomiGlobal');
define('APP_URL', 'http://localhost/JomiGlobal/public');
define('APP_ENV', 'development');
define('APP_VERSION', '1.0.0');

// Currency
define('CURRENCY', 'NGN');
define('CURRENCY_SYMBOL', '₦');

// Pagination
define('ITEMS_PER_PAGE', 12);

// Upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'webp']);

// Session
define('SESSION_NAME', 'jomiglobal_session');

// Timezone
date_default_timezone_set('Africa/Lagos');