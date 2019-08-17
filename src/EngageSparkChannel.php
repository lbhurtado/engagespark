<?php

namespace LBHurtado\EngageSpark;

use Illuminate\Support\Arr;
use Illuminate\Notifications\Notification;
use Propaganistas\LaravelPhone\PhoneNumber;

class EngageSparkChannel
{
    /** @var string */
    private $mode;

    /** @var string */
    private $clientRef;

    /** @var EngageSpark */
    protected $smsc;

    public function __construct(EngageSpark $smsc)
    {
        $this->smsc = $smsc;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (! ($to = $this->getRecipients($notifiable, $notification))) {
            return;
        }

        $message = $notification->{'toEngageSpark'}($notifiable);

        if (\is_string($message)) {
            $message = new EngageSparkMessage($message);
        }

        $this->setClientRef($notification)->sendMessage($to, $message);
    }

    /**
     * Gets a list of phones from the given notifiable.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return string[]
     */
    protected function getRecipients($notifiable, Notification $notification)
    {
        return $this->getRecipient($notifiable, $notification);
    }

    /**
     * Gets a list of phones from the given notifiable.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return string[]
     */
    protected function getRecipient($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationFor('engage_spark', $notification);

        if ($to === null || $to === false || $to === []) {
            return '';
        }

        $to = \is_array($to) ? Arr::first($to) : $to;

        return $this->getFormattedMobile($to);
    }

    protected function sendMessage($recipient, EngageSparkMessage $message)
    {
        $this->setMode($message);

        switch ($mode = $this->getMode()) {
            case 'sms':
                $params = [
                    'orgId'   => $this->getOrgId(),
                    'to'      => $recipient,
                    'message' => $message->content,
                    'from'    => $this->getSenderId($message),
                ];
                break;

            case 'topup':
                $params = [
                    'organizationId'  => $this->getOrgId(),
                    'phoneNumber'     => $recipient,
                    'maxAmount'       => $message->air_time,
                    'clientRef'       => $this->getClientRef(),
                ];
                break;

            default:
                # code...
                break;
        }

        // if ($message->sendAt instanceof \DateTimeInterface) {
        //     $params['time'] = '0'.$message->sendAt->getTimestamp();
        // }

        $this->smsc->send($params, $mode);
    }

    protected function getWebHook(EngageSparkMessage $message)
    {
        return $this->smsc->getWebHook($message->mode);
    }

    protected function getOrgId()
    {
        return $this->smsc->getOrgId();
    }

    public function getClientRef()
    {
        return $this->clientRef;
    }

    protected function getSenderId(EngageSparkMessage $message)
    {
        return $message->sender_id ? $message->sender_id : $this->smsc->getSenderId();
    }

    protected function setClientRef(Notification $notification)
    {
        $this->clientRef = $notification->id;

        return $this;
    }

    protected function getMode()
    {
        return $this->mode;
    }

    protected function setMode(EngageSparkMessage $message)
    {
        $this->mode = $message->mode;

        return $this;
    }

    protected function getFormattedMobile($to)
    {
        return tap(PhoneNumber::make($to, 'PH')->formatE164(), function(&$recipient) {
            $recipient = preg_replace('/\D/', '', $recipient);
        });
    }
}
