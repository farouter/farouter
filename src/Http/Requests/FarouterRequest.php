<?php

namespace Farouter\Http\Requests;

use Farouter\Farouter;
use Illuminate\Foundation\Http\FormRequest;

class FarouterRequest extends FormRequest
{
    public function isUpdateRequest()
    {
        return $this instanceof NodeableUpdateRequest;
    }

    public function isStoreRequest()
    {
        return $this instanceof NodeableStoreRequest;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        $resource = null;

        if ($this->isUpdateRequest()) {
            $resolvedResource = Farouter::resolveResourceForModel($this->route('node')->nodeable);
            $resource = new $resolvedResource($this, $this->route('node')->nodeable);

        } elseif ($this->isStoreRequest()) {
            $resolvedResource = $this->route('nodeableType');
            $resource = new $resolvedResource($this);
        }

        if ($resource) {
            foreach ($resource->fields($this) as $field) {
                $rules[$field->attribute] = $field->rules;
            }
        }

        return $rules;
    }
}
