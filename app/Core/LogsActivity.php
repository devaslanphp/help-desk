<?php

namespace App\Core;

use Illuminate\Support\HtmlString;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as BaseLogsActivity;

trait LogsActivity
{

    use BaseLogsActivity;

    /**
     * Activity log options definition
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->getFillable())
            ->setDescriptionForEvent(fn(string $eventName) => new HtmlString(
                '<div class="flex flex-col gap-1">'
                . (auth()->user()->name ?? '')
                . " "
                . $eventName
                . " "
                . $this->fromCamelCase((new \ReflectionClass($this))->getShortName())
                . " "
                . $this
                . ' <a class="text-primary-500 hover:underline hover:cursor-pointer"
                        target="_blank"
                        href="' . $this->activityLogLink() . '">
                        ' . __('See details')
                . '</a>'
                . '</div>'
            ));
    }

    /**
     * Transform a camel case to normal case
     *
     * @param $input
     * @return string
     */
    private function fromCamelCase($input)
    {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
        preg_match_all($pattern, $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ?
                strtolower($match) :
                lcfirst($match);
        }
        return implode(' ', $ret);
    }

}
