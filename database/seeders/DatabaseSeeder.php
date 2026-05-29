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
        $serviceRows = require __DIR__.'/data/doconnect_services.php';
        $this->writePlaceholderMedia($serviceRows);

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Doconnect',
                'tagline' => 'Expert doctor for home visit — fast, reliable, personalised healthcare at home in Mumbai.',
                'meta_title' => 'Doconnect | Doctor home visit & on-call care Mumbai',
                'meta_description' => 'Doconnect brings doctor home visits, nursing, urgent support, IV therapy, wound care, labs, and more to Mumbai. Call +91 84248 45423 — 24×7 desk.',
                'phone' => '+91 84248 45423',
                'whatsapp' => '+91 84248 45423',
                'email' => 'info@doconnect.org',
                'address_line' => 'Serving Mumbai — Versova, Andheri, Andheri West, Four Bungalow, Goregaon, Jogeshwari, Malad, Oshiwara, Ram Mandir, Santacruz, and nearby areas.',
                'service_areas' => "Doctor for home visit in Andheri, Andheri West, Four Bungalow, Goregaon, Jogeshwari, Malad, Mumbai, Oshiwara, Ram Mandir, Santacruz, Versova, and surrounding neighbourhoods. Call to confirm coverage for your pin code.",
                'og_image_path' => 'seed/site/og.svg',
                'frontend_public_url' => config('app.url'),
                'open_hours' => '24 × 7',
                'stats' => [
                    ['label' => 'Home visits completed', 'value' => '2,500+'],
                    ['label' => 'Successful doctor consultations', 'value' => '4,800+'],
                    ['label' => 'Chronic care patients managed at home', 'value' => '1,200+'],
                    ['label' => 'Urgent care home visits completed', 'value' => '900+'],
                ],
                'testimonials' => [
                    [
                        'name' => 'Ramesh Dhoklam',
                        'quote' => 'Everything was arranged quickly and easily. The customer service was excellent, and I got the help I needed without delay.',
                    ],
                    [
                        'name' => 'Prince Chaurasiya',
                        'quote' => 'The booking process was straightforward. I secured my appointments without any issues. Highly satisfied!',
                    ],
                    [
                        'name' => 'Shashank Sinha',
                        'quote' => 'I was impressed by the care and professionalism shown by Doconnect. They were always available to answer my questions and ensure everything went smoothly.',
                    ],
                    [
                        'name' => 'Jayesh Patel',
                        'quote' => 'I had a fantastic experience with Doconnect! Booking a doctor for a home visit was quick, and arranging lab tests was hassle-free.',
                    ],
                    [
                        'name' => 'Vijay Gore',
                        'quote' => 'The Doconnect team was incredibly helpful. Their service exceeded my expectations, and I highly recommend it for anyone needing medical assistance.',
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How can I book a home visit for a doctor in Mumbai?',
                        'answer' => 'Call or WhatsApp +91 84248 45423 with the patient’s location, symptoms, and urgency. Our desk will propose a time window and what to keep ready (reports, medication list).',
                    ],
                    [
                        'question' => 'Can I request nebulisation at home in Mumbai?',
                        'answer' => 'Yes, when clinically appropriate and aligned with your treating doctor’s plan. Our team carries standard equipment and will advise if hospital care is safer.',
                    ],
                    [
                        'question' => 'How can I arrange injection administration at home?',
                        'answer' => 'Share the prescription and last dose timing. A clinician visits with supplies and documents the dose; controlled drugs follow legal and safety rules.',
                    ],
                    [
                        'question' => 'Do you offer wound care during home visits?',
                        'answer' => 'We provide dressing changes and wound review when suitable for home. Complex or infected wounds may need hospital referral.',
                    ],
                    [
                        'question' => 'Can you assess severe abdominal pain at home?',
                        'answer' => 'We can examine and stabilise where safe, with clear escalation to emergency care if red flags are present.',
                    ],
                    [
                        'question' => 'Is relief for shivering or fever available through home visits?',
                        'answer' => 'Yes—assessment, hydration advice, nebulisation or medications as prescribed, and guidance on when to move to the ER.',
                    ],
                    [
                        'question' => 'Can you treat high-grade fever at home?',
                        'answer' => 'We assess cause and severity, start supportive care per protocol, and coordinate tests or admission if needed.',
                    ],
                    [
                        'question' => 'Do you offer IV fluid therapy during home visits?',
                        'answer' => 'When prescribed and safe at home, our team can administer IV fluids with monitoring and discharge instructions.',
                    ],
                    [
                        'question' => 'Can small stitches be done at home?',
                        'answer' => 'Minor, clean lacerations may be closed at home if appropriate. Deep, contaminated, or facial wounds may be referred.',
                    ],
                    [
                        'question' => 'Can urethral catheterisation be done at home?',
                        'answer' => 'Only when clinically indicated, with sterile technique and follow-up plan. Some cases belong in hospital.',
                    ],
                    [
                        'question' => 'Is home consultation available across Mumbai?',
                        'answer' => 'We serve listed western and central Mumbai neighbourhoods; confirm coverage for your pin code when you call.',
                    ],
                ],
            ]
        );

        $sections = [
            [
                'section_key' => 'hero',
                'heading' => 'Expert doctor for home visit',
                'subheading' => 'Fast, reliable, and personalised healthcare at home — for general illness, elderly care, bedridden patients, and chronic conditions across Mumbai.',
                'body' => 'Skip long queues and travel. Doconnect brings experienced clinicians to your door with clear plans, honest escalation, and follow-up you can count on.',
                'sort_order' => 0,
                'image_path' => 'seed/homepage/hero.svg',
            ],
            [
                'section_key' => 'about',
                'heading' => 'About Doconnect',
                'subheading' => 'Healthcare that meets you where you are.',
                'body' => "Welcome to Doconnect — we redefine care by bringing it home. Our mission is accessible, quality medical attention through doctor-for-home-visit services.\n\nWhether you manage chronic illness, recover from surgery, or need a routine check-up, our doctors help you heal comfortably. Forget long wait times: get the visit you need on your schedule.",
                'sort_order' => 10,
                'image_path' => 'seed/homepage/about.svg',
            ],
            [
                'section_key' => 'how_it_works',
                'heading' => 'How Doconnect works',
                'subheading' => 'Straightforward booking. Serious clinical standards.',
                'body' => "Call us to schedule — we confirm timing, equipment, and any special needs.\n\nOur medical professionals have strong hospital training, including experience with critically ill patients. They specialise in accurate assessment at home, precise diagnosis where appropriate, and treatment plans that improve outcomes — coordinating with hospital teams whenever admission is the safer choice.\n\nWe carry modern tools so you receive hospital-quality attention at your doorstep, plus ongoing care management for chronic and post-discharge needs.",
                'sort_order' => 20,
                'image_path' => null,
            ],
            [
                'section_key' => 'capabilities',
                'heading' => 'Comprehensive services we support',
                'subheading' => 'Examples of what families book with Doconnect.',
                'body' => "- Nebulisation\n- Sugar (blood glucose) checks\n- Injection administration\n- Dressing / wound care\n- Assessment of severe abdominal pain (with referral when needed)\n- Relief pathways for shivering and fever\n- Treatment planning for high-grade fever\n- IV fluid therapy when prescribed\n- Small stitches when suitable for home\n- Urethral catheterisation when clinically indicated\n- Consultation at home",
                'sort_order' => 30,
                'image_path' => null,
            ],
            [
                'section_key' => 'who_needs',
                'heading' => 'Who needs home visits?',
                'subheading' => 'Built for real Mumbai households.',
                'body' => "Home visits suit anyone who finds travel difficult — seniors, post-operative recovery, bedridden patients, or busy professionals.\n\nThey are especially helpful for diabetes and other chronic conditions that need regular review without repeated clinic trips.\n\nDoconnect is committed to compassionate, high-quality care tailored to your needs — preventive, chronic, or urgent support with clear guidance every time.",
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

        $this->call(DoconnectBlogPostsSeeder::class);
    }

    /**
     * @param  list<array{slug: string, title: string}>  $services
     */
    private function writePlaceholderMedia(array $services): void
    {
        SeedPlaceholderMedia::put('seed/site/og.svg', 'Doconnect', '#7a0a18');
        SeedPlaceholderMedia::put('seed/homepage/hero.svg', 'Doconnect — home visit', '#c8102e');
        SeedPlaceholderMedia::put('seed/homepage/about.svg', 'About Doconnect', '#9b0d23');
        SeedPlaceholderMedia::put('seed/homepage/who-needs.svg', 'Who we serve', '#e63950');

        foreach ($services as $i => $svc) {
            $palette = ['#c8102e', '#9b0d23', '#e63950', '#b30d28', '#d62839', '#a30c20', '#e85d6d', '#8f0a1c', '#7a0a18'];
            $path = 'seed/services/'.$svc['slug'].'.svg';
            SeedPlaceholderMedia::put($path, Str::limit($svc['title'], 40), $palette[$i % count($palette)]);
        }
    }
}
