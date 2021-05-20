<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Homework;
use App\Post;

class postHomework extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:homework';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $scheduledHomeworkArr = Homework::select("*")
                            ->whereNull('postId')
                            ->where('deadline', '<', \Carbon\Carbon::now()->setTimezone('Asia/Shanghai'))
                            ->get();
        echo 'Hello '.$scheduledHomeworkArr.'!'.\Carbon\Carbon::now()->setTimezone('Asia/Shanghai');
        foreach ($scheduledHomeworkArr as $key => $scheduledHomework){
            echo 'Compare '.$scheduledHomework->deadline.'!'.\Carbon\Carbon::now()->setTimezone('Asia/Shanghai');
            $postId = Post::create([
                'contentId' => 14,
                'userId' => $scheduledHomework->userId,
                'schoolId' => $scheduledHomework->schoolId,
                'classId' => $scheduledHomework->lessonId
            ])->id;
            $scheduledHomework['postId'] = $postId;
            $scheduledHomework->save();
        }
    }
}
