<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class Record
 *
 * @package App\Models
 */
class Record
{
    /**
     * @var
     */
    private $user_id;

    /**
     * @var
     */
    private $onboarding_percentage;

    /**
     * @var
     */
    private $created_at;

    /**
     * @var
     */
    private $count_applications;

    /**
     * @var
     */
    private $count_accepted_applications;

    /**
     * @return mixed
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = (int)$user_id;
    }

    /**
     * @return mixed
     */
    public function getOnboardingPercentage(): int
    {
        return $this->onboarding_percentage;
    }

    /**
     * @param mixed $onboarding_percentage
     */
    public function setOnboardingPercentage($onboarding_percentage): void
    {
        $this->onboarding_percentage = (int)$onboarding_percentage;
    }

    /**
     * @return mixed
     */
    public function getCountApplications(): int
    {
        return $this->count_applications;
    }

    /**
     * @param mixed $count_applications
     */
    public function setCountApplications($count_applications): void
    {
        $this->count_applications = (int)$count_applications;
    }

    /**
     * @return mixed
     */
    public function getCountAcceptedApplications(): int
    {
        return $this->count_accepted_applications;
    }

    /**
     * @param mixed $count_accepted_applications
     */
    public function setCountAcceptedApplications($count_accepted_applications): void
    {
        $this->count_accepted_applications = (int)$count_accepted_applications;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = Carbon::parse($created_at);
    }

    /**
     * extra check because there are values without an onboarding percentage
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if ($this->getOnboardingPercentage() == "") {
            return false;
        }

        return true;
    }
}
