<?php
function flash_toast(string $message, string $type = 'success', int $duration = 3000)
{
    session()->flash('toast', [
        'id' => uniqid(),
        'message' => $message,
        'type' => $type,
        'duration' => $duration,
    ]);
}
