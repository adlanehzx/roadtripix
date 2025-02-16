<?php

namespace App\Response;

class FileResponse
{
    public function serveFile(string $filePath, string $fileName)
    {
        if (file_exists($filePath)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            ob_clean();
            flush();

            readfile($filePath);
            exit;
        } else {
            http_response_code(404);
            exit;
        }


        if (!file_exists($filePath)) {

        }

    }
}
