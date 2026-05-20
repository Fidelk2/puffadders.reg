<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model {
    protected $fillable = ['name', 'email', 'phone', 'course', 'paid', 'checkout_request_id'];
}