<?php

namespace App\Http\Services;

use App\Mail\NotificationMailable;
use Exception;
use Illuminate\Support\Facades\Mail;

class MailerService
{
    public static function send($data)
    {
        try {
            $subject = $data->subject;
            $body = $data->body;
            $to = $data->to;
            $cc = $data->cc ?? [];

            $template = new NotificationMailable($subject, $body);

            Mail::to($to)->cc($cc)->queue($template);

            logger('Correo enviado correctamente a ' . $to);
        } catch (Exception $e) {
            logger('Error al enviar el correo: ' . $e->getMessage());
        }
    }
}
