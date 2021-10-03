<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$project_path = getcwd();
$finder = Finder::create()
    ->in([
        $project_path . '/app',
        $project_path . '/config',
        $project_path . '/database',
        $project_path . '/resources',
        $project_path . '/routes',
        $project_path . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setUsingCache(true);
