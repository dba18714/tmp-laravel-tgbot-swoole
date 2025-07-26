#!/bin/sh

# 确保环境变量正确设置
export OCTANE_SWOOLE_TICK=false

# 清除所有缓存
echo "Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 缓存配置以提高性能
echo "Caching configurations..."
php artisan config:cache

# 等待一秒确保清理完成
sleep 1

# 启动 Octane 服务器
echo "Starting Octane server..."
php artisan octane:start --host=0.0.0.0 --port=7001
