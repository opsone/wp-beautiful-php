<?php

use \Symfony\Component\Yaml\Yaml;

class WP_Beautiful_Config
{
    private $_finder;

    public function __construct()
    {
        $this->_finder = \PhpCsFixer\Finder::create()
              ->exclude('wp-content/plugins')
              ->notPath('wp-config.php')
          ;

        if (file_exists('wp-beautiful.yml')) {
            $config_env = Yaml::parse(file_get_contents('wp-cli.yml'));

            if (!empty($config_env['php-fixer']['excludes'])) {
                $excludes = $config_env['php-fixer']['excludes'];

                if (!empty($excludes['files'])) {
                    foreach ($excludes['files'] as $filename) {
                        $this->_finder = $this->_finder->notPath($filename);
                    }
                }

                if (!empty($excludes['folders'])) {
                    foreach ($excludes['folders'] as $folder) {
                        $this->_finder = $this->_finder->exclude($folder);
                    }
                }
            }
        }
    }

    public function exportConfig()
    {
        return \PhpCsFixer\Config::create()
              ->setRules([
                  '@PSR2'                  => true,
                  'single_quote'           => true,
                  'trim_array_spaces'      => true,
                  'no_useless_else'        => true,
                  'elseif'                 => true,
                  'binary_operator_spaces' => array(
                      'align_double_arrow' => true,
                      'align_equals'       => true
                  )
              ])
              ->setUsingCache(false)
              ->setFinder($this->_finder)
          ;
    }
}

  $config = new WP_Beautiful_Config();
  return $config->exportConfig();
