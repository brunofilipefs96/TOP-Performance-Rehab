<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'image' => 'products/powerade.png',
                'name' => 'Powerade',
                'quantity' => 50,
                'price' => 2.50,
                'details' => 'Bebida isotônica para hidratação e reposição de eletrólitos.',
            ],
            [
                'image' => 'products/gatorade.png',
                'name' => 'Gatorade',
                'quantity' => 70,
                'price' => 2.30,
                'details' => 'Bebida isotônica popular para reidratação durante exercícios intensos.',
            ],
            [
                'image' => 'products/protein_bar.png',
                'name' => 'Barra de Proteína Whey',
                'quantity' => 100,
                'price' => 3.00,
                'details' => 'Barra de proteína de whey, ideal para recuperação pós-treino.',
            ],
            [
                'image' => 'products/clif_bar.png',
                'name' => 'Clif Bar',
                'quantity' => 80,
                'price' => 2.80,
                'details' => 'Barra energética com ingredientes orgânicos e sabor delicioso.',
            ],
            [
                'image' => 'products/whey_protein.png',
                'name' => 'Whey Protein Isolado',
                'quantity' => 60,
                'price' => 45.00,
                'details' => 'Suplemento de proteína isolada de alta qualidade para ganho de massa muscular.',
            ],
            [
                'image' => 'products/casein_protein.png',
                'name' => 'Caseína Micelar',
                'quantity' => 40,
                'price' => 50.00,
                'details' => 'Proteína de digestão lenta, ideal para consumo antes de dormir.',
            ],
            [
                'image' => 'products/bcaa.png',
                'name' => 'BCAA 2:1:1',
                'quantity' => 90,
                'price' => 25.00,
                'details' => 'Aminoácidos de cadeia ramificada para melhora da recuperação muscular.',
            ],
            [
                'image' => 'products/creatine.png',
                'name' => 'Creatina Monohidratada',
                'quantity' => 110,
                'price' => 20.00,
                'details' => 'Suplemento para aumento de força e performance atlética.',
            ],
        ]);
    }
}
