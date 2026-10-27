<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class SelectExample extends ExampleScreen
{
    public string $fruit = '';

    public string $timezone = '';

    public string $size = 'M';

    public int $plan = 1;

    public function choosePlan(int $plan): void
    {
        $this->plan = $plan;
    }

    /**
     * @return array{timezones: array<string, string>, timezoneError: ?string}
     */
    protected function viewData(): array
    {
        return [
            'timezones' => [
                'Asia/Kolkata' => 'India (IST)',
                'Asia/Dubai' => 'Gulf (GST)',
                'Europe/London' => 'London (GMT)',
                'America/New_York' => 'New York (ET)',
            ],
            'timezoneError' => blank($this->timezone) ? 'Choose a timezone.' : null,
        ];
    }
}
