<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledChange;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessScheduledChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduled:apply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply scheduled changes for employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        ScheduledChange::whereNull('processed_at')
            ->where('effective_date', '<=', $today)
            ->chunk(1000, function ($changes) {
                foreach ($changes as $change) {
                    $employee = Employee::find($change->employee_id);
                    if ($employee) {
                        $employee->update([$change->field => $change->new_value]);
                        $change->update(['processed_at' => now()]);
                    }
                }
            });
    }
}
