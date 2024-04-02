<?php
namespace simpl\blocks;

use simpl\blocks\BaseBlock;

class BlockManager {

    public array $definitions = [];

    public function add( $definition ) {
        $this->definitions[ $definition['name'] ] = $definition;
    }

    public static function autoloadBlocks( BlockManager $blockManager ) {
        $blockNamespace = 'simpl\\blocks\\';
        $blocksDirectory = __DIR__;

        $blockClasses = [];

        // Get all PHP files in the blocks directory
        $blockFiles = scandir($blocksDirectory);
        foreach ($blockFiles as $file) {
            // Skip directories and non-PHP files
            if ($file === '.' || $file === '..' || pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
                continue;
            }

            // Get the class name from the file
            $className = pathinfo($file, PATHINFO_FILENAME);
            $fullClassName = $blockNamespace . $className;

            // Check if the class exists and is a subclass of BaseBlock
            if (class_exists($fullClassName) && is_subclass_of($fullClassName, BaseBlock::class)) {
                $blockClasses[] = $fullClassName;
            }
        }

        // Instantiate the block classes
        foreach ($blockClasses as $className) {
            $block = new $className($blockManager);
        }
    }

}