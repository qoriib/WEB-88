<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreCategory;
use App\Models\User;

class SeederState
{
    public static ?User $admin = null;
    /** @var array<string, User> */
    public static array $vendors = [];
    /** @var array<string, User> */
    public static array $customers = [];
    /** @var array<string, StoreCategory> */
    public static array $categories = [];
    /** @var array<string, Store> */
    public static array $stores = [];
    /** @var array<string, Product> */
    public static array $products = [];
    /** @var array<string, Cart> keyed by order number */
    public static array $carts = [];
    /** @var array<string, Order> */
    public static array $orders = [];
}
