<?php
// The spl_autoload_register function is used here to automatically load plugins.
spl_autoload_register(function ($plugin) {
    // Define the base directory where plugin files are located. 
    // Here, it's set to the '/private/plugins/' directory inside the document root of the server.
    $base_dir = $_SERVER['DOCUMENT_ROOT'] . '/private/plugins/';

    // Construct the file path by replacing the namespace separator (backslash) with the directory separator (forward slash)
    // and appending '.php' to the plugin name to form the file name.
    // This transformation assumes that the namespace and plugin hierarchy directly map to the directory and file structure.
    $file = $base_dir . str_replace('\\', '/', $plugin) . '.php';

    // Check if the constructed file path exists.
    // If it does, include that file to load the plugin definition.
    // This is crucial for the PHP interpreter to recognize and use the plugin when it's instantiated somewhere in the code.
    if (file_exists($file)) {
        require $file;
    }
});
?>
