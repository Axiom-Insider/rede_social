<?php


declare(strict_types=1);


class Response{
    public static function json(int $code, array $data):void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);

        exit;
    }
}