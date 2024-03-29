<?php

namespace Illuminate\Auth\Notifications;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification
{
    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        // return (new MailMessage)
        //     ->subject(Lang::getFromJson('Verify Email Address'))
        //     ->line(Lang::getFromJson('Please click the button below to verify your email address.'))
        //     ->action(
        //         Lang::getFromJson('Verify Email Address'),
        //         $this->verificationUrl($notifiable)
        //     )
        //     ->line(Lang::getFromJson('If you did not create an account, no further action is required.'));
        return (new MailMessage)
            ->subject(Lang::getFromJson('Verifieer je e-mailadres'))
            ->line(Lang::getFromJson('Gelieve op de onderstaande link te klikken om je e-mail te bevestigen.'))
            ->action(
                Lang::getFromJson('Verifieer je e-mailadres'),
                $this->verificationUrl($notifiable)
            )
            ->line(Lang::getFromJson('Opgepast! Deze link is maar één uur geldig. Ga naar de website en login om een nieuwe mail te verkrijgen. Indien je geen account hebt gemaakt, hoef je geen verdere actie te ondernemen.'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
