<?php

namespace App\Jobs;

use App\Apricot\Libraries\IntegrationMethods;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetStoreAuthToken extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

	/**
	 * @var \App\Jobs\IntegrationMethods
	 */
	private $integrationMethods;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $method;

	/*
	 * Create a new job instance.
	 *
	 * @return void
	 */
	function __construct($method = 'shopify', $url = '')
	{
		$this->method = $method;
		$this->url = $url;
		$this->integrationMethods = new IntegrationMethods();
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		if($this->job->attempts() > 5)
		{
			// todo: tell user to re-attempt and set status of integration to failed.
			$this->job->delete();
		}

		$api = $this->integrationMethods->getMethodClass($this->method);

		if( $token = $this->integrationMethods->getAuthToken($api) )
		{
			// todo: set site auth token = $token
			// todo: set status of store
			return true;
		}

		$this->job->release(15);
    }
}
