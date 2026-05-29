<?php

/**
 * Doconnect service catalogue for seeding.
 *
 * @return list<array{title: string, slug: string, short_description: string, body: string, sort_order: int}>
 */
return [
    [
        'title' => 'Doctor for home visit',
        'slug' => 'doctor-for-home-visit',
        'short_description' => 'Book a physician-led consultation at home—assessment, prescriptions, and follow-up planning.',
        'body' => '<ul><li>Nebulisation for respiratory issues when prescribed</li><li>BP and vitals monitoring</li><li>Injection administration as ordered</li><li>Home consultation with clear documentation</li></ul>',
        'sort_order' => 0,
    ],
    [
        'title' => 'Sugar check',
        'slug' => 'sugar-check',
        'short_description' => 'Convenient blood glucose testing at home with timely results for diabetes management.',
        'body' => '<ul><li>Capillary glucose checks</li><li>Quick results for timely decisions</li><li>Guidance aligned with your treating physician</li><li>Professional, hygienic technique</li></ul>',
        'sort_order' => 10,
    ],
    [
        'title' => 'Dressing & wound care',
        'slug' => 'dressing-wound-care',
        'short_description' => 'Dressings, minor wound management, and catheter care at home when clinically appropriate.',
        'body' => '<ul><li>Dressing changes and wound assessment</li><li>Small stitches for minor lacerations when suitable for home</li><li>Urethral catheterisation when indicated and supervised</li><li>Scheduled follow-ups for healing progress</li></ul>',
        'sort_order' => 20,
    ],
    [
        'title' => 'Urgent care at home',
        'slug' => 'urgent-care-at-home',
        'short_description' => 'Assessment for urgent symptoms such as high fever or severe abdominal pain—with clear escalation advice.',
        'body' => '<ul><li>Evaluation of high-grade fever</li><li>Assessment of severe abdominal pain</li><li>Support for shivering and dehydration concerns</li><li>Coordination with hospital teams when admission is needed</li></ul>',
        'sort_order' => 30,
    ],
    [
        'title' => 'IV fluid therapy',
        'slug' => 'iv-fluid-therapy',
        'short_description' => 'IV fluids and prescribed injectables at home with monitoring and aftercare instructions.',
        'body' => '<ul><li>IV fluid administration when prescribed</li><li>Vital monitoring during therapy</li><li>Medication injections per order</li><li>Aftercare advice for safe recovery at home</li></ul>',
        'sort_order' => 40,
    ],
    [
        'title' => 'Nursing care',
        'slug' => 'nursing-care',
        'short_description' => 'Skilled nursing visits for post-operative support, elderly assistance, and chronic disease routines.',
        'body' => '<ul><li>Post-operative care pathways</li><li>Elderly support and daily care tasks</li><li>Medication administration and education</li><li>Health monitoring with physician oversight</li></ul>',
        'sort_order' => 50,
    ],
    [
        'title' => 'Physiotherapy at home',
        'slug' => 'physiotherapy-at-home',
        'short_description' => 'Rehabilitation, mobility, and pain-management sessions in the comfort of your home.',
        'body' => '<ul><li>Injury rehabilitation programmes</li><li>Pain management techniques</li><li>Customised exercise and mobility plans</li><li>Convenient scheduling across Mumbai</li></ul>',
        'sort_order' => 60,
    ],
    [
        'title' => 'Home lab testing',
        'slug' => 'home-lab-testing',
        'short_description' => 'Sample collection at home with hygienic technique and digital reporting where available.',
        'body' => '<ul><li>Blood and urine sample collection</li><li>Safe, hygienic technique</li><li>Fast turnaround for routine panels</li><li>Results shared with your doctor</li></ul>',
        'sort_order' => 70,
    ],
    [
        'title' => 'Mental health support',
        'slug' => 'mental-health-support',
        'short_description' => 'Confidential consultations and referrals for stress, anxiety, and other mental health concerns.',
        'body' => '<ul><li>Physician-led assessment and counselling basics</li><li>Referrals to psychiatry/psychology when needed</li><li>Flexible scheduling</li><li>Privacy-first approach</li></ul>',
        'sort_order' => 80,
    ],
];
