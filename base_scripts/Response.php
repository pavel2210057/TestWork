<?php

class Response {
    public static function format(int $code, string $mess) : string {
        return json_encode([
            'code' => $code,
            'message' => $mess
        ]);
    }
}