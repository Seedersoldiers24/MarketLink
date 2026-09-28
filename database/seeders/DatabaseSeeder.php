<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Market;
use App\Models\FarmerProfile;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Announcement;
use App\Models\Report;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@marketlink.com'],
            [
                'name' => 'MarketLink Admin',
                'phone' => '+1 (555) 010-0001',
                'address' => 'Central Platform Office, Suite 400',
                'role' => 'admin',
                'status' => 'active',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Customer Users
        $customerSarah = User::firstOrCreate(
            ['email' => 'customer@marketlink.com'],
            [
                'name' => 'Sarah Jenkins',
                'phone' => '+1 (555) 234-5678',
                'address' => '742 Evergreen Terrace, Springfield',
                'role' => 'customer',
                'status' => 'active',
                'password' => Hash::make('password123'),
            ]
        );

        $customerMichael = User::firstOrCreate(
            ['email' => 'michael@marketlink.com'],
            [
                'name' => 'Michael Chang',
                'phone' => '+1 (555) 345-6789',
                'address' => '120 Oakridge Lane, Springfield',
                'role' => 'customer',
                'status' => 'active',
                'password' => Hash::make('password123'),
            ]
        );

        $customerEmily = User::firstOrCreate(
            ['email' => 'emily@marketlink.com'],
            [
                'name' => 'Emily Watson',
                'phone' => '+1 (555) 456-7890',
                'address' => '88 Blossom Hill Rd, Springfield',
                'role' => 'customer',
                'status' => 'active',
                'password' => Hash::make('password123'),
            ]
        );

        // 3. Markets
        $marketsData = [
            [
                'market_name' => 'Downtown Central Farmers Market',
                'slug' => 'downtown-central-farmers-market',
                'address' => '100 Market St, Civic Plaza',
                'city' => 'Springfield',
                'operating_days' => 'Saturday & Sunday',
                'timings' => '07:30 AM - 02:00 PM',
                'latitude' => 37.774929,
                'longitude' => -122.419416,
                'description' => 'The largest weekend market in town featuring over 40 local growers, artisanal bakers, live acoustic music, and pre-order express pickup stalls.',
                'image' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'market_name' => 'Riverside Green Square Market',
                'slug' => 'riverside-green-square-market',
                'address' => '45 Riverbank Promenade',
                'city' => 'Springfield',
                'operating_days' => 'Wednesday & Saturday',
                'timings' => '08:00 AM - 01:30 PM',
                'latitude' => 37.783300,
                'longitude' => -122.416700,
                'description' => 'Scenic waterfront market specializing in fresh berries, crisp greens, seasonal orchards, and handmade organic cheeses.',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'market_name' => 'Westside Community Pavilion',
                'slug' => 'westside-community-pavilion',
                'address' => '820 Sunset Boulevard',
                'city' => 'Springfield',
                'operating_days' => 'Tuesday & Friday',
                'timings' => '08:30 AM - 02:30 PM',
                'latitude' => 37.765000,
                'longitude' => -122.443000,
                'description' => 'Convenient weekday pickup destination with dedicated curbside pre-order parking stalls and organic produce certs.',
                'image' => 'https://images.unsplash.com/photo-1519999482648-25049ddd37b1?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'market_name' => 'East Bay Harvest Fair',
                'slug' => 'east-bay-harvest-fair',
                'address' => '312 Grand Meadow Blvd',
                'city' => 'Springfield',
                'operating_days' => 'Sunday',
                'timings' => '08:00 AM - 03:00 PM',
                'latitude' => 37.804400,
                'longitude' => -122.271200,
                'description' => 'A lively Sunday family festival with farm-fresh produce, sourdough breads, clover honeys, and dairy reserves.',
                'image' => 'https://images.unsplash.com/photo-1506484381205-f7945653044d?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        $createdMarkets = [];
        foreach ($marketsData as $mData) {
            $createdMarkets[] = Market::updateOrCreate(['slug' => $mData['slug']], $mData);
        }

        // 4. Categories
        $categoriesData = [
            [
                'name' => 'Organic Vegetables',
                'slug' => 'vegetables',
                'icon' => 'carrot',
                'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80',
                'description' => 'Field-grown crisp carrots, heirloom tomatoes, fresh leafy greens, and pesticide-free root crops.',
            ],
            [
                'name' => 'Fresh Orchard Fruits',
                'slug' => 'fruits',
                'icon' => 'apple-alt',
                'image' => 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?auto=format&fit=crop&w=600&q=80',
                'description' => 'Sun-ripened berries, crisp gala apples, sweet peaches, and citrus fresh from the orchard trees.',
            ],
            [
                'name' => 'Farmstead Dairy & Eggs',
                'slug' => 'dairy',
                'icon' => 'cheese',
                'image' => 'https://images.unsplash.com/photo-1528751014936-863e6e7a319c?auto=format&fit=crop&w=600&q=80',
                'description' => 'Grass-fed whole milk, cultured churned butter, artisan aged cheddar, and free-range pastured eggs.',
            ],
            [
                'name' => 'Artisanal Bakery & Breads',
                'slug' => 'baked-goods',
                'icon' => 'bread-slice',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80',
                'description' => 'Slow-fermented wild sourdough loaves, flaky morning brioche, and rustic grain baguettes.',
            ],
            [
                'name' => 'Fresh Herbs & Spices',
                'slug' => 'herbs',
                'icon' => 'seedling',
                'image' => 'https://images.unsplash.com/photo-1509358271058-acd22cc93898?auto=format&fit=crop&w=600&q=80',
                'description' => 'Aromatic sweet genovese basil, garden rosemary, curly parsley, and dried ground seasoning.',
            ],
            [
                'name' => 'Raw Honey & Fruit Preserves',
                'slug' => 'preserves-honey',
                'icon' => 'jar',
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=600&q=80',
                'description' => 'Unpasteurized wildflower honeycomb honey, seasonal strawberry jam, and spiced apple butter.',
            ],
        ];

        $createdCategories = [];
        foreach ($categoriesData as $cData) {
            $createdCategories[$cData['slug']] = Category::updateOrCreate(['slug' => $cData['slug']], $cData);
        }

        // 5. Farmers & Farmer Profiles
        $farmersData = [
            [
                'user' => [
                    'name' => 'John Green',
                    'email' => 'farmer@marketlink.com',
                    'phone' => '+1 (555) 789-0123',
                    'address' => 'Sunny Valley Way, Valley Ridge Farm #12',
                    'role' => 'farmer',
                    'status' => 'active',
                    'password' => Hash::make('password123'),
                ],
                'profile' => [
                    'stall_name' => 'Sunny Valley Organics',
                    'stall_number' => 'Stall A-14 (North Wing)',
                    'contact_person' => 'John & Clara Green',
                    'contact_number' => '+1 (555) 789-0123',
                    'address' => '100 Market St, Stall A-14, Springfield',
                    'operating_days' => 'Saturday & Sunday',
                    'pickup_windows' => '08:00 AM - 10:00 AM, 10:00 AM - 12:00 PM, 12:00 PM - 02:00 PM',
                    'cutoff_hours_before' => 12,
                    'latitude' => 37.774929,
                    'longitude' => -122.419416,
                    'market_id' => $createdMarkets[0]->id,
                    'bio' => 'Third-generation regenerative family farm dedicated to pesticide-free heirloom vegetables, greenhouse greens, and vine-ripened tomatoes.',
                    'avatar' => 'https://images.unsplash.com/photo-1595273670150-bd0c3c392e46?auto=format&fit=crop&w=400&q=80',
                    'is_approved' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Elena Vance',
                    'email' => 'elena@marketlink.com',
                    'phone' => '+1 (555) 890-1234',
                    'address' => 'Riverbend Creek Road, Orchard Haven',
                    'role' => 'farmer',
                    'status' => 'active',
                    'password' => Hash::make('password123'),
                ],
                'profile' => [
                    'stall_name' => 'Riverbend Berry & Orchard Farm',
                    'stall_number' => 'Stall B-03 (Riverside Pier)',
                    'contact_person' => 'Elena Vance',
                    'contact_number' => '+1 (555) 890-1234',
                    'address' => '45 Riverbank Promenade, Stall B-03',
                    'operating_days' => 'Wednesday & Saturday',
                    'pickup_windows' => '08:30 AM - 10:30 AM, 10:30 AM - 12:30 PM, 12:30 PM - 01:30 PM',
                    'cutoff_hours_before' => 8,
                    'latitude' => 37.783300,
                    'longitude' => -122.416700,
                    'market_id' => $createdMarkets[1]->id,
                    'bio' => 'Nestled alongside the mountain river, we cultivate the sweetest strawberries, plump blueberries, crisp heritage apples, and artisan ciders.',
                    'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&q=80',
                    'is_approved' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Carlos Rodriguez',
                    'email' => 'carlos@marketlink.com',
                    'phone' => '+1 (555) 901-2345',
                    'address' => 'Highland Meadows Trail #45',
                    'role' => 'farmer',
                    'status' => 'active',
                    'password' => Hash::make('password123'),
                ],
                'profile' => [
                    'stall_name' => 'Highland Natural Apiaries & Honey',
                    'stall_number' => 'Stall W-07',
                    'contact_person' => 'Carlos Rodriguez',
                    'contact_number' => '+1 (555) 901-2345',
                    'address' => '820 Sunset Boulevard, Westside Pavilion',
                    'operating_days' => 'Tuesday & Friday',
                    'pickup_windows' => '09:00 AM - 11:00 AM, 11:00 AM - 01:00 PM, 01:00 PM - 02:30 PM',
                    'cutoff_hours_before' => 10,
                    'latitude' => 37.765000,
                    'longitude' => -122.443000,
                    'market_id' => $createdMarkets[2]->id,
                    'bio' => 'Pure wildflower raw honeys, organic beeswax candles, royal jelly, and hand-jarred berry preserves produced with ethical bee-keeping.',
                    'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
                    'is_approved' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Maria Chen',
                    'email' => 'maria@marketlink.com',
                    'phone' => '+1 (555) 012-3456',
                    'address' => 'Artisan Mill House, Mill Valley Road',
                    'role' => 'farmer',
                    'status' => 'active',
                    'password' => Hash::make('password123'),
                ],
                'profile' => [
                    'stall_name' => 'Artisan Grove Sourdough & Hearth',
                    'stall_number' => 'Stall S-02 (Bakery Canopy)',
                    'contact_person' => 'Maria & Luke Chen',
                    'contact_number' => '+1 (555) 012-3456',
                    'address' => '100 Market St, Stall S-02, Springfield',
                    'operating_days' => 'Saturday & Sunday',
                    'pickup_windows' => '07:30 AM - 09:30 AM, 09:30 AM - 11:30 AM, 11:30 AM - 01:30 PM',
                    'cutoff_hours_before' => 14,
                    'latitude' => 37.774929,
                    'longitude' => -122.419416,
                    'market_id' => $createdMarkets[0]->id,
                    'bio' => 'Naturally leavened organic artisan sourdough, 100% stone-milled whole grain country loaves, rosemary focaccia, and butter croissants baked at dawn.',
                    'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80',
                    'is_approved' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'David Miller',
                    'email' => 'david@marketlink.com',
                    'phone' => '+1 (555) 123-9876',
                    'address' => 'Meadow Valley Pastures #8',
                    'role' => 'farmer',
                    'status' => 'active',
                    'password' => Hash::make('password123'),
                ],
                'profile' => [
                    'stall_name' => 'Green Meadow Dairy & Pastures',
                    'stall_number' => 'Stall E-08 (East Pavilion)',
                    'contact_person' => 'David Miller',
                    'contact_number' => '+1 (555) 123-9876',
                    'address' => '312 Grand Meadow Blvd, East Bay Fair',
                    'operating_days' => 'Sunday',
                    'pickup_windows' => '08:00 AM - 10:30 AM, 10:30 AM - 01:00 PM, 01:00 PM - 03:00 PM',
                    'cutoff_hours_before' => 12,
                    'latitude' => 37.804400,
                    'longitude' => -122.271200,
                    'market_id' => $createdMarkets[3]->id,
                    'bio' => 'Certified organic dairy pasture producing whole non-homogenized A2 milk, hand-pressed herb jack cheeses, and golden pasture-raised eggs.',
                    'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
                    'is_approved' => true,
                ],
            ],
        ];

        $createdFarmerProfiles = [];
        foreach ($farmersData as $fItem) {
            $fUser = User::updateOrCreate(['email' => $fItem['user']['email']], $fItem['user']);
            $profileData = array_merge($fItem['profile'], ['user_id' => $fUser->id]);
            $createdFarmerProfiles[] = FarmerProfile::updateOrCreate(['user_id' => $fUser->id], $profileData);
        }

        // 6. Products for each farmer
        $productsData = [
            // Farmer 0: Sunny Valley Organics (Vegetables & Herbs)
            [
                'farmer_idx' => 0,
                'category_slug' => 'vegetables',
                'name' => 'Organic Heirloom Vine Tomatoes',
                'slug' => 'organic-heirloom-vine-tomatoes',
                'description' => 'Sweet, juicy, multi-colored heirloom tomatoes harvested fresh this morning. Perfect for Caprese salads and roasting.',
                'price' => 4.50,
                'unit' => 'kg',
                'stock_quantity' => 45,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Harvested 24 hrs prior to market',
                'image' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 0,
                'category_slug' => 'vegetables',
                'name' => 'Crisp Rainbow Sweet Carrots',
                'slug' => 'crisp-rainbow-sweet-carrots',
                'description' => 'Crunchy bunches of purple, yellow, and orange organic baby carrots with leafy greens intact.',
                'price' => 3.20,
                'unit' => 'bunch',
                'stock_quantity' => 60,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Fresh harvest every Friday',
                'image' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 0,
                'category_slug' => 'vegetables',
                'name' => 'Hydroponic Butterhead Green Lettuce',
                'slug' => 'hydroponic-butterhead-green-lettuce',
                'description' => 'Tender, velvety living lettuce heads packaged with live roots for long-lasting crispness in your fridge.',
                'price' => 2.80,
                'unit' => 'head',
                'stock_quantity' => 30,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Picked daily',
                'image' => 'https://images.unsplash.com/photo-1556801712-76c8eb07bbc9?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 0,
                'category_slug' => 'herbs',
                'name' => 'Fresh Genovese Sweet Basil',
                'slug' => 'fresh-genovese-sweet-basil',
                'description' => 'Fragrant, broad Italian basil leaves with sweet peppery notes. Ideal for homemade pesto and tomato pairings.',
                'price' => 2.50,
                'unit' => 'bunch',
                'stock_quantity' => 25,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Harvested at morning dew',
                'image' => 'https://images.unsplash.com/photo-1618375531912-867984bdfd87?auto=format&fit=crop&w=600&q=80',
            ],

            // Farmer 1: Riverbend Berry & Orchard Farm
            [
                'farmer_idx' => 1,
                'category_slug' => 'fruits',
                'name' => 'Sweet Mountain Strawberries',
                'slug' => 'sweet-mountain-strawberries',
                'description' => 'Intensely sweet, red-to-the-core alpine strawberries grown under cool morning river mists.',
                'price' => 5.50,
                'unit' => 'pint box',
                'stock_quantity' => 50,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Hand-picked yesterday',
                'image' => 'https://images.unsplash.com/photo-1518635017498-87f514b751ba?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 1,
                'category_slug' => 'fruits',
                'name' => 'Organic Plump Blueberries',
                'slug' => 'organic-plump-blueberries',
                'description' => 'Antioxidant-packed sweet blueberries with natural silver bloom. Firm, juicy, and freshly sorted.',
                'price' => 6.00,
                'unit' => 'basket',
                'stock_quantity' => 35,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Fresh morning harvest',
                'image' => 'https://images.unsplash.com/photo-1498557850523-fd3d118b962e?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 1,
                'category_slug' => 'fruits',
                'name' => 'Crisp Honeycrisp Orchard Apples',
                'slug' => 'crisp-honeycrisp-orchard-apples',
                'description' => 'Unwaxed, balanced sweet-tart Honeycrisp apples fresh from Riverbend century-old orchard trees.',
                'price' => 4.20,
                'unit' => 'kg',
                'stock_quantity' => 70,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Picked this week',
                'image' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=600&q=80',
            ],

            // Farmer 2: Highland Natural Apiaries & Honey
            [
                'farmer_idx' => 2,
                'category_slug' => 'preserves-honey',
                'name' => 'Raw Wildflower Meadow Honey',
                'slug' => 'raw-wildflower-meadow-honey',
                'description' => 'Pure unpasteurized honey rich in natural pollens and enzymes. Golden amber flavor with delicate floral undertones.',
                'price' => 9.50,
                'unit' => '500g jar',
                'stock_quantity' => 40,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Late Summer Harvest',
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 2,
                'category_slug' => 'preserves-honey',
                'name' => 'Artisan Strawberry Thyme Jam',
                'slug' => 'artisan-strawberry-thyme-jam',
                'description' => 'Handcrafted small-batch fruit preserves cooked in copper kettles with organic cane sugar and garden thyme.',
                'price' => 7.00,
                'unit' => '250ml jar',
                'stock_quantity' => 28,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Artisan batched weekly',
                'image' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=600&q=80',
            ],

            // Farmer 3: Artisan Grove Sourdough & Hearth
            [
                'farmer_idx' => 3,
                'category_slug' => 'baked-goods',
                'name' => 'San Francisco Style Country Sourdough',
                'slug' => 'san-francisco-style-country-sourdough',
                'description' => '36-hour slow cold fermentation loaf with blistered crust, open airy crumb, and signature tangy flavor.',
                'price' => 6.50,
                'unit' => 'loaf (800g)',
                'stock_quantity' => 35,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Baked dawn of market day',
                'image' => 'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 3,
                'category_slug' => 'baked-goods',
                'name' => 'Rosemary Sea Salt Olive Oil Focaccia',
                'slug' => 'rosemary-sea-salt-focaccia',
                'description' => 'Fluffy, pillowy focaccia dimpled with cold-pressed olive oil, Maldon flaked sea salt, and fresh garden rosemary.',
                'price' => 5.00,
                'unit' => 'slab',
                'stock_quantity' => 20,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Baked dawn of market day',
                'image' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 3,
                'category_slug' => 'baked-goods',
                'name' => 'French Pure Butter Morning Croissants',
                'slug' => 'french-pure-butter-morning-croissants',
                'description' => 'Traditional 27-layer laminated puff pastry croissants made with cultured European butter.',
                'price' => 4.00,
                'unit' => 'pack of 2',
                'stock_quantity' => 25,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Baked dawn of market day',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=600&q=80',
            ],

            // Farmer 4: Green Meadow Dairy & Pastures
            [
                'farmer_idx' => 4,
                'category_slug' => 'dairy',
                'name' => 'Farmstead Aged Herb Jack Cheese',
                'slug' => 'farmstead-aged-herb-jack-cheese',
                'description' => 'Handmade raw milk Monterey Jack aged 6 months, infused with garden chives, garlic, and cracked pepper.',
                'price' => 8.50,
                'unit' => '250g wedge',
                'stock_quantity' => 30,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Aged 180 days',
                'image' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 4,
                'category_slug' => 'dairy',
                'name' => 'Pasture-Raised Organic Farm Eggs',
                'slug' => 'pasture-raised-organic-farm-eggs',
                'description' => 'Rich, deep-orange yolks from hens foraging freely on clover and alfalfa fields under open skies.',
                'price' => 6.00,
                'unit' => 'dozen',
                'stock_quantity' => 50,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Collected daily',
                'image' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'farmer_idx' => 4,
                'category_slug' => 'dairy',
                'name' => 'Cultured Churned Sweet Cream Butter',
                'slug' => 'cultured-churned-sweet-cream-butter',
                'description' => 'Slow-churned 84% butterfat pasture butter lightly finished with fleur de sel. Incredibly rich and creamy.',
                'price' => 5.50,
                'unit' => '250g block',
                'stock_quantity' => 25,
                'is_sold_out' => false,
                'is_weekly_template' => true,
                'harvest_date' => 'Churned every Thursday',
                'image' => 'https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?auto=format&fit=crop&w=600&q=80',
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $pData) {
            $farmer = $createdFarmerProfiles[$pData['farmer_idx']];
            $category = $createdCategories[$pData['category_slug']];

            $createdProducts[] = Product::updateOrCreate(
                ['slug' => $pData['slug']],
                [
                    'farmer_id' => $farmer->id,
                    'category_id' => $category->id,
                    'name' => $pData['name'],
                    'slug' => $pData['slug'],
                    'description' => $pData['description'],
                    'price' => $pData['price'],
                    'unit' => $pData['unit'],
                    'stock_quantity' => $pData['stock_quantity'],
                    'is_sold_out' => $pData['is_sold_out'],
                    'is_weekly_template' => $pData['is_weekly_template'],
                    'harvest_date' => $pData['harvest_date'],
                    'image' => $pData['image'],
                ]
            );
        }

        // 7. Sample Orders for customer Sarah Jenkins
        $order1 = Order::updateOrCreate(
            ['order_number' => 'ML-2026-9001'],
            [
                'customer_id' => $customerSarah->id,
                'farmer_id' => $createdFarmerProfiles[0]->id, // Sunny Valley
                'market_id' => $createdMarkets[0]->id, // Downtown Market
                'total_amount' => 14.70,
                'pickup_date' => now()->addDays(2)->format('Y-m-d'),
                'pickup_time_slot' => '08:00 AM - 10:00 AM',
                'order_status' => 'accepted',
                'payment_status' => 'Pay at Pickup (Cash/Card)',
                'customer_notes' => 'Please pick ripe red tomatoes, we are hosting Sunday lunch!',
                'farmer_notes' => 'Reserved our finest beefsteaks for you!',
                'cutoff_time' => now()->addDays(1)->setTime(20, 0),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'product_id' => $createdProducts[0]->id],
            ['quantity' => 2, 'unit_price' => 4.50, 'subtotal' => 9.00]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'product_id' => $createdProducts[1]->id],
            ['quantity' => 1, 'unit_price' => 3.20, 'subtotal' => 3.20]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'product_id' => $createdProducts[3]->id],
            ['quantity' => 1, 'unit_price' => 2.50, 'subtotal' => 2.50]
        );

        $order2 = Order::updateOrCreate(
            ['order_number' => 'ML-2026-9002'],
            [
                'customer_id' => $customerSarah->id,
                'farmer_id' => $createdFarmerProfiles[3]->id, // Artisan Grove Bakery
                'market_id' => $createdMarkets[0]->id,
                'total_amount' => 15.50,
                'pickup_date' => now()->addDays(2)->format('Y-m-d'),
                'pickup_time_slot' => '09:30 AM - 11:30 AM',
                'order_status' => 'ready_for_pickup',
                'payment_status' => 'Pay at Pickup (Cash/Card)',
                'customer_notes' => 'Looking forward to the warm sourdough loaf.',
                'farmer_notes' => 'Your loaf has been marked and bagged with love!',
                'cutoff_time' => now()->addDays(1)->setTime(18, 0),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order2->id, 'product_id' => $createdProducts[9]->id],
            ['quantity' => 1, 'unit_price' => 6.50, 'subtotal' => 6.50]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order2->id, 'product_id' => $createdProducts[10]->id],
            ['quantity' => 1, 'unit_price' => 5.00, 'subtotal' => 5.00]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order2->id, 'product_id' => $createdProducts[11]->id],
            ['quantity' => 1, 'unit_price' => 4.00, 'subtotal' => 4.00]
        );

        $order3 = Order::updateOrCreate(
            ['order_number' => 'ML-2026-8940'],
            [
                'customer_id' => $customerSarah->id,
                'farmer_id' => $createdFarmerProfiles[1]->id, // Riverbend Berries
                'market_id' => $createdMarkets[1]->id,
                'total_amount' => 17.50,
                'pickup_date' => now()->subDays(5)->format('Y-m-d'),
                'pickup_time_slot' => '10:30 AM - 12:30 PM',
                'order_status' => 'completed',
                'payment_status' => 'Paid in Cash at Stall',
                'customer_notes' => 'Strawberries were phenomenal!',
                'farmer_notes' => 'Thank you Sarah!',
                'cutoff_time' => now()->subDays(6)->setTime(20, 0),
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $order3->id, 'product_id' => $createdProducts[4]->id],
            ['quantity' => 2, 'unit_price' => 5.50, 'subtotal' => 11.00]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order3->id, 'product_id' => $createdProducts[5]->id],
            ['quantity' => 1, 'unit_price' => 6.00, 'subtotal' => 6.00]
        );

        // 8. Reviews
        Review::updateOrCreate(
            ['order_id' => $order3->id, 'customer_id' => $customerSarah->id],
            [
                'farmer_id' => $createdFarmerProfiles[1]->id,
                'product_id' => $createdProducts[4]->id,
                'rating' => 5,
                'comment' => 'The mountain strawberries were the sweetest we have ever tasted. Pre-ordering made pickup completely hassle-free with zero line waiting!',
                'farmer_reply' => 'Thank you Sarah! So thrilled your family enjoyed them. Looking forward to seeing you this Saturday!',
                'farmer_replied_at' => now()->subDays(4),
            ]
        );

        Review::updateOrCreate(
            ['customer_id' => $customerMichael->id, 'product_id' => $createdProducts[0]->id],
            [
                'farmer_id' => $createdFarmerProfiles[0]->id,
                'rating' => 5,
                'comment' => 'Incredible heirloom tomatoes! You can truly taste the difference of fresh farm harvest compared to supermarket produce.',
                'farmer_reply' => 'We take great pride in our composted soil nutrients! Appreciate your review Michael!',
                'farmer_replied_at' => now()->subDays(2),
            ]
        );

        Review::updateOrCreate(
            ['customer_id' => $customerEmily->id, 'product_id' => $createdProducts[9]->id],
            [
                'farmer_id' => $createdFarmerProfiles[3]->id,
                'rating' => 5,
                'comment' => 'The crust on the sourdough was crispy, deep golden, and the crumb had the most amazing fermented aroma. Will pre-order every week!',
                'farmer_reply' => 'Hearing this makes early 3 AM baking shifts completely worth it! Thank you Emily!',
                'farmer_replied_at' => now()->subDay(),
            ]
        );

        // 9. Favorites for Sarah
        Favorite::firstOrCreate([
            'user_id' => $customerSarah->id,
            'favoritable_type' => 'App\Models\Product',
            'favoritable_id' => $createdProducts[0]->id,
        ]);
        Favorite::firstOrCreate([
            'user_id' => $customerSarah->id,
            'favoritable_type' => 'App\Models\FarmerProfile',
            'favoritable_id' => $createdFarmerProfiles[0]->id,
        ]);

        // 10. Announcements
        Announcement::updateOrCreate(
            ['title' => 'Welcome to the New Harvest Season & MarketLink Launch!'],
            [
                'admin_id' => $admin->id,
                'message' => 'We are excited to launch MarketLink across Springfield! Reserve your weekly farm baskets, avoid the sellouts, and pick up fresh at your local stalls.',
                'target_role' => 'all',
                'is_active' => true,
            ]
        );

        Announcement::updateOrCreate(
            ['title' => 'Downtown Market Saturday Pre-Order Cutoff: Friday 8:00 PM'],
            [
                'admin_id' => $admin->id,
                'message' => 'Dear Customers, remember to place your weekend pre-orders before Friday 8 PM so our local farmers can harvest and pack your fresh orders.',
                'target_role' => 'customer',
                'is_active' => true,
            ]
        );

        // 11. Reports
        Report::updateOrCreate(
            ['title' => 'Market Performance & Pre-Order Volume Summary Q3'],
            [
                'generated_by' => $admin->id,
                'report_type' => 'sales_summary',
                'summary' => 'Platform aggregated 487 pre-orders across 4 regional markets, driving $12,480 in direct farm revenue with 0% packaging waste.',
                'data' => [
                    'total_revenue' => 12480,
                    'total_orders' => 487,
                    'active_farmers' => 5,
                    'active_customers' => 128,
                    'top_selling_categories' => ['Vegetables', 'Baked Goods', 'Berries', 'Dairy'],
                ],
            ]
        );
    }
}
