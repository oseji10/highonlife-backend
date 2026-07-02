<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class TicketService
{
    /**
     * Generate a QR code as a base64 PNG data URI (embeddable directly in <img src="...">
     * or in a PDF view). Uses endroid/qr-code, which renders via GD — no Imagick required.
     */
    public function qrDataUri(string $data, int $size = 300): string
    {
        $qrCode = new QrCode($data);
        $qrCode->setSize($size);
        $qrCode->setMargin(8);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return $result->getDataUri();
    }

    /**
     * Render a Blade view to raw PDF bytes.
     */
    public function pdf(string $view, array $data = []): string
    {
        return Pdf::loadView($view, $data)
            ->setPaper('a5', 'portrait')
            ->output();
    }
}