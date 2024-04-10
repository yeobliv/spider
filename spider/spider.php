<?php

/**
 * File: spider.php
 * Description: This file contains an implementation of the Spider class, which is an engine for dynamically generating web pages.
 *              The class provides interaction between the requested web pages and the Spider API feature sets
 *              Contains an autoloader that connects system files to all requested web pages, adding new features for developers
 * Author: Yehor Oblyvantsov
 * Version: 1.0.0
 */

$values = [];
ob_start();

global $startTime;
$startTime = microtime(true);

// Define the Spider class
class Spider
{
    // Constants for the software name and version
    const SOFTWARE = "Spider";
    const SOFTWARE_VERSION = "1.0.0";

    // Properties for the class
    private $autoPath;
    private $contentTypes = [
        'html' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'txt' => 'text/plain',
        'xml' => 'application/xml',
        'json' => 'application/json',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'avi' => 'video/x-msvideo',
        'zip' => 'application/zip',
        'tar' => 'application/x-tar',
        'gz' => 'application/gzip',
    ];

    // Constructor for the Spider class
    public function __construct($configFile = "config.spd")
    {
        // Set the base path for the application
        $public = "/public";
        $root = $_SERVER['DOCUMENT_ROOT'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->autoPath = $root . $public . $path;

        // Include PHP files in the current directory (excluding spider.php and spider.multilanguage.php)
        $dir = __DIR__;
        $files = array_diff(scandir($dir), ['spider.php']);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                include $file;
            }
        }
    }

    // Get content based on the file path
    public function getContent($filePath = null)
    {
        // Set the file path to auto path if not provided
        $filePath = $filePath ?? $this->autoPath;
        $root = $_SERVER['DOCUMENT_ROOT'];

        // Check if the provided path is a directory with an index.php file
        if (is_dir($filePath) && file_exists($filePath . '/index.php')) {
            $filePath = $filePath . '/index.php';
        }

        // Check if the file exists and is a regular file
        if (file_exists($filePath) && is_file($filePath)) {
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
            $this->contentTypes['php'] = 'text/html';

            // Set the Content-Type header based on the file extension
            if (isset($this->contentTypes[$fileExtension])) {
                header('Content-Type: ' . $this->contentTypes[$fileExtension]);
            }

            // Include or read the file content based on the extension
            if ($fileExtension === 'php') {
                include $filePath;
            } else {
                readfile($filePath);
            }
        } else {
            // Include the 404 error page if the file does not exist
            include $root . '/private/headers/404.php';
        }
    }
}