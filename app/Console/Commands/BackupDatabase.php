<?php

namespace App\Console\Commands;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database to S3';

    private S3Client $s3;

    private string $bucket;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->s3 = new S3Client([
            'region' => env('AWS_S3_REGION'),
            'version' => env('AWS_S3_VERSION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY'),
                'secret' => env('AWS_SECRET_KEY'),
            ],
        ]);
        $this->bucket = env('AWS_S3_BUCKET');
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        exec(sprintf(
            'mysqldump -h %s -u %s -p%s %s',
            env('DB_HOST'),
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
        ), $output);

        $objectKey = sprintf('db-%s.sqlite', Carbon::now()->format('Y-m-d'));
        $objectBody = implode("\n", $output);
        try {
            if ($this->s3->doesObjectExist($this->bucket, $objectKey)) {
                Log::info('Database backup already exists', [
                    'bucket' => $this->bucket,
                    'objectKey' => $objectKey,
                ]);
                $this->output->info('Database backup already exists: ' . $objectKey);

                return static::SUCCESS;
            }

            $this->s3->upload($this->bucket, $objectKey, $objectBody);
        } catch (S3Exception $e) {
            Log::error('Failed to upload database backup to S3', [
                'bucket' => $this->bucket,
                'objectKey' => $objectKey,
                'message' => $e->getMessage(),
            ]);
            $this->output->error('Failed to upload database backup to S3: ' . $e->getMessage());

            return static::FAILURE;
        }

        Log::info('Database backup uploaded to S3', [
            'bucket' => $this->bucket,
            'objectKey' => $objectKey,
        ]);
        $this->output->success('Database backup uploaded to S3');

        return static::SUCCESS;
    }
}
