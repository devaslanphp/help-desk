<?php

namespace App\Core;

use Illuminate\Support\HtmlString;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as BaseLogsActivity;
use App\Models\User;

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
            ->setDescriptionForEvent(function(string $eventName) {
                

                // Define attributes to exclude from the change log
                $excludedAttributes = ['updated_at', 'created_at', 'deleted_at'];

                
                // Get changes and original values
                $changes = array_diff_key($this->getDirty(), array_flip($excludedAttributes));
                $originals = array_diff_key($this->getOriginal(), array_flip($excludedAttributes));


                // Generate changes description
                $changesDescription = '';
                foreach ($changes as $key => $value) {
                    $originalValue = $originals[$key] ?? 'null';
                    if($key=="responsible_id")
                    {
                        // Fetch the responsible user based on the current responsible_id
                        $responsibleUserOld = User::withTrashed()->find($originalValue);

                        // Get the responsible user's name if available
                        $responsibleUserNameOld = $responsibleUserOld ? $responsibleUserOld->name : 'None';

                        // Fetch the responsible user based on the current responsible_id
                        $responsibleUserNew = User::withTrashed()->find($value);

                        // Get the responsible user's name if available
                        $responsibleUserNameNew = $responsibleUserNew ? $responsibleUserNew->name : 'Unknown User';
                        $changesDescription .= "Responsible: {$responsibleUserNameOld} to {$responsibleUserNameNew} ";
                        continue;
                    }
                    $changesDescription .= "{$key}: '{$originalValue}' => '{$value}' ";
                }
                if($eventName == "created"){
                    $changesDescription = ""  ;   
                }
                // Generate the description
                return new HtmlString(
                '<div class="flex flex-col gap-1">'
                . (auth()->user()->name ?? '')
                . " "
                . $eventName
                . " "
                . $this->fromCamelCase((new \ReflectionClass($this))->getShortName())
                . " "
                . $this
                . "<br>"
                . $changesDescription
                . ' <a class="text-primary-500 hover:underline hover:cursor-pointer"
                        target="_blank"
                        href="' . $this->activityLogLink() . '">
                        ' . __('See details')
                . '</a>'
                . '</div>'
            );
        });
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
