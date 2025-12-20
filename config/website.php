<?php

return [
    // ============================================
    // COMPANY INFORMATION
    // ============================================
    'name' => 'SgSolar',
    'logo' => 'png/SG-01.png',
    'slogan' => 'Powering Tomorrow with Clean Energy Today',
    'mission' => 'At SgSolar, we are committed to providing sustainable, eco-friendly solar water heating solutions that reduce energy costs and environmental impact. Our mission is to harness the power of the sun to deliver efficient, reliable, and affordable heating systems for homes and businesses.',
    
    // ============================================
    // CONTACT INFORMATION
    // ============================================
    'contact' => [
        'phone' => '01103740202',
        'phone2' => '01103740201',
        'whatsapp' => '01103740202',
        'email' => 'info@sgsolar.com',
        'address' => '201 - 40 الملتقي العربي شيراتون المطار - النزهة - القاهرة',
        'maps_link' => 'https://maps.app.goo.gl/tHgYSeWPymNs28868?g_st=aw',
    ],

    // ============================================
    // BRANDING & COLORS
    // ============================================
    'primary_color' => '#FFDF41',      // Yellow
    'secondary_color' => '#E3A000',    // Orange
    'dark_green' => '#0C2D1C',         // Dark Green
    'forest_green' => '#115F45',       // Forest Green
    'light_green' => '#8CC63F',        // Light Green/Eco Green
    'background_color' => '#FFFFFF',
    'text_color' => '#0C2D1C',
    'font' => 'Inter',

    // ============================================
    // GRADIENTS
    // ============================================
    'gradients' => [
        'yellow_orange' => 'linear-gradient(135deg, #FFDF41 0%, #E3A000 100%)',
        'green' => 'linear-gradient(135deg, #8CC63F 0%, #115F45 100%)',
    ],

    // ============================================
    // PRODUCTS (Single Source)
    // ============================================
    'products' => [
        [
            'name_key' => 'products.product1',
            'image' => 'https://images.unsplash.com/photo-1560422920-f1ebe3523c8e?w=800&h=600&fit=crop&q=80',
            'description_key' => 'products.product1_desc',
            'features_key' => 'products.product1_features',
            'price' => '3,500',
            'currency' => 'EGP',
        ],
        [
            'name_key' => 'products.product2',
            'image' => 'https://images.unsplash.com/photo-1624397640148-949b1732bb0a?w=800&h=600&fit=crop&q=80',
            'description_key' => 'products.product2_desc',
            'features_key' => 'products.product2_features',
            'price' => '7,800',
            'currency' => 'EGP',
        ],
        [
            'name_key' => 'products.product3',
            'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?w=800&h=600&fit=crop&q=80',
            'description_key' => 'products.product3_desc',
            'features_key' => 'products.product3_features',
            'price' => '2,800',
            'currency' => 'EGP',
        ],
        [
            'name_key' => 'products.product4',
            'image' => 'https://images.unsplash.com/photo-1595437193398-f24279553f4f?w=800&h=600&fit=crop&q=80',
            'description_key' => 'products.product4_desc',
            'features_key' => 'products.product4_features',
            'price' => '4,500',
            'currency' => 'EGP',
        ],
        [
            'name_key' => 'products.product5',
            'image' => 'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?w=800&h=600&fit=crop&q=80',
            'description_key' => 'products.product5_desc',
            'features_key' => 'products.product5_features',
            'price' => '6,200',
            'currency' => 'EGP',
        ],
        [
            'name_key' => 'products.product6',
            'image' => 'https://images.unsplash.com/photo-1584267385494-9fdd9a71ad75?w=800&h=600&fit=crop&q=80',
            'description_key' => 'products.product6_desc',
            'features_key' => 'products.product6_features',
            'price' => '5,400',
            'currency' => 'EGP',
        ],
    ],

    // ============================================
    // HERO SECTION
    // ============================================
    'hero' => [
        'title' => 'Solar Water Heaters for a Sustainable Future',
        'subtitle' => 'Reduce your energy bills by up to 70% with eco-friendly solar thermal technology. Clean energy, maximum efficiency, lasting reliability.',
        'cta_text' => 'Explore Our Solutions',
        'cta_link' => '/products',
        'background_image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?w=1920&h=1080&fit=crop&q=90',
    ],

    // ============================================
    // PRODUCTS
    // ============================================
    'products' => [
        [
            'name' => 'Residential Solar Water Heater',
            'image' => 'png/SG-03.png',
            'description' => 'Perfect for family homes, this efficient solar heater provides hot water year-round with minimal maintenance.',
            'features' => [
                'High heat retention technology',
                'Corrosion-resistant tank',
                'Eco-friendly refrigerant-free system',
                '5-year warranty',
                'Easy installation',
            ],
        ],
        [
            'name' => 'Commercial Solar Heater System',
            'image' => 'png/SG-04.png',
            'description' => 'Designed for businesses and large buildings, delivering reliable hot water supply at scale.',
            'features' => [
                'High-capacity thermal storage',
                'Weather-resistant panels',
                'Smart temperature control',
                'Energy-efficient design',
                'Low operational costs',
            ],
        ],
        [
            'name' => 'Compact Solar Heater',
            'image' => 'png/SG-05.png',
            'description' => 'Ideal for apartments and small spaces without compromising on performance.',
            'features' => [
                'Space-saving design',
                'Quick heating technology',
                'Durable aluminum frame', 
                'All-season performance',
                '3-year warranty',
            ],
        ],
        [
            'name' => 'Premium Solar Thermal System',
            'image' => 'png/SG-06.png',
            'description' => 'Our flagship model combining cutting-edge technology with superior energy efficiency.',
            'features' => [
                'Advanced collector panels',
                'Maximum energy conversion',
                'Smart monitoring system',
                'Extended lifespan',
                'Premium materials',
            ],
        ],
    ],

    // ============================================
    // SERVICES
    // ============================================
    'services' => [
        [
            'name' => 'Solar Heater Installation',
            'icon' => 'png/SG-02.png',
            'description' => 'Professional installation by certified technicians ensuring optimal performance and safety. We handle everything from site assessment to final testing.',
        ],
        [
            'name' => 'Maintenance & Repair',
            'icon' => 'png/SG-03.png',
            'description' => 'Regular maintenance and fast repair services to keep your solar heater running efficiently year after year.',
        ],
        [
            'name' => 'Energy Consultation',
            'icon' => 'png/SG-04.png',
            'description' => 'Expert advice on maximizing energy savings and choosing the right solar water heating solution for your needs.',
        ],
        [
            'name' => 'System Upgrades',
            'icon' => 'png/SG-05.png',
            'description' => 'Upgrade your existing water heating system to solar technology and start saving on energy costs immediately.',
        ],
        [
            'name' => 'Custom System Design',
            'icon' => 'png/SG-06.png',
            'description' => 'Tailored solar heating solutions designed specifically for your property size, location, and hot water requirements.',
        ],
        [
            'name' => 'Efficiency Inspection',
            'icon' => 'png/SG-01.png',
            'description' => 'Comprehensive energy efficiency audits to identify savings opportunities and optimize your solar heater performance.',
        ],
    ],

    // ============================================
    // GALLERY IMAGES
    // ============================================
    'gallery' => [
        'https://images.unsplash.com/photo-1509391366360-2e959784a276?w=800&h=600&fit=crop&q=85',
        'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?w=800&h=600&fit=crop&q=85',
        'https://images.unsplash.com/photo-1595437193398-f24279553f4f?w=800&h=600&fit=crop&q=85',
        'https://images.unsplash.com/photo-1624397640148-949b1732bb0a?w=800&h=600&fit=crop&q=85',
        'https://images.unsplash.com/photo-1560422920-f1ebe3523c8e?w=800&h=600&fit=crop&q=85',
        'https://images.unsplash.com/photo-1584267385494-9fdd9a71ad75?w=800&h=600&fit=crop&q=85',
        'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800&h=600&fit=crop&q=85',
        'https://images.unsplash.com/photo-1559302504-64aae6ca6b6d?w=800&h=600&fit=crop&q=85',
        'https://images.unsplash.com/photo-1466611653911-95081537e5b7?w=800&h=600&fit=crop&q=85',
    ],

    // ============================================
    // WHY CHOOSE SOLAR ENERGY
    // ============================================
    'why_solar' => [
        'eco_friendly',
        'cost_saving',
        'reliable',
        'efficient',
    ],

    // ============================================
    // WHY CHOOSE SGSOLAR
    // ============================================
    'why_us' => [
        'expertise',
        'quality',
        'support',
        'warranty',
    ],

    // ============================================
    // ABOUT PAGE CONTENT
    // ============================================
    'about' => [
        'intro_key' => 'about.intro',
        'vision_key' => 'about.vision',
        'mission_key' => 'about.mission',
        'image' => 'png/SG-02.png',
        
        // 5 Guarantees - Why Choose SG Solar
        'guarantees' => [
            [
                'icon' => 'fa-bolt',
                'title_key' => 'about.guarantee_1_title',
                'desc_key' => 'about.guarantee_1_desc',
            ],
            [
                'icon' => 'fa-shield-alt',
                'title_key' => 'about.guarantee_2_title',
                'desc_key' => 'about.guarantee_2_desc',
            ],
            [
                'icon' => 'fa-hand-holding-usd',
                'title_key' => 'about.guarantee_3_title',
                'desc_key' => 'about.guarantee_3_desc',
            ],
            [
                'icon' => 'fa-cogs',
                'title_key' => 'about.guarantee_4_title',
                'desc_key' => 'about.guarantee_4_desc',
            ],
            [
                'icon' => 'fa-leaf',
                'title_key' => 'about.guarantee_5_title',
                'desc_key' => 'about.guarantee_5_desc',
            ],
        ],
        
        // Animated Statistics
        'stats' => [
            ['number' => '10', 'suffix' => '+', 'label_key' => 'about.stats.years'],
            ['number' => '500', 'suffix' => '+', 'label_key' => 'about.stats.projects'],
            ['number' => '95', 'suffix' => '%', 'label_key' => 'about.stats.satisfaction'],
            ['number' => '24', 'suffix' => '/7', 'label_key' => 'about.stats.support'],
        ],
    ],
    
    // ============================================
    // SOLUTIONS PAGE CONTENT
    // ============================================
    'solutions' => [
        'solar_energy' => [
            [
                'type' => 'on_grid',
                'icon' => 'fa-plug',
                'title_key' => 'solutions.on_grid_title',
                'desc_key' => 'solutions.on_grid_desc',
                'how_it_works_key' => 'solutions.on_grid_how',
                'benefits_key' => 'solutions.on_grid_benefits',
            ],
            [
                'type' => 'off_grid',
                'icon' => 'fa-battery-full',
                'title_key' => 'solutions.off_grid_title',
                'desc_key' => 'solutions.off_grid_desc',
                'how_it_works_key' => 'solutions.off_grid_how',
                'benefits_key' => 'solutions.off_grid_benefits',
            ],
            [
                'type' => 'hybrid',
                'icon' => 'fa-sync-alt',
                'title_key' => 'solutions.hybrid_title',
                'desc_key' => 'solutions.hybrid_desc',
                'how_it_works_key' => 'solutions.hybrid_how',
                'benefits_key' => 'solutions.hybrid_benefits',
            ],
            [
                'type' => 'pumping',
                'icon' => 'fa-tint',
                'title_key' => 'solutions.pumping_title',
                'desc_key' => 'solutions.pumping_desc',
                'how_it_works_key' => 'solutions.pumping_how',
                'benefits_key' => 'solutions.pumping_benefits',
            ],
        ],
        'swh' => [
            'intro_key' => 'solutions.swh_intro',
            'types' => [
                [
                    'type' => 'flat_plate',
                    'title_key' => 'solutions.swh_flat_title',
                    'desc_key' => 'solutions.swh_flat_desc',
                ],
                [
                    'type' => 'evacuated_tube',
                    'title_key' => 'solutions.swh_evacuated_title',
                    'desc_key' => 'solutions.swh_evacuated_desc',
                ],
            ],
            'how_it_works_key' => 'solutions.swh_how_it_works',
        ],
        'solar_lights' => [
            'intro_key' => 'solutions.solar_lights_intro',
            'types' => [
                [
                    'type' => 'residential',
                    'icon' => 'fa-home',
                    'title_key' => 'solutions.lights_residential_title',
                    'desc_key' => 'solutions.lights_residential_desc',
                ],
                [
                    'type' => 'street',
                    'icon' => 'fa-road',
                    'title_key' => 'solutions.lights_street_title',
                    'desc_key' => 'solutions.lights_street_desc',
                ],
                [
                    'type' => 'security',
                    'icon' => 'fa-shield-alt',
                    'title_key' => 'solutions.lights_security_title',
                    'desc_key' => 'solutions.lights_security_desc',
                ],
            ],
        ],
    ],
    
    // ============================================
    // NEWS/BLOG ARTICLES
    // ============================================
    'news' => [
        [
            'id' => 1,
            'slug' => 'pv-systems-classification',
            'title_key' => 'news.article_1_title',
            'excerpt_key' => 'news.article_1_excerpt',
            'content_key' => 'news.article_1_content',
            'date' => '2025-01-15',
            'image' => '/images/news/pv-systems.jpg',
        ],
        [
            'id' => 2,
            'slug' => 'solar-water-heaters-guide',
            'title_key' => 'news.article_2_title',
            'excerpt_key' => 'news.article_2_excerpt',
            'content_key' => 'news.article_2_content',
            'date' => '2025-01-10',
            'image' => '/images/news/swh-guide.jpg',
        ],
        [
            'id' => 3,
            'slug' => 'solar-energy-faq',
            'title_key' => 'news.article_3_title',
            'excerpt_key' => 'news.article_3_excerpt',
            'content_key' => 'news.article_3_content',
            'date' => '2025-01-05',
            'image' => '/images/news/solar-faq.jpg',
        ],
    ],
    
    // ============================================
    // PROJECTS GALLERY
    // ============================================
    'projects' => [
        // Will be populated with real project images
        // Each project will have: title, location, capacity, image, description
    ],

    // ============================================
    // FOOTER
    // ============================================
    'footer' => [
        'quick_links' => [
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'About', 'url' => '/about'],
            ['name' => 'Products', 'url' => '/products'],
            ['name' => 'Services', 'url' => '/services'],
            ['name' => 'Gallery', 'url' => '/gallery'],
            ['name' => 'Contact', 'url' => '/contact'],
        ],
        'social_links' => [
            ['platform' => 'Facebook', 'url' => '#', 'icon' => 'facebook'],
            ['platform' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
            ['platform' => 'Twitter', 'url' => '#', 'icon' => 'twitter'],
            ['platform' => 'LinkedIn', 'url' => '#', 'icon' => 'linkedin'],
        ],
        'copyright' => '© 2025 SgSolar. All rights reserved. Powering the future with clean solar energy.',
    ],
    
    // ============================================
    // SOCIAL MEDIA LINKS
    // ============================================
    'social' => [
        'facebook' => 'https://www.facebook.com/sgsolar',
        'instagram' => 'https://www.instagram.com/sgsolar',
        'twitter' => 'https://twitter.com/sgsolar',
        'linkedin' => 'https://www.linkedin.com/company/sgsolar',
    ],

    // ============================================
    // CUSTOMER TESTIMONIALS
    // ============================================
    'testimonials' => [
        [
            'name' => 'محمود عبدالله',
            'message' => 'بصراحة شركة كانت مرتبة كل حاجة وجم في المعاد الي متفقين عليه وتركيب اسخان في وقت قليل وكمان معاملة شيك جدا',
            'rating' => 5,
        ],
        [
            'name' => 'أحمد محمد',
            'message' => 'انا اول مرة اركب طاقة شمسية ومنتظر منها اداء قوي وتوفير في الكهرباء والشركة كانت ممتازة في التعامل شكرا بشمهندس احمد',
            'rating' => 5,
        ],
        [
            'name' => 'محمد حسن',
            'message' => 'شخصيا من اول مكالمه لحد الاستلام حسيت اننا بنتعامل مع ناس فاهمين ومهتمين وسخانات الطاقه الشمسيه بتشتغل تمام وبقالي سنة بتعامل معاهم في اي ترشيح ومهتمين بالمتابعة مبيزهقوش',
            'rating' => 5,
        ],
        [
            'name' => 'خالد عبدالله',
            'message' => 'تجربه ممتازه من البدايه للنهايه الفريق محترف جدا والمنتجات عاليه الجوده واتمني يفضلو معانا في اي متابعة شكرا لاهتمامكم بكل التفاصيل',
            'rating' => 5,
        ],
        [
            'name' => 'سارة محمود', 
            'message' => 'راضيه جدا عن الخدمه والمتابعه المستمره السخان الشمسي شغال بكفاءه عاليه وتوفير ملحوظ فى الفواتير',
            'rating' => 5,
        ],
        [
            'name' => 'يوسف علي',
            'message' => 'ناس فاهمة وعندهم امانه ومحترمين في التعامل',
            'rating' => 5,
        ],
    ],

    // ============================================
    // NAVIGATION MENU
    // ============================================
    'menu' => [
        ['name' => 'Home', 'url' => '/'],
        ['name' => 'About', 'url' => '/about'],
        ['name' => 'Products', 'url' => '/products'],
        ['name' => 'Services', 'url' => '/services'],
        ['name' => 'Gallery', 'url' => '/gallery'],
        ['name' => 'Contact', 'url' => '/contact'],
    ],

    // ============================================
    // CALL TO ACTION
    // ============================================
    'cta' => [
        'title' => 'Ready to Switch to Solar?',
        'subtitle' => 'Join hundreds of satisfied customers enjoying clean, efficient, and affordable hot water.',
        'button_text' => 'Get a Free Quote',
        'button_link' => '/contact',
    ],
];
