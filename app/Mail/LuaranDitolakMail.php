<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LuaranDitolakMail extends Mailable
{
    use Queueable, SerializesModels;

    public $statusBerkas;
    public $namaMahasiswa;

    public function __construct($statusBerkas, $namaMahasiswa)
    {
        $this->statusBerkas = $statusBerkas;
        $this->namaMahasiswa = $namaMahasiswa;
    }

    public function build()
    {
        $message = $this->view('pages.notification.luaran-ditolak-notification')
            ->subject('Ajuan Berkas Luaran Ditolak')
            ->with([
                'statusBerkas' => $this->statusBerkas,
                'namaMahasiswa' => $this->namaMahasiswa
            ]);

        if ($this->statusBerkas->file_berkas != null) {
            $documentPath = storage_path('app/public/store/luaran-berkas/' . $this->statusBerkas->file_berkas);

            $message->attach($documentPath, [
                'as' => $this->statusBerkas->file_berkas,
                'mime' => mime_content_type($documentPath),
            ]);
        } 

        if ($this->statusBerkas->hasAdditionalAttachment()) {
            $additionalAttachmentPath = storage_path('app/public/store/other/' . $this->statusBerkas->additionalAttachment);

            $message->attach($additionalAttachmentPath, [
                'as' => $this->statusBerkas->additionalAttachment,
                'mime' => mime_content_type($additionalAttachmentPath),
            ]);
        }

        return $message;
    }


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
}