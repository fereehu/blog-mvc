<?php

class Chat extends Controller {

    public function index() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        if (LOGGED_IN == 1) {
            require 'application/views/chat/index.php';
        } else {
            $chat_model = $this->loadModel('ChatModel');
            $messages = $chat_model->getChatLog();
            require 'application/views/chat/signIn.php';
            require 'application/views/chat/log.php';
        }
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

    public function log() {
        require 'application/views/_templates/' . TEMPLATE . '/header.php';
        $chat_model = $this->loadModel('ChatModel');
        $messages = $chat_model->getChatLog();
        require 'application/views/chat/log.php';
        require 'application/views/_templates/' . TEMPLATE . '/footer.php';
    }

}
