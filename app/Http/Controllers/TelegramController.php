<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $startTime = microtime(true);
        
        try {
            // 获取更新
            $update = Telegram::getWebhookUpdates();
            
            // 记录接收到的更新
            Log::info('Telegram update received', ['update' => $update]);
            
            // 获取消息内容
            $message = $update->getMessage();
            if ($message !== null) {
                $chat_id = $message->getChat()->getId();
                $text = $message->getText();

                // 记录消息内容
                Log::info('Processing message', ['chat_id' => $chat_id, 'text' => $text]);

                // 处理文本消息
                if ($text) {
                    $processingTime = round((microtime(true) - $startTime) * 1000, 2);
                    $response = Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => "Laravel 你说: {$text}\n处理用时: {$processingTime}ms",
                    ]);
                    
                    // 记录发送响应
                    $processingTime = round((microtime(true) - $startTime) * 1000, 2);
                    Log::info('Message processed', [
                        'text' => $text,
                        'processing_time_ms' => $processingTime
                    ]);
                }
            }

            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            // 记录错误
            Log::error('Telegram webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function setWebhook()
    {
        try {
            $webhookUrl = config('telegram.bots.mybot.webhook_url');
            Log::info('Setting webhook', ['url' => $webhookUrl]);
            
            $response = Telegram::setWebhook(['url' => $webhookUrl]);
            Log::info('Webhook set response', ['response' => $response]);
            
            return response()->json(['status' => 'success', 'result' => $response]);
        } catch (\Exception $e) {
            Log::error('Webhook setting error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
