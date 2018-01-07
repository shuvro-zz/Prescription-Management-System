<?php
namespace App\Controller\Component;

use Cake\Controller\Component;


class FileHandlerComponent extends Component
{
    function uploadImage($file, $filepath = null )
    {

        if (isset($file['name'])) {

            if(!$filepath) {
                $save_filepath = '/img/uploads/';
                $filepath = WWW_ROOT.'img' . DS.'uploads' . DS;
            }else{
                $save_filepath = $filepath;
                $filepath = WWW_ROOT.$filepath;
            }

            if (!is_dir($filepath) && !is_file($filepath)) {
                $this->createFolder($filepath, '0777');
            }

            $unique_filename = $this->getUniqueName($filepath, $file['name']);
            $filepath = $filepath . DS . $unique_filename;

            if ($this->upload($file['tmp_name'], $filepath)) {
                $save_file = $save_filepath.$unique_filename;
                return $unique_filename;
            }
        }

        return false;
    }

    function createFolder($path, $mode = 0777) {

        $folder_permissions = $mode;
        $folder = $path;

        if (strlen($folder) > 0) {
            if (!is_dir($folder) && !is_file($folder)) {

                switch((int)$folder_permissions) {
                    case 777:
                        mkdir($folder, 0777, true);
                        break;
                    case 705:
                        mkdir($folder, 0705, true);
                        break;
                    case 666:
                        mkdir($folder, 0666, true);
                        break;
                    case 644:
                        mkdir($folder, 0644, true);
                        break;
                    case 755:
                    default:
                        mkdir($folder, 0755, true);
                        break;
                }
                //@JFolder::create($folder, $folder_permissions );
                if (isset($folder)) {
                    $this->writeFile($folder.DS."index.html", "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>");
                }
                // folder was not created
                if (!is_dir($folder)) {
                    $errorMsg = "CreatingFolder";
                    return false;
                }
            }

            else {
                $errorMsg = "Folder Already Exists";
                return false;
            }
        } else {
            $errorMsg = "Folder Name Empty";
            return false;
        }
        return true;
    }

    function writeFile($file, $buffer) {
        if (!is_file(dirname($file))) {
            $fp = fopen($file, "w+");
            fwrite($fp, $buffer);
            fclose($fp);
        }
    }

    function getUniqueName($filePath, $fileName) {

        $fileName = $this->makeSafe($fileName);
        //if( file_exists($filePath.DS.$fileName) ){
            $fileName = time() . "_".$fileName;
        //}

        return $fileName;

    }

    function makeSafe($file) {
        $regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#', '/\s+/');
        return preg_replace($regex, '_', $file);
    }

    function upload($src, $dest){

        $ret = false;

        $dest = $this->clean($dest);
        $baseDir = dirname($dest);

        if (is_writeable($baseDir) && move_uploaded_file($src, $dest)) {
            $ret = true;
        }

        return $ret;
    }

    function clean($path, $ds=DS)
    {
        $path = trim($path);

        if (empty($path)) {
            $path = WWW_ROOT;
        }
        else {
            $path = preg_replace('#[/\\\\]+#', $ds, $path);
        }

        return $path;
    }

}