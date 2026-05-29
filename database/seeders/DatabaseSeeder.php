<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        /** @var list<array{title: string, slug: string, short_description: string, body: string, sort_order: int}> $serviceRows */
        $serviceRows = require __DIR__.'/data/services.php';
        $this->writePlaceholderMedia($serviceRows);

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Satatva Health',
                'tagline' => 'Expert surgical care by Dr. Anand S. Prajapati — General Surgeon, Ano-Proctologist & Laser Surgeon at Satatv Clinic, Kandivali West, Mumbai.',
                'meta_title' => 'Satatva Health | Dr. Anand S. Prajapati — General & Laser Surgeon Mumbai',
                'meta_description' => 'Satatva Health at Satatv Clinic offers piles, fistula, fissure, hernia, gallbladder, hydrocele, and general surgery by Dr. Anand S. Prajapati, M.S. Call +91 8286214707.',
                'phone' => '+91 8286214707',
                'whatsapp' => '+91 8286214707',
                'email' => 'prajapatianand2044@gmail.com',
                'address_line' => 'Goyal Aspire, 104, 1st Floor, Near Atul Tower, Mathuradas Ext Road, Kandivali West, Mumbai — 400 067.',
                'service_areas' => 'Satatv Clinic (सातत्व क्लिनिक), Kandivali West, Mumbai. Consultations and procedures at the clinic — not home visits.',
                'og_image_path' => 'seed/site/og.svg',
                'frontend_public_url' => config('app.url'),
                'open_hours' => 'Mon–Sat: 10:00 AM – 8:00 PM',
                'stats' => [
                    ['label' => 'Years of surgical experience', 'value' => '10+'],
                    ['label' => 'Procedures performed', 'value' => '3,000+'],
                    ['label' => 'Laser proctology cases', 'value' => '1,500+'],
                    ['label' => 'Happy patients', 'value' => '2,500+'],
                ],
                'testimonials' => [
                    [
                        'name' => 'Rajesh M.',
                        'quote' => 'Dr. Prajapati explained my piles treatment clearly. The laser procedure was smooth and recovery was faster than I expected.',
                    ],
                    [
                        'name' => 'Priya S.',
                        'quote' => 'Professional, caring, and thorough. The clinic is clean and well organised. Highly recommend Satatva Health for surgical care.',
                    ],
                    [
                        'name' => 'Amit K.',
                        'quote' => 'I had a hernia repair done here. Dr. Anand was reassuring throughout and the follow-up care was excellent.',
                    ],
                    [
                        'name' => 'Sneha P.',
                        'quote' => 'My father\'s fistula treatment was handled with great expertise. We felt informed and supported at every step.',
                    ],
                    [
                        'name' => 'Vikram D.',
                        'quote' => 'Clear diagnosis, honest advice, and skilled surgery for my gallbladder stones. Thank you to the entire Satatv Clinic team.',
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How do I book an appointment at Satatv Clinic?',
                        'answer' => 'Call or WhatsApp +91 8286214707, or use the contact form on this website. Share your symptoms and any prior reports so we can schedule the right consultation.',
                    ],
                    [
                        'question' => 'Does Satatva Health offer home visits?',
                        'answer' => 'No. All consultations and procedures take place at Satatv Clinic, Goyal Aspire, Kandivali West, Mumbai. We do not provide home-visit services.',
                    ],
                    [
                        'question' => 'What conditions does Dr. Anand S. Prajapati treat?',
                        'answer' => 'Piles, fissure, fistula, pilonidal sinus, hernia, gallbladder stones, hydrocele, phimosis, appendix, lipoma, sebaceous cyst, abscess, diabetic foot, varicose veins, and other general surgical conditions.',
                    ],
                    [
                        'question' => 'Is laser surgery available for piles and fistula?',
                        'answer' => 'Yes. Dr. Prajapati is a Consultant Ano-Proctologist & Laser Surgeon and offers modern laser and minimally invasive options where clinically appropriate.',
                    ],
                    [
                        'question' => 'What should I bring to my first visit?',
                        'answer' => 'Bring a valid ID, list of current medications, previous surgical or pathology reports, and any recent blood tests or imaging (ultrasound, CT, etc.) related to your condition.',
                    ],
                    [
                        'question' => 'Where is Satatv Clinic located?',
                        'answer' => 'Goyal Aspire, 104, 1st Floor, Near Atul Tower, Mathuradas Ext Road, Kandivali West, Mumbai — 400 067.',
                    ],
                    [
                        'question' => 'Do you accept health insurance?',
                        'answer' => 'Insurance coverage depends on your policy and the planned procedure. Please bring your insurance card and we will guide you on documentation and cashless options where applicable.',
                    ],
                    [
                        'question' => 'What are the clinic timings?',
                        'answer' => 'Monday to Saturday, 10:00 AM to 8:00 PM. Call ahead to confirm availability for your preferred time slot.',
                    ],
                ],
            ]
        );

        $sections = [
            [
                'section_key' => 'hero',
                'heading' => 'Dr. Anand S. Prajapati',
                'subheading' => 'M.S. (General Surgeon) · Consultant Ano-Proctologist & Laser Surgeon · Satatv Clinic, Kandivali West, Mumbai.',
                'body' => 'Expert surgical care for piles, fistula, fissure, hernia, gallbladder stones, hydrocele, and general surgery — with modern laser and minimally invasive techniques.',
                'sort_order' => 0,
                'image_path' => 'seed/homepage/hero.svg',
            ],
            [
                'section_key' => 'about',
                'heading' => 'About Satatva Health',
                'subheading' => 'Quality surgical care at Satatv Clinic.',
                'body' => "Welcome to Satatva Health — the practice of Dr. Anand S. Prajapati at Satatv Clinic (सातत्व क्लिनिक), Kandivali West.\n\nWe specialise in proctology, laser surgery, and general surgical procedures. Every patient receives a clear diagnosis, honest treatment options, and structured follow-up until recovery.",
                'sort_order' => 10,
                'image_path' => 'seed/homepage/about.svg',
            ],
            [
                'section_key' => 'how_it_works',
                'heading' => 'How to get care',
                'subheading' => 'Simple steps from consultation to recovery.',
                'body' => "Call or message us to book a clinic appointment — share your symptoms and any existing reports.\n\nDr. Prajapati examines you at Satatv Clinic, explains diagnosis and treatment options, and plans surgery or medical management as needed.\n\nAfter procedure or treatment, structured follow-up at the clinic ensures proper healing and answers every question along the way.",
                'sort_order' => 20,
                'image_path' => null,
            ],
            [
                'section_key' => 'capabilities',
                'heading' => 'Conditions we treat',
                'subheading' => 'Comprehensive general and proctology surgery at Satatv Clinic.',
                'body' => "- Piles & laser hemorrhoid treatment\n- Anal fissure & fistula\n- Pilonidal sinus\n- Gallbladder stones (laparoscopic)\n- Hernia repair\n- Hydrocele & varicocele\n- Phimosis & circumcision\n- Appendix surgery\n- Lipoma & sebaceous cyst removal\n- Abscess drainage\n- Diabetic foot care\n- Varicose veins\n- GERD / acidity evaluation\n- Constipation assessment\n- Fibroadenoma removal",
                'sort_order' => 30,
                'image_path' => null,
            ],
            [
                'section_key' => 'who_needs',
                'heading' => 'Who should visit?',
                'subheading' => 'If you have persistent symptoms, do not delay evaluation.',
                'body' => "Anyone with anal pain, bleeding, lumps, hernia bulge, gallbladder pain, scrotal swelling, skin lumps, diabetic foot wounds, or other surgical concerns should consult a specialist.\n\nEarly evaluation leads to simpler treatment and better outcomes.\n\nSatatva Health provides clinic-based care only — all visits and procedures are at Satatv Clinic, Kandivali West.",
                'sort_order' => 40,
                'image_path' => 'seed/homepage/who-needs.svg',
            ],
        ];

        foreach ($sections as $row) {
            HomepageSection::query()->updateOrCreate(
                ['section_key' => $row['section_key']],
                $row + ['is_published' => true]
            );
        }

        $slugs = array_column($serviceRows, 'slug');
        Service::query()->whereNotIn('slug', $slugs)->delete();

        foreach ($serviceRows as $row) {
            $path = 'seed/services/'.$row['slug'].'.svg';

            Service::query()->updateOrCreate(
                ['slug' => $row['slug']],
                $row + [
                    'is_published' => true,
                    'featured_image_path' => $path,
                ]
            );
        }

        $this->call(BlogPostsSeeder::class);
    }

    /**
     * @param  list<array{slug: string, title: string}>  $services
     */
    private function writePlaceholderMedia(array $services): void
    {
        SeedPlaceholderMedia::put('seed/site/og.svg', 'Satatva Health', '#4A2370');
        SeedPlaceholderMedia::put('seed/homepage/hero.svg', 'Satatva Health', '#5B2D8C');
        SeedPlaceholderMedia::put('seed/homepage/about.svg', 'Satatv Clinic', '#6B2FA0');
        SeedPlaceholderMedia::put('seed/homepage/who-needs.svg', 'Who we treat', '#7B4BA8');

        foreach ($services as $i => $svc) {
            $palette = ['#5B2D8C', '#4A2370', '#7B4BA8', '#6B2FA0', '#8B5FBF', '#3D1F5C', '#9B6FD4', '#E8B923'];
            $path = 'seed/services/'.$svc['slug'].'.svg';
            SeedPlaceholderMedia::put($path, Str::limit($svc['title'], 40), $palette[$i % count($palette)]);
        }
    }
}
