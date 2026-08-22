<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table         = 'products';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['name', 'slug', 'image', 'price', 'sale_price', 'discount_percent', 'product_code', 'description', 'images', 'variants', 'variant_title'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;
}
