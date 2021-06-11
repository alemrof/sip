<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role_id' => 1,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin() {
        if ($this->role->name == 'Admin') {
            return true;
        } else {
            return false;
        }
    }

    public function isModerator() {
        $role = $this->role->name;
        if ($role == 'Admin' || $role == 'Moderator') {
            return true;
        } else {
            return false;
        }
    }

    public function warehouseComments() {
        return $this->hasMany(WarehouseComment::class);
    }

    public function hasWarehouseComment($warehouse_id) {
        $warehouse = Warehouse::with('company')->find($warehouse_id);
        if ($warehouse) {
            $comments = $warehouse->warehouseComments;
            foreach ($comments as $comment)
            {
                if ($comment->user_id == $this->id)
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function hasProductComment($product_id) {
        $product = Product::find($product_id);
        if ($product) {
            $comments = $product->productComments;
            foreach ($comments as $comment)
            {
                if ($comment->user_id == $this->id)
                {
                    return true;
                }
            }
        }
        return false;
    }
}
