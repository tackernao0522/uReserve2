<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_name' => ['required', 'max:50'],
            'information' => ['required', 'max:200'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'], // 開始時間よりも後でなければ引っかかる
            'max_people' => ['required', 'numeric', 'between:1, 20'],
            'is_visible' => ['required', 'boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'event_name' => 'イベント名',
            'information' => 'イベント詳細',
            'event_date' => 'イベント日付',
            'start_time' => '開始時間',
            'end_time' => '終了時間',
            'max_people' => '定員',
        ];
    }

    public function messages()
    {
        return [
            'end_time.after' => '終了時間には、開始時間より後の時間を指定してください。',
        ];
    }
}
