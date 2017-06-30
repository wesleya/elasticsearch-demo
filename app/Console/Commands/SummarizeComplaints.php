<?php

namespace App\Console\Commands;

use App\Complaint;
use App\ComplaintSummaries;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Class SummarizeComplaints
 * @package App\Console\Commands
 */
class SummarizeComplaints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summarize:complaints
        {--throttle=1000 : microseconds to throttle between each document. default 1000.}
        {--production} : send data to elasticsearch instance. dry run otherwise.
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update complaints_summary table. example: php artisan summarize:complaints';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("querying for complaints...");
        $complaints = $this->getComplaints();
        $progress = $this->output->createProgressBar(count($complaints));
        $today = Carbon::now();


        foreach($complaints as $complaint) {
            $summary = $this->createSummaryRow($complaint, $today);

            $progress->advance();
            usleep($this->option('throttle'));
        }

        $progress->finish();
        $this->info("completed!");
    }

    protected function getComplaints()
    {
        return Complaint::select('company', 'product')
            ->addSelect(DB::raw('COUNT(*) as count'))
            ->groupBy('company', 'product')
            ->get();
    }

    protected function createSummaryRow($complaint, $currentDate)
    {
        $complaint->date_summarized = $currentDate;

        return ComplaintSummaries::create($complaint->toArray());
    }
}
