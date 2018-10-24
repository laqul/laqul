<?php

namespace App\Http\Controllers\Api\Traits;

use FCM;
use Carbon\Carbon;
use App\Models\User\User;
use App\Models\User\Notification;
use App\Models\User\MessagingToken;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

trait Notifications
{
    private $retryTimes = 1;

    public function notificate(User $user, $title, $body, $color = 'positive', $payload = [], $type = 'default', $hours = false, $save = false)
    {
        if ($hours) {
            $hasNotification = $user->notifications->where('type', $type)->where('created_at', '>=', Carbon::now()->subHours($hours))->first();
            if ($hasNotification) {
                return true;
            }
        }
        if ($save) {
            Notification::create([
                'user_id' => $user->id,
                'type' => $type,
                'color' => $color,
                'title' => $title,
                'body' => $body,
                'payload' => $payload
            ]);
            $payload['sincronize'] = true;
        }

        $devices = $user->messagingTokens->pluck('token')->toArray();

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)->setSound('default')->setIcon('http://localhost:8080/img/logo.png');
        $notification = $notificationBuilder->build();

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $option = $optionBuilder->build();

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['payload' => json_encode($payload)]);
        $data = $dataBuilder->build();

        $downstreamResponse = $this->send($devices, $option, $notification, $data);

        $this->deleteTokens($downstreamResponse->tokensToDelete());
        $this->deleteTokens(array_keys($downstreamResponse->tokensWithError()));
        $this->updateTokens($downstreamResponse->tokensToModify());
        $this->retry($downstreamResponse->tokensToRetry(), $option, $notification, $data);
        
        return ['success' => $downstreamResponse->numberSuccess(), 'fail' => $downstreamResponse->numberFailure(), 'modify' => $downstreamResponse->numberModification(), 'retry' => count($downstreamResponse->tokensToRetry())];
    }

    private function send($devices, $option, $notification, $data)
    {
        return FCM::sendTo($devices, $option, $notification, $data);
    }

    private function deleteTokens($tokens)
    {
        if (!count($tokens)) {
            return true;
        }
        MessagingToken::whereIn('token', $tokens)->delete();
    }

    private function updateTokens($tokens)
    {
        if (!count($tokens)) {
            return true;
        }
        foreach ($tokens as $key => $value) {
            $current = MessagingToken::where('token', $key)->first();
            if ($current) {
                $current->token = $value;
                $current->save();
            }
        }
    }

    private function retry($devices, $options, $notification, $data)
    {
        if (count($devices) && $this->retryTimes > 0) {
            $this->retryTimes--;
            $this->send($devices, $option, $notification, $data);
        }
    }
}
