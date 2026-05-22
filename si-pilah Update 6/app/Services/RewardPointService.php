<?php

namespace App\Services;

use App\Models\Report;
use App\Models\User;

class RewardPointService
{
    const REWARD_POINTS_PER_COMPLETED_REPORT = 10;

    /**
     * Awards points to a user when a report is completed
     * 
     * @param Report $report
     * @return bool
     */
    public function awardPointsForCompletedReport(Report $report): bool
    {
        // Check if already rewarded to prevent duplicate rewards
        if ($report->is_rewarded) {
            return false;
        }

        // Only reward when status is "Selesai"
        if ($report->status !== 'Selesai') {
            return false;
        }

        // Get the report's user
        $user = $report->user;

        // Award points to user
        $user->increment('points', self::REWARD_POINTS_PER_COMPLETED_REPORT);

        // Mark report as rewarded
        $report->update(['is_rewarded' => true]);

        // Optionally create a Reward record for tracking
        $user->rewards()->create([
            'points' => self::REWARD_POINTS_PER_COMPLETED_REPORT,
        ]);

        return true;
    }

    /**
     * Get reward points for a user
     * 
     * @param User $user
     * @return int
     */
    public function getUserTotalPoints(User $user): int
    {
        return $user->points ?? 0;
    }

    /**
     * Reset user points (admin function)
     * 
     * @param User $user
     * @return bool
     */
    public function resetUserPoints(User $user): bool
    {
        $user->update(['points' => 0]);
        return true;
    }
}
