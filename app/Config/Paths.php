<?php

namespace Config;

/**
 * Paths
 *
 * Holds the paths that are used by the system to
 * locate the main directories, app, system, etc.
 *
 * All paths are relative to the project's root folder.
 */
class Paths
{
    /**
     * SYSTEM FOLDER NAME
     */
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * APPLICATION FOLDER NAME
     */
    public string $appDirectory = __DIR__ . '/..';

    /**
     * WRITABLE DIRECTORY NAME
     *
     * Use /tmp because Hostless has a read-only filesystem.
     */
    public string $writableDirectory = '/tmp/ci-writable';

    /**
     * TESTS DIRECTORY NAME
     */
    public string $testsDirectory = __DIR__ . '/../../tests';

    /**
     * VIEW DIRECTORY NAME
     */
    public string $viewDirectory = __DIR__ . '/../Views';

    /**
     * ENVIRONMENT DIRECTORY NAME
     */
    public string $envDirectory = __DIR__ . '/../../';
}
