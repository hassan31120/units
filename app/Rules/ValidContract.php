<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidContract implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        if (request()->hasFile($attribute)) {
            $file = request()->file($attribute);
            $extension = strtolower($file->getClientOriginalExtension());
            $size = $file->getSize();

            if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                return $size <= 4 * 1024 * 1024;
            } elseif ($extension === 'pdf') {
                return $size <= 10 * 1024 * 1024;
            }

            return false;
        }

        return false;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute must be an image (max 4MB) or a PDF (max 10MB).';
    }
}
