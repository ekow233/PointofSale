<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function getStockDetails($id){
        $records = DB::select("select nama_produk as product,branch_name as branch,branch_STOK AS stock FROM branch_product_stock s,produk p,branches b where s.id_produk = p.id_produk and b.id = s.branch_id and s.id= $id;");
        return($records);
    }
}
