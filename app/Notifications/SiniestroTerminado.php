<?php

namespace App\Notifications;

use App\Providers\RouteServiceProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class SiniestroTerminado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance
     */
    private $siniestroid;
    private $nombreSiniestro;
    private $usuarioid;
    private $aseguradoraId;

    public function __construct($siniestro_id, $nombre_siniestro, $aseguradora_id, $usuario_id)
    {
        $this->siniestroid = $siniestro_id;
        $this->nombreSiniestro = $nombre_siniestro;
        $this->aseguradoraId = $aseguradora_id;
        $this->usuarioid = $usuario_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = config('app.frontend_url') . RouteServiceProvider::NOTIFICACIONES;
        return (new MailMessage)
            ->line('Ha concluido un siniestro.')
            ->line('el siniestro ' . $this->nombreSiniestro)
            ->action('Ver Notificaciones', $url)
            ->line('gracias por recibir la notificación!');
    }

    // Almacena las notificaciones en la base de datos
    public function toDatabase($notifiable)
    {
        return [
            'motivo'=> 'Siniestro Terminado',
            'siniestro_id' => $this->siniestroid,
            'siniestro' => $this->nombreSiniestro,
            'aseguradora'=>$this->aseguradoraId,
            'usuario' => $this->usuarioid,
            'fecha'=>Carbon::now()->diffForHumans()
        ];
    }
}
