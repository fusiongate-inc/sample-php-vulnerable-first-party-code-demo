<?php

namespace Config;

/**
 * This file contains an array of mime types.  It is used by the
 * Upload class to help identify allowed file types.
 *
 * When more than one variation for an extension exist (like jpg, jpeg, etc)
 * the most common one should be first in the array to aid the guess*
 * methods. The same applies when more than one mime-type exists for a
 * single extension.
 *
 * When working with mime types, please make sure you have the ´fileinfo´
 * extension enabled to reliably detect the media types.
 */
class Mimes
{
    /**
     * Map of extensions to mime types.
     *
     * @var array<string, list<string>|string>
     */
    public static array $mimes = [
        // ... (unchanged)
    ];

    /**
     * Attempts to determine the best mime type for the given file extension.
     *
     * @return string|null The mime type found, or none if unable to determine.
     */
    public static function guessTypeFromExtension(string $extension)
    {
        $extension = trim(strtolower($extension), '. ');

        return static::$mimes[$extension] ?? null;
    }

    /**
     * Attempts to determine the best file extension for a given mime type.
     *
     * @param string|null $proposedExtension - default extension (in case there is more than one with the same mime type)
     *
     * @return string|null The extension determined, or null if unable to match.
     */
    public static function guessExtensionFromType(string $type, ?string $proposedExtension = null)
    {
        $type = trim(strtolower($type), '. ');
        $proposedExtension = trim(strtolower($proposedExtension ?? ''));

        $mimeTypes = array_filter(static::$mimes, function ($value) use ($type) {
            return in_array($type, (array) $value, true);
        });

        if ($proposedExtension !== '' && isset($mimeTypes[$proposedExtension])) {
            return $proposedExtension;
        }

        $extensions = array_keys($mimeTypes);

        return $extensions ? $extensions[0] : null;
    }
}