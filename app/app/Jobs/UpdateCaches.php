<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Domain;


class UpdateCaches implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected int $cacheMinutes;

	public function __construct(protected Domain $domain){
		$this->cacheMinutes = 15;
	}
	
	/**
	* Execute the job.
	*/
	public function handle(): void
	{
		(new UpdateOrCreateDnsCache($this->domain, $this->cacheMinutes))->handle();
		(new UpdateOrCreateHttpCache($this->domain, $this->cacheMinutes))->handle();
		(new UpdateOrCreateHtmlCache($this->domain, $this->cacheMinutes))->handle();
	}
}
