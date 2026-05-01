<?php

namespace App\Console\Commands;

use App\Models\Rent;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RentGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rent-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every month rent auto generate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();

        // Ensure the cron is only triggered on the 1st of the month


        // Fetch all current residents
        $tenants = Tenant::where('status', 'current_resident')->get();

        foreach ($tenants as $tenant) {
            $contractStartDate = Carbon::parse($tenant->contract_start_date);

            // Skip if the contract has ended or is inactive
            if ($tenant->contract_end_date && Carbon::parse($tenant->contract_end_date)->isPast()) {
                continue;
            }

            if ($tenant->rent_billing_cycle === 'annually') {
                $nextAnnualBillingDate = $contractStartDate->copy()->addYears(
                    $today->year - $contractStartDate->year
                );

                // Generate rent only if it's the annual billing month
                if ($nextAnnualBillingDate->month === $today->month && $nextAnnualBillingDate->lessThanOrEqualTo($today)) {
                    $this->createRentEntry($tenant, $nextAnnualBillingDate, $tenant->rent_amount, false);
                    continue;
                }

                // Skip rent generation if it's not the billing month
                $this->info("Skipping Tenant ID: {$tenant->id}. Next annual billing date: {$nextAnnualBillingDate->format('F Y')}.");
                continue;
            }

            $lastMonth = $today->copy()->subMonth(); // Calculate the previous month
            $startOfLastMonth = $lastMonth->copy()->startOfMonth();
            $endOfLastMonth = $lastMonth->copy()->endOfMonth();

            if ($contractStartDate->lessThanOrEqualTo($startOfLastMonth)) {
                // Contract started before or on the first day of the previous month
                $this->createRentEntry($tenant, $lastMonth, $tenant->rent_amount, false);
            } elseif ($contractStartDate->between($startOfLastMonth, $endOfLastMonth)) {
                // Contract started in the middle of the previous month
                $daysRented = $endOfLastMonth->diffInDays($contractStartDate) + 1;

                // Calculate rent amount based on the number of days rented
                $rentAmount = ($tenant->rent_amount / $endOfLastMonth->daysInMonth) * abs($daysRented);

                // Ensure rentAmount is calculated correctly and entry is created
                $this->createRentEntry($tenant, $lastMonth, $rentAmount, true);
            } else {
                // Contract starts after the previous month
                $this->info("Skipping Tenant ID: {$tenant->id}. Contract starts after the last rent period.");
            }

        }

        $this->info('Rent generation completed.');
    }

    /**
     * Create a rent entry.
     *
     * @param Tenant $tenant
     * @param Carbon $month
     * @param float $rentAmount
     * @param bool $isProrated
     * @return void
     */
    private function createRentEntry(Tenant $tenant, Carbon $month, float $rentAmount, bool $isProrated): void
    {
        Rent::create([
            'tenant_id' => $tenant->id,
            'rent_for_year' => $month->year,
            'rent_for_month' => $month->format('F'),
            'rent_amount' => round($rentAmount, 2),
            'status' => 'unpaid',
        ]);

        $rentType = $isProrated ? 'Prorated' : 'Full';
        $this->info("{$rentType} rent generated for Tenant ID: {$tenant->id} for {$month->format('F Y')}. Amount: " . round($rentAmount, 2));
    }
}
