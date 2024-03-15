<?php

namespace simpl;

class Response {
    private $code;
    private $message;
    private $data;

    public function __construct( $code = 200, $message = 'OK', $data = [] ) {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function __invoke() {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}