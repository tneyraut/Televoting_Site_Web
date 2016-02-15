<?php

require_once(__ROOT_DIR__ . '/classes/Object.class.php');
class AutoLoader extends Object
{

    public function __construct()
    {
        spl_autoload_register(array($this, 'load'));
    }

    private function load($className)
    {
        $src_directories = array('classes', 'controller', 'model', 'view');

        $i = 0;
        do
        {
            $filePath = __ROOT_DIR__ . '/' . $src_directories[$i] . '/' . ucfirst($className) . '.class.php';
            $i++;
        }
        while(!is_readable($filePath) && $i < count($src_directories));

        if(!is_readable($filePath)) {
            throw new Exception('Unknown class ' . $className);
        }

        require_once($filePath);

        if(strlen(strstr($filePath, '/model/')) > 0)
        {
            $sqlFilePath = __ROOT_DIR__ . '/sql/' . ucfirst($className) . '.sql.php';

            require_once($sqlFilePath);
        }
    }

}
$__LOADER__ = new AutoLoader();
