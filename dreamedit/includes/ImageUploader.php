<?php


class ImageUploader
{

    /**
     * @var string
     */
    private $tempDir;
    /**
     * @var string
     */
    private $uploadFolder;
    /**
     * @var string[]
     */
    private $extensions;

    /**
     * ImageUploader constructor.
     */
    public function __construct()
    {
        $this->extensions = array(
            ".jpg",
            ".jpeg",
            ".png",
            ".gif",
            ".JPG",
            ".JPEG",
            ".PNG",
            ".GIF"
        );
    }

    /**
     * @param string $filePath
     * @param string $prefix
     * @return string[]
     */
    private function uploadWithExtension($filePath, $prefix) {
        $images = array();
        if(file_exists($filePath)) {
            $guidTop = $prefix.sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
            $guidThumb = "thumb_".$guidTop;
            Dreamedit::scaleImage($filePath,array(
                array("destination" => dirname(__FILE__)."/../../files/Image/auto-iline/{$this->uploadFolder}/{$guidTop}.jpg", "size" => 1600),
                array("destination" => dirname(__FILE__)."/../../files/Image/auto-iline/{$this->uploadFolder}/{$guidThumb}.jpg", "size" => 100),
            ));
            $images['high'] = "/files/Image/auto-iline/{$this->uploadFolder}/{$guidTop}.jpg";
            $images['low'] = "/files/Image/auto-iline/{$this->uploadFolder}/{$guidThumb}.jpg";
        }
        return $images;
    }

    /**
     * @return bool
     */
    function prepareUpload() {
        $this->tempDir = Dreamedit::tempdir();

        $zip = new ZipArchive;
        if (!empty($_FILES['zip_file']['tmp_name'][0]) && $zip->open($_FILES['zip_file']['tmp_name'][0]) === TRUE) {
            $zip->extractTo($this->tempDir);
            $zip->close();
            $this->uploadFolder = time().sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
            mkdir(dirname(__FILE__)."/../../files/Image/auto-iline/".$this->uploadFolder);
        } else {
            return false;
        }
        return true;
    }

    /**
     * @param string $fileName
     * @param string $prefix
     * @param bool $notNeedExtension
     * @return string[]
     */
    function upload($fileName, $prefix = "", $notNeedExtension = false) {

        $images = array();
        if($notNeedExtension) {
            $images = $this->uploadWithExtension($this->tempDir."/".$fileName, $prefix);
        }

        $hex = bin2hex($fileName);
        $hex = str_replace("d0b9","d0b8cc86", $hex);

//        $files = glob($this->tempDir."/*");
//
//        foreach ($files as $file) {
//            if(is_file($file)) {
//                var_dump($file);
//            }
//        }
//
//        var_dump($hex);
//
        $fileName = pack('H*', $hex);
//
//        var_dump($fileName);

        foreach ($this->extensions as $extension) {
            $filePath = $this->tempDir."/".$fileName.$extension;
            if(!file_exists($filePath)) {
                continue;
            } else {
                $images = $this->uploadWithExtension($filePath, $prefix);
                break;
            }
        }

        return $images;

    }

    function endUpload() {
        $it = new RecursiveDirectoryIterator($this->tempDir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($this->tempDir);
    }
}