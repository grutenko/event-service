<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class SendEmailCreateAccountJob extends Job
{
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::notice('Send create account event '. $this->email);
    }
}
