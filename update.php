<?php

// URL to the Composer package archive
$packageUrl = 'https://github.com/rondeo-balos/php-simple-cms/archive/refs/heads/main.zip';

// Destination directory where you want to copy the folders
$destinationDir = __DIR__;

// List of folders you want to extract from the package archive
$foldersToExtract = [
    'php-simple-cms-main/components',
    'php-simple-cms-main/includes',
    'php-simple-cms-main/model',
    'php-simple-cms-main/layout',
    'php-simple-cms-main/src',
    'php-simple-cms-main/vendor'
    // Add more folders as needed
];

// Download the package archive
$packageArchive = file_get_contents($packageUrl);

if ($packageArchive !== false) {
    // Extract the package archive to a temporary directory
    $tempDir = sys_get_temp_dir() . '/simpl_temp';
    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0777, true);
    }
    file_put_contents($tempDir . '/package.zip', $packageArchive);
    $zip = new ZipArchive;
    if ($zip->open($tempDir . '/package.zip') === true) {
        $extracted = false;
        foreach ($foldersToExtract as $folderName) {
            $folderPath = $folderName . '/';
            if ($zip->locateName($folderPath) !== false) {
                $zip->extractTo($tempDir, $folderPath);
                // Copy the extracted folder to the destination directory
                copyPackageFolder($tempDir, $folderPath, $destinationDir);
                $extracted = true;
            } else {
                echo "Folder '$folderPath' not found in the package archive.\n";
            }
        }
        if ($extracted) {
            echo "Folders copied successfully.";
        } else {
            echo "No folders were copied.";
        }
        $zip->close();
        // Clean up temporary files/directories
        unlink($tempDir . '/package.zip');
        rmdir($tempDir);
    } else {
        echo "Failed to extract the package archive.";
    }
} else {
    echo "Failed to download the package archive.";
}

// Function to copy folder from extracted files to destination directory
function copyPackageFolder($tempDir, $folderName, $destinationDir) {
    $sourceDir = $tempDir . '/' . $folderName;
    if (is_dir($sourceDir)) {
        // Create destination directory if it doesn't exist
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0777, true);
        }
        // Copy folder recursively
        $cmd = "cp -r $sourceDir $destinationDir";
        exec($cmd);
    } else {
        echo "Source folder '$sourceDir' not found.";
    }
}
