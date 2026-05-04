<?php

/**
 * max_upload_size in megabytes,
 */

return [
    'max_upload_size' => env('DOCVAULT_MAX_UPLOAD_SIZE', 5),
    'allowed_file_types' => explode(',', env('DOCVAULT_ALLOWED_FILE_TYPES', "pdf,doc,docx,xlsx,csv")),
    'upload_disk' => env('DOCVAULT_UPLOAD_DISK', 'public'),
    'max_dir_count' => env('DOCVAULT_MAX_DIR_COUNT', 10),
];
