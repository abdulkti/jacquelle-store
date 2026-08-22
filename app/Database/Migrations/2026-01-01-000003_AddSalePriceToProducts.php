<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSalePriceToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'sale_price' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'price',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'sale_price');
    }
}
