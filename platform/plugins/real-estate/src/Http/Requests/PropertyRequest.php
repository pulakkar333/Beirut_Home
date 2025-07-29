<?php

namespace Botble\RealEstate\Http\Requests;

use Botble\RealEstate\Enums\ModerationStatusEnum;
use Botble\RealEstate\Enums\PropertyStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PropertyRequest extends Request
{
    public function rules(): array
    {
        return array(
            'name' => array('required', 'string', 'max:220'),
            'description' => array('nullable', 'string', 'max:400'),
            'content' => array('nullable', 'string', 'max:300000'),
            'number_bedroom' => array('numeric', 'min:0', 'max:100000', 'nullable'),
            'number_bathroom' => array('numeric', 'min:0', 'max:100000', 'nullable'),
            'number_floor' => array('numeric', 'min:0', 'max:100000', 'nullable'),
            'price' => array('numeric', 'min:0', 'nullable'),
            'latitude' => array('max:20', 'nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'),
            'longitude' => array(
                'max:20',
                'nullable',
                'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/',
            ),
            'status' => Rule::in(PropertyStatusEnum::values()),
            'moderation_status' => Rule::in(ModerationStatusEnum::values()),
            'custom_fields.*.name' => array('required', 'string', 'max:255'),
            'custom_fields.*.value' => array('nullable', 'string', 'max:255'),
            'unique_id' => 'nullable|string|max:120|unique:re_properties,unique_id,' . $this->route('property'),
            'location' => array('nullable', 'string', 'max:191'),
            'facilities' => array('nullable', 'array'),
            'facilities.*.id' => array('required', 'numeric', 'exists:re_facilities,id'),
            'facilities.*.distance' => array('required', 'string', 'max:50'),
            'private_notes' => array('nullable', 'string', 'max:10000'),
            'floor_plans' => array('nullable'),
            'never_expired'         => array('nullable', 'boolean'),
            'auto_renew'            => array('nullable', 'boolean'),
            'booked_dates'          => array('required', 'array', 'min:1'),
            'booked_dates.*'        => array('date_format:Y-m-d'),
        );
    }

    public function attributes(): array
    {
        return array(
            'facilities.*.distance' => trans('plugins/real-estate::property.distance_key'),
            'custom_fields.*.name' => trans('plugins/real-estate::custom-fields.name'),
            'custom_fields.*.value' => trans('plugins/real-estate::custom-fields.name'),
            'floor_plans' => trans('plugins/real-estate::property.floor_plans.title'),
            'booked_dates' => trans('plugins/real-estate::property.booked_dates'),
        );
    }
}
