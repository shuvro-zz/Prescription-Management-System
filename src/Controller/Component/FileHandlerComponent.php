<?php
/*
 Uses case:
 .ctp :
 <input type="file" name="image" />

 Controller:
 public $components = array('FileHandler');

 $file = $this->params["form"]["image"];

 $result = $this->FileHandler->uploadImage($file);
 $result = $this->FileHandler->thumbnail_img($file,100,100);
 $result = $this->FileHandler->download('C:/file.txt');

 *
 * */

namespace App\Controller\Component;

use Cake\Controller\Component;

class FileHandlerComponent extends Component
{
	var $controller;

    public $components = array('Session');

	var $_errorMsg = null;
	var $_uploadimgname = null;

    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->controller = $this->_registry->getController();
    }

	function uploadImage($file, $filepath = null )
	{
        if (isset($file['name'])) {

			if(!$filepath) {
				$controller_name = strtolower($this->controller->name);
				$filepath = WWW_ROOT.'uploads' . DS . $controller_name;
            }

			if (!is_dir($filepath) && !is_file($filepath)) {
				$this->createFolder($filepath, '0777');
			}

			if (!$this->isImage($file['name'])) {
				$this->Session->setFlash(__('Sample could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				return false;
			}

			//set image name
			$this->setUniqueName($filepath, $file['name']);
			$filepath = $filepath . DS . $this->_uploadimgname;
			if (!$this->upload($file['tmp_name'], $filepath)) {
				$this->Session->setFlash(__('Error. Unable to upload file', true), 'default', array('class' => 'error'));
				return false;
			}
		}
		return true;
	}

	function uploadVideo( $file, $filepath = null )
	{
		if (isset($file['name'])) {

			if(!$filepath) {
				$controller_name = strtolower($this->controller->name);
				$filepath = WWW_ROOT.'uploads'.DS.$controller_name;
			}

			if (!is_dir($filepath) && !is_file($filepath)) {
				$this->createFolder($filepath,'0777');
			}

			if (!$this->isVideo($file['name'])) {
				$this->Session->setFlash(__('Sample could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				return false;
			}

			//set image name
			$this->setUniqueName($filepath, $file['name']);

			$filepath = $filepath.DS.$this->_uploadimgname;

			if (!$this->upload($file['tmp_name'], $filepath)) {
				$this->Session->setFlash(__('Error. Unable to upload file', true), 'default', array('class' => 'error'));
				return false;
			}
		}
		return true;
	}

	function uploadfile( $file, $filepath = null )
	{
		if (isset($file['name'])) {
			if(!$filepath) {
				$controller_name = strtolower($this->controller->name);
				$filepath = WWW_ROOT.'uploads'.DS.$controller_name;
            }

			if (!is_dir($filepath) && !is_file($filepath)) {
				$this->createFolder($filepath,'0777');
			}

			//set image name
			$this->setUniqueName($filepath, $file['name']);
			$filepath = $filepath.DS.$this->_uploadimgname;

			if (!$this->upload($file['tmp_name'], $filepath)) {
				$this->Session->setFlash(__('Error. Unable to upload file', true), 'default', array('class' => 'error'));
				return false;
			}
		}
		return true;
	}

	function upload($src, $dest){

		$ret = false;

		$dest = $this->clean($dest);
		$baseDir = dirname($dest);

		if (is_writeable($baseDir) && move_uploaded_file($src, $dest)) {
            $ret = true;
			/*if ($this->setPermissions($dest)) {
				$ret = true;
			}
			else {
				//JError::raiseWarning(21, JText::_('WARNFS_ERR01'));
			}*/
		}
		else {
			//JError::raiseWarning(21, JText::_('WARNFS_ERR02'));
		}

		return $ret;

	}

	function setPermissions($path, $filemode = '0644', $foldermode = '0755') {

		// Initialize return value
		$ret = true;

		if (is_dir($path))
		{
			$dh = opendir($path);
			while ($file = readdir($dh))
			{
				if ($file != '.' && $file != '..') {
					$fullpath = $path.'/'.$file;
					if (is_dir($fullpath)) {
						if (!$this->setPermissions($fullpath, $filemode, $foldermode)) {
							$ret = false;
						}
					} else {
						if (isset ($filemode)) {
							if (!@ chmod($fullpath, octdec($filemode))) {
								$ret = false;
							}
						}
					} // if
				} // if
			} // while
			closedir($dh);
			if (isset ($foldermode)) {
				if (!@ chmod($path, octdec($foldermode))) {
					$ret = false;
				}
			}
		}
		else
		{
			if (isset ($filemode)) {
				$ret = @ chmod($path, octdec($filemode));
			}
		} // if
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

	function deleteFile( $imagename, $filepath = null ){
			
		if(!$filepath) {
			$controller_name = strtolower($this->controller->name);
			$imgpath = WWW_ROOT.'uploads'.DS.$controller_name.DS.$imagename;
			$thubm_imgpath = WWW_ROOT.'uploads'.DS.$controller_name.DS.'resized'.DS.$imagename;
		}
		else{
			$imgpath = $filepath.DS.$imagename;
			$thubm_imgpath = $filepath.DS.'resized'.DS.$imagename;
		}

		if (is_file($imgpath)) {
			unlink($imgpath);
		}

		if (is_file($thubm_imgpath)) {
			unlink($thubm_imgpath);
		}

	}

	function createFolder($path, $mode = 0777) {

		$folder_permissions = $mode;
		$folder = $path;

        //$this->log($folder,'debug');

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

	function getExt($file) {
		$ext = trim(substr($file,strrpos($file,".")+1,strlen($file)));
		return $ext;
	}

	function setUniqueName ($filePath, $fileName) {

		$fileName = $this->makeSafe($fileName);
		if( file_exists($filePath.DS.$fileName) ){
			$this->_uploadimgname = time() . "_".$fileName;
		}
		else{
			$this->_uploadimgname =  $fileName;
		}

	}

	function makeSafe($file) {
		$regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#', '/\s+/');
        //pr($regex);die;
		return preg_replace($regex, '_', $file);
	}

	function isImage( $fileName )
	{
		static $imageTypes = 'xcf|odg|gif|jpg|png|bmp';
		return preg_match("/$imageTypes/i",$fileName);
	}

	function isVideo( $fileName )
	{
		static $imageTypes = 'swf|flv|mp3|wma|mp4';
		return preg_match("/$imageTypes/i",$fileName);
	}

	//return $this->log_proper_error($file['error']);
	function log_proper_error($err_code) {
		switch ($err_code) {
			case UPLOAD_ERR_NO_FILE:
				return 0;
			case UPLOAD_ERR_INI_SIZE:
				$e = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$e = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
				break;
			case UPLOAD_ERR_PARTIAL:
				$e = 'The uploaded file was only partially uploaded.';
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$e = 'Missing a temporary folder.';
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$e = 'Failed to write file to disk.';
				break;
			case UPLOAD_ERR_EXTENSION:
				$e = 'File upload stopped by extension.';
				break;
			default:
				$e = 'Unknown upload error. Did you add array(\'type\' => \'file\') to your form?';
		}
		return $this->log_cakephp_error_and_return($e);
	}


	function download($abspath)
	{

		$file = basename($abspath);

		if (!is_file($abspath)) {
			return false;
		}

		//get filesize and extension
		$size 	= filesize($abspath);
		$ext 	= strtolower($this->getExt($abspath));

		// required for IE, otherwise Content-disposition is ignored
		if(ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}

		switch( $ext )
		{
			case "pdf":
				$ctype = "application/pdf";
				break;
			case "exe":
				$ctype="application/octet-stream";
				break;
			case "rar":
			case "zip":
				$ctype = "application/zip";
				break;
			case "txt":
				$ctype = "text/plain";
				break;
			case "doc":
				$ctype = "application/msword";
				break;
			case "xls":
				$ctype = "application/vnd.ms-excel";
				break;
			case "ppt":
				$ctype = "application/vnd.ms-powerpoint";
				break;
			case "gif":
				$ctype = "image/gif";
				break;
			case "png":
				$ctype = "image/png";
				break;
			case "jpeg":
			case "jpg":
				$ctype = "image/jpg";
				break;
			case "mp3":
				$ctype = "audio/mpeg";
				break;
			default:
				$ctype = "application/force-download";
		}

		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers
		header("Content-Type: $ctype");
		//quotes to allow spaces in filenames
		header("Content-Disposition: attachment; filename=\"".$file."\";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".$size);
		ob_clean();
		flush();
		readfile($abspath);

		return true;
	}


	function resizeImage($orgimagepath, $thumbwidth, $thumbheight, $resizeFollow = 'both'){
		$resizeWidthHeight = Array();

		$imagepath = $orgimagepath;

		$dot = strrpos($imagepath, '.') + 1;
		$Ext =  substr($imagepath, $dot);
		$Ext = ".".$Ext;


		if(! is_file( $imagepath ) ) {
			$imagepath = str_replace($Ext, strtolower($Ext),$orgimagepath);
			if(! is_file( $imagepath ) ) {
				$imagepath = str_replace($Ext, strtoupper($Ext),$orgimagepath);
				if(! is_file( $imagepath ) ) {
					$imagepath = "";
				}
			}
		}

		if($imagepath){

			// Get the original geometry and calculate scales
			list($orgwidth, $orgheight) = getimagesize($imagepath);

			if($resizeFollow == 'width'){
				$modwidth = round($thumbwidth);
				$x = $orgwidth / $thumbwidth;
				$modheight  = round($orgheight/$x);
			}

			else if($resizeFollow == 'height'){
				$modheight = round($thumbheight);
				$x = $orgheight / $thumbheight;
				$modwidth  = round($orgwidth/$x);
			}
			else if($resizeFollow == 'max_width'){
				if($thumbwidth > $orgwidth){
					$modwidth = round($thumbwidth);
					$x = $orgwidth / $thumbwidth;
					$modheight  = round($orgheight/$x);
				}
				else{
					$modwidth = $thumbwidth;
					$ratio_orig = $orgwidth / $orgheight;
					$modheight = round($thumbwidth / $ratio_orig);
				}
			}

			else if($resizeFollow == 'max_height'){
				if($thumbheight > $orgheight){
					$modheight = round($thumbheight);
					$x = $orgheight / $thumbheight;
					$modwidth  = round($orgwidth/$x);
				}
				else{
					$modheight = $thumbheight;
					$ratio_orig = $orgwidth / $orgheight;
					$modwidth = round($thumbheight * $ratio_orig);
				}
			}
			else if($resizeFollow == 'max'){

				$modwidth = $thumbwidth;
				$modheight = $thumbheight;

				$ratio_orig = $orgwidth / $orgheight;

				if ($thumbwidth / $thumbheight > $ratio_orig) {
					$modwidth = round($thumbheight * $ratio_orig);
				} else {
					$modheight = round($thumbwidth / $ratio_orig);
				}
			}

			else{
				if ($orgheight < $thumbheight && $orgwidth < $thumbwidth){
					$modheight = $orgheight;
					$modwidth  = $orgwidth;
				}
				else{

					if ($orgwidth < $orgheight){ //(shrink image by height to fit)
						$modheight = round($thumbheight);
						$x = $orgheight / $thumbheight;
						$modwidth  = round($thumbheight/$x);

					}

					if ($orgwidth > $orgheight){ // (shrink image by width to fit)
						$modwidth = round($thumbwidth);
						$x = $orgwidth / $thumbwidth;
						$modheight  = round($thumbwidth/$x);
					}
				}
			}

			$resizeWidthHeight['width'] = $modwidth;
			$resizeWidthHeight['height'] = $modheight;
		}
		return $resizeWidthHeight;
	}

	function thumbnail_img($file, $thumbWidth, $thumbHeight, $filepath = null){

		if (isset($file['name'])) {

			if(!$filepath) {
				$controller_name = strtolower($this->controller->name);
				$filepath = WWW_ROOT.'uploads'.DS.$controller_name;
				$thubm_imgpath = WWW_ROOT.'uploads'.DS.$controller_name.DS.'resized';
			}
			else{
				$thubm_imgpath = $filepath.DS.'resized';
			}

			if (!is_dir($thubm_imgpath) && !is_file($thubm_imgpath)) {
				$this->createFolder($thubm_imgpath,'0777');
			}

			if (!$this->isImage($file['name'])) {
				$this->Session->setFlash(__('Sample could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				return false;
			}

			if (!$this->Thumbnail( $filepath.DS.$this->_uploadimgname, $thubm_imgpath.DS.$this->_uploadimgname, $thumbWidth, $thumbHeight )) {
				$this->Session->setFlash(__('Error. Unable to upload file', true), 'default', array('class' => 'error'));
				return false;
			}
		}
		return true;
	}


	function Thumbnail($sourcePath,$thumbPath,$thumbWidth,$thumbHeight) {
		//make sure the GD library is installed
		if(!function_exists("gd_info")) {
			echo 'You do not have the GD Library installed.  This class requires the GD library to function properly.' . "\n";
			echo 'visit http://us2.php.net/manual/en/ref.image.php for more information';
			exit;
		}
		//initialize variables
		$errmsg               = '';
		$error                = false;
		$fileName             = $sourcePath;

		//check to see if file exists
		if(!file_exists($fileName )) {
			$errmsg = 'File not found';
			$error = true;
		}
		//check to see if file is readable
		elseif(!is_readable($fileName )) {
			$errmsg = 'File is not readable';
			$error = true;
		}

		//if there are no errors, determine the file format
		if($error == false) {
			//check if gif
			if(stristr(strtolower($fileName ),'.gif')) $format = 'GIF';
			//check if jpg
			elseif(stristr(strtolower($fileName ),'.jpg') || stristr(strtolower($fileName ),'.jpeg')) $format = 'JPG';
			//check if png
			elseif(stristr(strtolower($fileName ),'.png')) $format = 'PNG';
			//unknown file format
			else {
				$errmsg = 'Unknown file format';
				$error = true;
			}
		}

		//initialize resources if no errors
		if($error == false) {
            switch($format) {
                case 'GIF':
                    $sourceImage = imagecreatefromgif($sourcePath);
                    $sourceWidth = imagesx($sourceImage);
                    $sourceHeight = imagesy($sourceImage);

                    $targetImage = imagecreatetruecolor($thumbWidth,$thumbWidth);
                    imagecopyresampled($targetImage,$sourceImage,0,0,0,0,$thumbWidth,$thumbHeight,imagesx($sourceImage),imagesy($sourceImage));
                    imagegif($targetImage,$thumbPath);
                    break;
                case 'JPG':
                case 'JPEG' :

                    $sourceImage = imagecreatefromjpeg($sourcePath);
                    $sourceWidth = imagesx($sourceImage);
                    $sourceHeight = imagesy($sourceImage);

                    $targetImage = imagecreatetruecolor($thumbWidth,$thumbWidth);
                    imagecopyresampled($targetImage,$sourceImage,0,0,0,0,$thumbWidth,$thumbHeight,imagesx($sourceImage),imagesy($sourceImage));
                    imagejpeg($targetImage,$thumbPath,100);
                    break;

                case 'PNG':
                    $sourceImage = imagecreatefrompng($sourcePath);
                    $sourceWidth = imagesx($sourceImage);
                    $sourceHeight = imagesy($sourceImage);

                    $targetImage = imagecreatetruecolor($thumbWidth,$thumbWidth);
                    imagecopyresampled($targetImage,$sourceImage,0,0,0,0,$thumbWidth,$thumbHeight,imagesx($sourceImage),imagesy($sourceImage));
                    imagepng($targetImage,$thumbPath);
                    break;
            }

		}

		if($error == true) {
			$this->Session->setFlash(__($errmsg, true), 'default', array('class' => 'error'));
			return false;
		}
		return true;
	}

}