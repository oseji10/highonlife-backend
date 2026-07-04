<?php

// Save as config/high_on_life.php
// Centralizes capacity numbers so the registration controllers and the dashboard
// always agree on the same limits — change the number in one place only.

return [
    'living_room_capacity' => env('LIVING_ROOM_CAPACITY', 50),
    'awareness_walk_capacity' => env('AWARENESS_WALK_CAPACITY', 100),
];