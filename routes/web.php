<?php

use Illuminate\Support\Facades\Route;
use Detit\Polimenu\Http\Controllers\MenuController;

Route::get('/menu/{handle}', [MenuController::class, 'show']);
