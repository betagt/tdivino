<?php

namespace Modules\Transporte\Services;

class ChamadaOneSginalService
{
    public static function sendNotificationUsingTags($message, $tags, $url = null, $data = null, $buttons = null, $schedule = null){
        \OneSignal::sendNotificationUsingTags($message, $tags, $url = null, $data = null, $buttons = null, $schedule = null);
    }

    public function sendNotificationToCategoryAndTag($message, $tags, $channel_id, $url = null, $data = null, $buttons = null, $schedule = null) {
        $contents = array(
            "en" => $message
        );

        $params = array(
            'contents' => $contents,
            'android_channel_id' => $channel_id,
            'tags' => $tags,
        );

        if (isset($url)) {
            $params['url'] = $url;
        }

        if (isset($data)) {
            $params['data'] = $data;
        }

        if (isset($buttons)) {
            $params['buttons'] = $buttons;
        }

        if(isset($schedule)){
            $params['send_after'] = $schedule;
        }

        $this->sendNotificationCustom($params);
    }

    private function sendNotificationCustom($params){
        \OneSignal::sendNotificationCustom($params);
    }
}