<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledChange;
use App\Models\Employee;
use Carbon\Carbon;

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

        $changes = ScheduledChange::whereNull('processed_at')
            ->where('effective_date', '<=', $today)
            ->get();

        foreach ($changes as $change) {
            $employee = Employee::find($change->employee_id);
            if ($employee) {
                $employee->update([$change->field => $change->new_value]);
                $change->update(['processed_at' => now()]);
            }
        }

        $this->info("Scheduled changes applied.");
    }
}
