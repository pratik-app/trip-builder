<?php

class ErrorHandler
{
    // Creating function that will throw error in JSON format

    public static function handleException(Throwable $exception): void
    {
        // Setting https status code to 500 this will reference to server error

        http_response_code(500);

        // This echo will show the error code, error message, error file, and line number of error

        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()]);
    }
    public static function handleError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline
    ):bool
    {
        throw new ErrorException($errstr, 0,$errno, $errfile, $errline );
    }
}
?>