<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $update = Telegram::commandsHandler(true);
        
        // 获取消息内容
        $message = $update->getMessage();
        if ($message !== null) {
            $chat_id = $message->getChat()->getId();
            $text = $message->getText();

            // 简单的回声机器人实现
            if ($text) {
                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => '你说: ' . $text,
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function setWebhook()
    {
        $response = Telegram::setWebhook(['url' => config('telegram.bots.mybot.webhook_url')]);
        return response()->json(['status' => $response]);
    }
}
