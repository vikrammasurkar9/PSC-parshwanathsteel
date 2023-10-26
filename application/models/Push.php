<?php 

class Push {
    //notification title
    private $title;

    //notification message 
    private $message;

    //notification image url 
    private $image;
    private $is_background;

    //initializing values in this constructor
    function __construct() {
        
    }
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setImage($image) {
        $this->image = $image;
    }
    public function setIsBackground($is_background) {
        $this->is_background = $is_background;
    }
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['message'] = $this->message;
        $res['data']['image'] = $this->image;
        $res['data']['timestamp'] = date('Y-m-d G:i:s');
        return $res;
    }
 
}