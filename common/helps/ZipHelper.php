<?php
namespace common\helps;

use yii\base\Exception;
use ZipArchive;

class ZipHelper extends ZipArchive
{
    public function extractSubdirTo($destination, $systype)
    {
        $errors = array();
        // Prepare dirs
        $destination = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $destination);
        if (substr($destination, mb_strlen(DIRECTORY_SEPARATOR, "UTF-8") * -1) != DIRECTORY_SEPARATOR)
            $destination .= DIRECTORY_SEPARATOR;
        // Extract files
        for ($i = 0; $i < $this->numFiles; $i++)
        {
            $filename = $this->getNameIndex($i);
            $relativePath = $filename;
            $relativePath = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $relativePath);
            /* if ($systype == 'windows') {
                $tmpname = iconv('GBK', 'utf-8//TRANSLIT//IGNORE', $destination . $relativePath);
            } elseif ($systype == 'mac') {
                $tmpname = $destination . $relativePath;
            } else {
                throw new Exception("sorry systype not find");
            } */
            $tmpname = $destination . $relativePath;
            if (substr($filename, -1) == "/")  // Directory
            {
                if (!@mkdir($tmpname, 0755, true))
                    $errors[$i] = $filename;
            }
            else
            {
                if (dirname($relativePath) != ".")
                {
                    if (!is_dir($destination . dirname($relativePath)))
                    {
                        // New dir (for file)
                         @mkdir($tmpname, 0755, true);

                    }
                }
                // New file
                if (@file_put_contents($tmpname, $this->getFromIndex($i)) === false)
                    $errors[$i] = $filename;
               
            }
        }
        return $errors;
    }
}
?>
