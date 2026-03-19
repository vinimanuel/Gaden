<?php

if (! function_exists('rupiah')) {
    /**
     * Format integer to Indonesian Rupiah string.
     * e.g. 9000000 → "Rp 9.000.000"
     */
    function rupiah(int|float|null $amount): string
    {
        if ($amount === null) return 'Rp 0';
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
