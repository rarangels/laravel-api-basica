<?php
/**
 * Created by PhpStorm.
 * User: rarangels
 * Date: 19/10/20
 * Time: 5:06 p. m.
 * Author: Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */

namespace Rarangels\ApiBasica\Traits;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

/**
 * Trait Notification
 *
 * @package Rarangels\ApiBasica\Traits
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
trait Notification
{
    use Queueable;

    /**
     * @var
     */
    public $title = 'Título de prueba';

    /**
     * @var string
     */
    public $message = 'Mensaje de prueba';

    /**
     * @var string
     */
    public $action_url;

    /**
     * @var array
     */
    public $data = [];

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];
        ! config('api-basica.general.send_mail_notification', false) ?: array_push($via, 'mail');

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->email($notifiable);
    }

    /**
     * @param $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function email($notifiable)
    {
        $url = URL::to('');

        return (new MailMessage)->markdown('emails.new.notification')->subject($this->title)->greeting('Hola '.$notifiable->fullName)->line($this->message)->action('Ver detalle', $url)->salutation('Agradecemos la atención prestada a esta notificación.');
    }

    /**
     * @param $notifiable
     * @return string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function render($notifiable)
    {
        return $this->email($notifiable)->render();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }

    /**
     * Set the desired delay for the job.
     *
     * @param \DateTimeInterface|\DateInterval|int|null $delay
     * @return \Rarangels\ApiBasica\Traits\Notification
     */
    public function delay($delay)
    {
        (env('QUEUE_CONNECTION') !== 'database') ?: $this->delay = $delay;

        return $this;
    }
}
