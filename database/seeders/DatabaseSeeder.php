<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FarmerProfile;
use App\Models\Market;
use App\Models\Category;
use App\Models\Product;
use App\Models\Faq;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with essential clean platform records.
     */
    public function run(): void
    {
        // 1. Super Administrator
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@marketlink.com',
            'password' => Hash::make('Password123!'),
            'phone' => '+92 300 1234567',
            'address' => 'Main Shahrah-e-Faisal, Karachi',
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 2. Verified Organic Farmer
        $farmer = User::create([
            'name' => 'Tariq Jameel (Green Valley Farms)',
            'email' => 'farmer@marketlink.com',
            'password' => Hash::make('Password123!'),
            'phone' => '+92 321 4455667',
            'address' => 'Green Valley Agro Farm, Malir Countryside, Karachi',
            'role' => 'farmer',
            'status' => 'active',
        ]);

        // 3. Customer Account
        $customer = User::create([
            'name' => 'Ali Khan',
            'email' => 'customer@marketlink.com',
            'password' => Hash::make('Password123!'),
            'phone' => '+92 333 1122334',
            'address' => 'House 45-B, DHA Phase 6, Karachi',
            'role' => 'customer',
            'status' => 'active',
        ]);

        // 4. Weekend Farmers Markets
        $market1 = Market::create([
            'name' => 'Clifton Beachside Farmers Market',
            'description' => 'Vibrant coastal weekend market featuring fresh organic greens, seasonal fruits, artisan bakery goods and wild honey directly from Sindh growers.',
            'address' => 'Near Marine Drive, Clifton Block 4, Karachi',
            'city' => 'Karachi',
            'operating_days' => 'Saturday, Sunday',
            'opening_time' => '08:00 AM',
            'closing_time' => '02:00 PM',
            'latitude' => 24.8138,
            'longitude' => 67.0300,
            'image' => 'images/markets/market_101.jpg',
            'status' => 'active',
        ]);

        $market2 = Market::create([
            'name' => 'Gulberg Eco Organic Fair',
            'description' => 'Premier Punjab community harvest fair bringing together certified organic family farms, desi dairy, and raw honey producers.',
            'address' => 'Main Boulevard, Gulberg III, Lahore',
            'city' => 'Lahore',
            'operating_days' => 'Friday, Saturday',
            'opening_time' => '09:00 AM',
            'closing_time' => '03:00 PM',
            'latitude' => 31.5204,
            'longitude' => 74.3587,
            'image' => 'images/markets/market_102.jpg',
            'status' => 'active',
        ]);

        $market3 = Market::create([
            'name' => 'F-7 Markaz Community Harvest Bazaar',
            'description' => 'Scenic Sunday open-air bazaar showcasing Margalla valley organic produce, mountain dry fruits, fresh herbs, and farm eggs.',
            'address' => 'Jinnah Super Market Civic Center, Sector F-7, Islamabad',
            'city' => 'Islamabad',
            'operating_days' => 'Sunday',
            'opening_time' => '08:30 AM',
            'closing_time' => '01:30 PM',
            'latitude' => 33.7215,
            'longitude' => 73.0560,
            'image' => 'images/markets/market_103.jpg',
            'status' => 'active',
        ]);

        $market4 = Market::create([
            'name' => 'DHA Phase 5 Eco Bazaar',
            'description' => 'Boutique open-air weekend marketplace offering hydroponic greens, cold-pressed oils, and farm fresh vegetables.',
            'address' => 'Commercial Avenue, Phase 5 DHA, Karachi',
            'city' => 'Karachi',
            'operating_days' => 'Saturday, Sunday',
            'opening_time' => '07:30 AM',
            'closing_time' => '01:00 PM',
            'latitude' => 24.7865,
            'longitude' => 67.0620,
            'image' => 'images/markets/market_104.jpg',
            'status' => 'active',
        ]);

        // 5. Farmer Profile Link
        FarmerProfile::create([
            'user_id' => $farmer->id,
            'market_id' => $market1->id,
            'stall_name' => 'Green Valley Organic Stall',
            'bio' => 'Certified organic smallholding grower specializing in pesticide-free heirloom produce and field greens.',
            'operating_days' => 'Saturday, Sunday',
            'pickup_time_start' => '08:00',
            'pickup_time_end' => '14:00',
            'order_cutoff_hours' => 3,
            'stall_number' => 'Stall A-01',
            'status' => 'approved',
        ]);

        // 6. Produce Categories
        $catVeg = Category::create([
            'name' => 'Fresh Vegetables',
            'slug' => 'fresh-vegetables',
            'description' => 'Crisp, naturally grown seasonal vegetables harvested directly from farm fields.',
            'icon' => 'fi fi-sr-carrot',
            'is_active' => true,
        ]);

        $catFruit = Category::create([
            'name' => 'Seasonal Fruits',
            'slug' => 'seasonal-fruits',
            'description' => 'Sun-ripened orchard fresh fruits with exceptional natural sweetness.',
            'icon' => 'fi fi-sr-apple',
            'is_active' => true,
        ]);

        $catDairy = Category::create([
            'name' => 'Dairy & Farm Eggs',
            'slug' => 'dairy-farm-eggs',
            'description' => 'Grass-fed whole milk, cultured desi butter, and free-range country eggs.',
            'icon' => 'fi fi-sr-egg',
            'is_active' => true,
        ]);

        $catBakery = Category::create([
            'name' => 'Artisan Bakery & Grains',
            'slug' => 'artisan-bakery-grains',
            'description' => 'Stone ground whole grains, cold-pressed oils, and traditional staples.',
            'icon' => 'fi fi-sr-bread-slice',
            'is_active' => true,
        ]);

        $catHerbs = Category::create([
            'name' => 'Herbs & Microgreens',
            'slug' => 'herbs-microgreens',
            'description' => 'Aromatic culinary herbs, hydroponic greens, and crisp salad leaves.',
            'icon' => 'fi fi-sr-leaf',
            'is_active' => true,
        ]);

        $catHoney = Category::create([
            'name' => 'Honey & Preserves',
            'slug' => 'honey-preserves',
            'description' => 'Raw wild Sidr honey, fruit preserves, and natural farm syrups.',
            'icon' => 'fi fi-sr-jar',
            'is_active' => true,
        ]);

        // 7. Authentic Organic Products (Linked across all 6 categories)
        $products = [
            // Fresh Vegetables
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catVeg->id,
                'name' => 'Organic Heirloom Tomatoes',
                'slug' => 'organic-heirloom-tomatoes',
                'description' => 'Sun-ripened juicy heirloom tomatoes, grown with zero chemical pesticides. Rich in flavor.',
                'price' => 180.00,
                'unit' => 'kg',
                'stock_quantity' => 45,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_101.jpg',
            ],
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catVeg->id,
                'name' => 'Hydroponic Bell Peppers',
                'slug' => 'hydroponic-bell-peppers',
                'description' => 'Crisp, sweet tricolor bell peppers harvested fresh for weekend salad and stir-fry lovers.',
                'price' => 280.00,
                'unit' => 'kg',
                'stock_quantity' => 30,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_104.jpg',
            ],
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catVeg->id,
                'name' => 'Baby Spinach & Kale Bunch',
                'slug' => 'baby-spinach-kale-bunch',
                'description' => 'Tender leafy organic greens packed with iron, harvested on Friday morning.',
                'price' => 120.00,
                'unit' => 'bunch',
                'stock_quantity' => 50,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_102.jpg',
            ],
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catVeg->id,
                'name' => 'Farm Crunchy Carrots',
                'slug' => 'farm-crunchy-carrots',
                'description' => 'Sweet, vibrant red organic carrots fresh from Malir soil with green tops intact.',
                'price' => 150.00,
                'unit' => 'kg',
                'stock_quantity' => 60,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_103.jpg',
            ],

            // Seasonal Fruits
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catFruit->id,
                'name' => 'Sweet Red Apples (Orchard Fresh)',
                'slug' => 'sweet-red-apples',
                'description' => 'Handpicked crisp mountain apples from Swat Valley orchards. Naturally sweet and aromatic.',
                'price' => 320.00,
                'unit' => 'kg',
                'stock_quantity' => 35,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_106.jpg',
            ],
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catFruit->id,
                'name' => 'Organic Farm Strawberries',
                'slug' => 'organic-farm-strawberries',
                'description' => 'Sweet and fragrant pesticide-free strawberries boxed carefully in ventilated crates.',
                'price' => 450.00,
                'unit' => 'pack (500g)',
                'stock_quantity' => 25,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_107.jpg',
            ],
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catFruit->id,
                'name' => 'Ripe Tree Papaya',
                'slug' => 'ripe-tree-papaya',
                'description' => 'Naturally ripened on the tree with deep orange sweet flesh.',
                'price' => 220.00,
                'unit' => 'kg',
                'stock_quantity' => 20,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_105.jpg',
            ],

            // Dairy & Farm Eggs
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catDairy->id,
                'name' => 'Free-Range Desi Eggs',
                'slug' => 'free-range-desi-eggs',
                'description' => 'Farm fresh golden-yolk eggs from free-roaming pasture hens fed natural grains.',
                'price' => 360.00,
                'unit' => 'dozen',
                'stock_quantity' => 40,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_109.jpg',
            ],
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catDairy->id,
                'name' => 'Grass-Fed Pure Desi Makhan (Butter)',
                'slug' => 'pure-desi-makhan-butter',
                'description' => 'Artisan churned white butter made using traditional bilona method from grass-fed cows.',
                'price' => 850.00,
                'unit' => 'tub (500g)',
                'stock_quantity' => 15,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_108.jpg',
            ],

            // Artisan Bakery & Grains
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catBakery->id,
                'name' => 'Artisan Sourdough Country Loaf',
                'slug' => 'artisan-sourdough-country-loaf',
                'description' => 'Naturally fermented sourdough bread baked with stone-milled whole wheat flour.',
                'price' => 420.00,
                'unit' => 'loaf',
                'stock_quantity' => 20,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_110.jpg',
            ],
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catBakery->id,
                'name' => 'Cold-Pressed Extra Virgin Olive Oil',
                'slug' => 'cold-pressed-extra-virgin-olive-oil',
                'description' => 'First cold pressed unfiltered extra virgin olive oil from Chakwal olive groves.',
                'price' => 1650.00,
                'unit' => 'bottle (500ml)',
                'stock_quantity' => 25,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_111.jpg',
            ],

            // Herbs & Microgreens
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catHerbs->id,
                'name' => 'Fresh Basil & Mint Bundle',
                'slug' => 'fresh-basil-mint-bundle',
                'description' => 'Fragrant fresh sweet basil and aromatic spearmint picked fresh before market opening.',
                'price' => 90.00,
                'unit' => 'bunch',
                'stock_quantity' => 35,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_112.jpg',
            ],
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catHerbs->id,
                'name' => 'Organic Sunflower Microgreens',
                'slug' => 'organic-sunflower-microgreens',
                'description' => 'Nutrient-dense live microgreens packed with vitamins A, B, C, and E. Great for salads.',
                'price' => 250.00,
                'unit' => 'tray',
                'stock_quantity' => 20,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_113.jpg',
            ],

            // Honey & Preserves
            [
                'farmer_id' => $farmer->id,
                'category_id' => $catHoney->id,
                'name' => 'Raw Wild Sidr (Beri) Honey',
                'slug' => 'raw-wild-sidr-beri-honey',
                'description' => '100% pure unfiltered mountain Sidr honey harvested from wild Potohar bee colonies.',
                'price' => 1850.00,
                'unit' => 'jar (500g)',
                'stock_quantity' => 30,
                'is_available' => true,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'image' => 'images/products/item_114.jpg',
            ],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }

        // 8. Platform FAQs
        $faqs = [
            ['Q' => 'How does pre-ordering on MarketLink work?', 'A' => 'Browse products from your favorite local farmers, add them to your cart, select your pickup market day and time slot, and submit the pre-order. You pay cash or card directly when you pick up at the farmer’s stall.'],
            ['Q' => 'Is payment required online?', 'A' => 'No online payment gateway is required. All pre-orders are settled directly in person at the market stall during pickup.'],
            ['Q' => 'Can I cancel or modify my pre-order?', 'A' => 'Yes! You can cancel or modify your order from your Customer Dashboard before the farmer’s designated cut-off time (usually 3-4 hours prior to market start).'],
            ['Q' => 'What are the operating market timings?', 'A' => 'Weekend markets generally operate between 08:00 AM and 02:00 PM on Saturdays and Sundays. You can check the interactive Market Map for exact location coordinates and hours.'],
            ['Q' => 'How can a farmer join MarketLink?', 'A' => 'Click "Register as Farmer", enter your business/stall information and market details. Once our Admin team reviews and approves your stall profile, you can immediately begin listing your weekly produce.'],
            ['Q' => 'Where can I see the live stall map?', 'A' => 'Visit the "Markets & Map" page in the navigation bar to see interactive OpenStreetMap markers for all farmers markets and active stalls with direct navigation routes.'],
        ];

        foreach ($faqs as $faq) {
            Faq::create([
                'question' => $faq['Q'],
                'answer' => $faq['A'],
                'category' => 'General',
                'is_active' => true,
            ]);
        }
    }
}
