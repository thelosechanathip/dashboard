<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunSystemInfoTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:systeminfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'เอาไว้ส่งแจ้งเตือนเมื่อ CPU หรือ RAM มีการใช้งานมากกว่า 80 - 90 % แจ้งเตือนไปยัง Application Telegram!';

    /**
     * Execute the console command.
     */
    public function handle() {
        $controller = new \App\Http\Controllers\IT\SystemInfoController; // เรียก Controller
        $controller->send_error(new \Illuminate\Http\Request); // เรียกฟังก์ชัน
    }

}
