<?php

class upload{
    public $directory = NULL;
    public $allowed_size = NULL;
    public $allowed_ext = NULL;
    public $check_image_type = false;
    public $file_rename = NULL;
    public $error = NULL;
    public $renadme = NULL;
 
    public function save($file=NULL){
        if(!$this->check_directory()){
            die('Upload dizini yok yada yazma izini geçersiz.');
        }
        if($file==NULL){
            die('class save(\'\') file değeri geçersiz');
        }else{
            if($_FILES[$file]['error']==0 && $_FILES[$file]['size']!=0){
                if(!$this->check_allowed_ext($_FILES[$file])){
                    $this->error[] = array(1,'Geçersiz dosya uzantısı.');
                }elseif(!$this->check_allowed_size($_FILES[$file])){
                    $this->error[] = array(2,'Upload limit aşımı. Maksimum upload boyutu '.$this->allowed_size);
                }elseif(!$this->check_image($_FILES[$file])){
                    $this->error[] = array(3,'Geçersiz resim dosyası');
                }else{
                    if(move_uploaded_file($_FILES[$file]['tmp_name'], $this->directory . $this->path($_FILES[$file]))){
                        return array('file'=>$this->path($_FILES[$file]),'ext'=>pathinfo(basename($_FILES[$file]['name']),PATHINFO_EXTENSION),'size'=>$_FILES[$file]['size']);
                    }else{
                        $this->error[] = array(0,'Upload sırasında hata oluştu');
                        return false;
                    }
                }
            }else{
                $this->error[] = array(0,'Upload sırasında hata oluştu');
                return false;
            }
        }
    }
 
    private function path($file){
        if($this->file_rename==NULL){
            return  basename($file['name']);
        }else{
            return $this->file_rename.'.'.pathinfo(basename($file['name']),PATHINFO_EXTENSION);
        }
    }
 
    private function check_directory(){
        if(is_dir(realpath($this->directory)) || is_writable(realpath($this->directory))){
            return true;
        }
        return false;
    }
 
    private function check_allowed_size($file){
        if($this->allowed_size!=NULL){
            if(!preg_match('#[0-9]++[GMKB]#',$this->allowed_size)){
                return false;
            }
            switch(substr($this->allowed_size,-1)){
                case 'G': $size = intval($this->allowed_size) * pow(1024,3); break;
                case 'M': $size = intval($this->allowed_size) * pow(1024,2); break;
                case 'K': $size = intval($this->allowed_size) * pow(1024,1); break;
                default : $size = intval($this->allowed_size);               break;
            }
            return ($file['size'] <= $size);
        }else{
            return true;
        }
    }
 
    private function check_allowed_ext($file){
        if($this->allowed_ext!=NULL){
            if (in_array(pathinfo($file['name'],PATHINFO_EXTENSION),$this->allowed_ext)){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
 
    private function check_image($file){
        if($this->check_image_type==false){
            return true;
        }else{
            if(!getimagesize($file['tmp_name'])) {
                return false;
            }else{
                return true;
            }
        }
    }
 
}
 
?>