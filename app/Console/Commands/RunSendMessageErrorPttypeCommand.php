<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunSendMessageErrorPttypeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:error_pttype';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'เอาไว้ส่งแจ้งเตือนเมื่อมีสิทธิ์การรักษาของคนไข้ไม่ถูกต้องเพื่อให้เจ้าหน้าที่ผู้รับผิดชอบทำการแก้ไขข้อมูลให้ถูกต้อง';

    /**
     * Execute the console command.
     */
    public function handle() {
        $controller = new \App\Http\Controllers\Alert\PttypeErrorController; // เรียก Controller
        $controller->CheckPttype(new \Illuminate\Http\Request); // เรียกฟังก์ชัน
    }
}
