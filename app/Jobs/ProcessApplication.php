<?php

namespace App\Jobs;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $jobId;
    protected $cvId;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $jobId, $cvId)
    {
        $this->userId = $userId;
        $this->jobId = $jobId;
        $this->cvId = $cvId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Application::create([
            'candidate_id' => $this->userId,
            'job_id' => $this->jobId,
            'cv_id' => $this->cvId,
            'status' => 'pending',
            'applied_at' => now(),
        ]);
    }
}