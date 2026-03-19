<?php

return [
    'bunga_normal' => env('PEGADAIAN_BUNGA_NORMAL', 10),  // %
    'bunga_khusus' => env('PEGADAIAN_BUNGA_KHUSUS', 5),   // % jika tebus <= 1/2 masa
    'biaya_perp'   => env('PEGADAIAN_BIAYA_PERP', 10),    // % flat perpanjangan
];
