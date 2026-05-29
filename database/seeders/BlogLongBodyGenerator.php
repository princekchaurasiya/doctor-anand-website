<?php

namespace Database\Seeders;

/**
 * Expands seeded blog HTML to long-form educational content for Satatva Health.
 */
final class BlogLongBodyGenerator
{
    /** Minimum plain-text length for seeded blog articles. */
    public const MIN_CHARS = 2000;

    /**
     * @param  array{title: string, category: string, excerpt: string, body: string, slug: string}  $post
     */
    public static function html(array $post): string
    {
        $title = e($post['title']);
        $category = e($post['category']);
        $excerpt = e($post['excerpt']);
        $slug = $post['slug'];

        $intro = self::stripLeadingH1($post['body']);

        $sections = self::sections($title, $category, $excerpt, $slug);
        $html = '<h1>'.$title.'</h1>'.$intro;

        foreach ($sections as $section) {
            $html .= $section;
            if (self::plainTextLength($html) >= self::MIN_CHARS) {
                break;
            }
        }

        $pool = self::extraParagraphPool($title, $category);
        $i = abs(crc32($slug)) % count($pool);
        while (self::plainTextLength($html) < self::MIN_CHARS) {
            $html .= $pool[$i % count($pool)];
            $i++;
            if ($i > 200) {
                break;
            }
        }

        $html .= self::faqSection($title).self::closingBlock($title);

        return $html;
    }

    public static function plainTextLength(string $html): int
    {
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return strlen(trim($text));
    }

    private static function stripLeadingH1(string $html): string
    {
        $stripped = preg_replace('/<h1[^>]*>.*?<\/h1>\s*/is', '', $html, 1);

        return $stripped ?? $html;
    }

    private static function faqSection(string $title): string
    {
        return '<h2>Frequently Asked Questions</h2>'
            .'<h3>Does <strong>Satatva Health</strong> replace the emergency department?</h3>'
            .self::para('No. For chest pain, stroke symptoms, severe bleeding, or trouble breathing, use emergency services. Clinic-based surgical care complements emergency services for planned procedures and follow-up.')
            .'<h3>Who benefits most from topics like <em>'.$title.'</em>?</h3>'
            .self::para('Patients in Mumbai with surgical concerns — piles, fistula, hernia, gallbladder stones, and similar conditions — benefit from early specialist evaluation at Satatv Clinic.')
            .'<h3>How do I book a consultation?</h3>'
            .self::para('Call Satatva Health on +91 8286214707 or use the <a href="/contact">contact page</a> to request an appointment at Satatv Clinic, Kandivali West.')
            .'<h3>Is this article personalised medical advice?</h3>'
            .self::para('No. It is educational. Always follow instructions from your treating clinician when they differ from general guidance online.')
            .'<h3>What should I bring to my appointment?</h3>'
            .self::para('Bring identification, medication lists, and recent reports or imaging. See our <a href="/services">services</a> overview for conditions treated at Satatv Clinic.');
    }

    private static function wordCount(string $html): int
    {
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return str_word_count($text);
    }

    private static function emphasize(string $text): string
    {
        $text = preg_replace('/\b(Satatva Health)\b/u', '<strong>$1</strong>', $text) ?? $text;
        $text = preg_replace('/“([^”]+)”/u', '<em>$1</em>', $text) ?? $text;

        return $text;
    }

    private static function para(string $text): string
    {
        return '<p>'.self::emphasize($text).'</p>';
    }

    /**
     * @return list<string>
     */
    private static function sections(string $title, string $category, string $excerpt, string $slug): array
    {
        $seed = crc32($slug);

        return [
            '<h2>Why this topic matters for patients in Mumbai</h2>'
            .self::para(self::p1($title, $category, $excerpt))
            .self::para(self::p2($title, $category)),

            '<h2>How clinic-based surgical care supports recovery</h2>'
            .self::para(self::p3($title))
            .self::para(self::p4($category, $seed)),

            '<h2>What to expect before your appointment</h2>'
            .self::para(self::p5($title))
            .self::para(self::p6()),

            '<h2>During consultation: assessment, explanation, and next steps</h2>'
            .self::para(self::p7($title, $category))
            .self::para(self::p8($seed)),

            '<h2>Safety, documentation, and follow-up after treatment</h2>'
            .self::para(self::p9($title))
            .self::para(self::p10()),

            '<h2>Chronic conditions, older adults, and post-operative care</h2>'
            .self::para(self::p11($category))
            .self::para(self::p12($title)),

            '<h2>Coordination with hospitals, labs, and specialists</h2>'
            .self::para(self::p13())
            .self::para(self::p14($title, $seed)),

            '<h2>Costs, scheduling, and realistic expectations</h2>'
            .self::para(self::p15($excerpt))
            .self::para(self::p16()),

            '<h2>Common misconceptions—and clearer facts</h2>'
            .self::para(self::p17($title))
            .self::para(self::p18($category)),

            '<h2>When the emergency department is the right choice</h2>'
            .self::para(self::p19())
            .self::para(self::p20($title)),

            '<h2>Practical checklist for caregivers</h2>'
            .'<ul>'
            .'<li>Keep a single medication list with dose, timing, and prescriber name.</li>'
            .'<li>Store recent discharge summaries, investigation reports, and vaccination records in one folder.</li>'
            .'<li>Ensure good lighting, privacy, and a flat surface for the clinician to write notes or use equipment.</li>'
            .'<li>Write down questions as they occur—memory fades quickly during stressful weeks.</li>'
            .'<li>Confirm who will be present for consent discussions if the patient has fluctuating capacity.</li>'
            .'<li>Ask how to reach the team after hours and what symptoms should trigger an immediate escalation.</li>'
            .'<li>Photograph wounds or rashes only if your doctor requests dated images for comparison.</li>'
            .'<li>Plan hydration, meals, and rest before the visit so vitals reflect a typical day where possible.</li>'
            .'</ul>',

            '<h2>Questions worth asking Satatva Health about “'.$title.'”</h2>'
            .'<ol>'
            .'<li>Which symptoms can be safely assessed at home in my situation, and which cannot?</li>'
            .'<li>What equipment or supplies should I arrange before the visit?</li>'
            .'<li>How will my primary doctor or specialist receive the visit summary?</li>'
            .'<li>What follow-up timeline should I expect if symptoms change overnight?</li>'
            .'<li>How does Satatva Health coordinate if hospital admission becomes necessary?</li>'
            .'</ol>',
        ];
    }

    private static function p1(string $title, string $category, string $excerpt): string
    {
        return "Across Mumbai, families increasingly choose structured home medical support because travel, traffic, and long clinic queues can delay timely assessment. "
            ."This article focuses on “{$title}” under the broader theme of {$category}. "
            ."In plain terms: {$excerpt} "
            .'Satatva Health’s approach is to combine clinical rigour with practical logistics—clear communication, documented plans, and explicit escalation pathways when home management is not enough.';
    }

    private static function p2(string $title, string $category): string
    {
        return "When you read about {$title}, it helps to separate three layers: what science broadly supports for similar situations, what is appropriate for your specific diagnosis and prescriptions, and what can realistically be delivered safely in a home environment. "
            ."Categories such as {$category} often span multiple scenarios, so a responsible provider will ask focused questions, examine as needed, and avoid one-size-fits-all promises. "
            .'Satatva Health prioritises transparency: if a concern needs emergency care, advanced imaging, or a procedure suite, the team will say so early rather than risking a delayed referral.';
    }

    private static function p3(string $title): string
    {
        return "A strong home-care plan usually includes four pillars: accurate diagnosis where possible, symptom control, monitoring for deterioration, and caregiver education. "
            ."For topics related to {$title}, families often underestimate how much “small” details matter—sleep, hydration, medication timing, and subtle changes in alertness or breathing. "
            .'A physician-led home visit can capture context that short clinic encounters miss, because the clinician sees stairs, bathroom access, meal patterns, and social support first-hand.';
    }

    private static function p4(string $category, int $seed): string
    {
        $extra = ($seed % 2) === 0
            ? 'In many cases, the best outcomes happen when nursing visits, physiotherapy, and laboratory tests are coordinated rather than fragmented.'
            : 'Families also benefit when one clinical narrative is preserved across visits—especially for elderly patients with multiple specialists.';

        return "Within {$category}, continuity is a competitive advantage: fewer contradictory instructions, fewer duplicated tests, and clearer accountability. "
            .$extra
            .' Satatva Health aims to document each encounter in language you can understand, while retaining enough clinical detail for other providers to act on the same day if needed.';
    }

    private static function p5(string $title): string
    {
        return "Before a visit tied to {$title}, prepare the home like you would for an important meeting: reduce background noise, keep children and pets safely away from clinical work areas, and gather identification, insurance information if applicable, and a notepad. "
            .'If the patient uses glasses, hearing aids, or mobility aids, have them available. '
            .'If oxygen concentrators, nebulisers, or home monitoring devices are in use, keep them plugged in, charged, and accessible.';
    }

    private static function p6(): string
    {
        return 'If multiple family members provide care, nominate one spokesperson to avoid conflicting histories. '
            .'Write down the timeline: when symptoms began, what changed, what helped, and what made things worse. '
            .'If you have photographs of rashes, wounds, or swelling that your previous doctor approved for documentation, keep them organised by date. '
            .'Finally, ensure the patient wears loose clothing to simplify examination of the heart, lungs, abdomen, and limbs.';
    }

    private static function p7(string $title, string $category): string
    {
        return "During the consultation, expect structured questions that map directly to safety. "
            ."Even when the public title is {$title}, the clinician’s private priority list will always include red-flag symptoms, medication interactions, and risk of dehydration or falls. "
            ."For {$category} topics, the clinician may also review nutrition, sleep, mood, and functional status because these factors frequently influence recovery trajectories in community settings.";
    }

    private static function p8(int $seed): string
    {
        $a = ($seed % 3) === 0;
        $line = $a
            ? 'If intravenous medicines, nebulisation, or invasive procedures are discussed, consent, sterility, and monitoring standards should be explicit and non-negotiable.'
            : 'If the plan includes new prescriptions, ask about side effects, interactions with existing medicines, and what to stop or continue.';

        return 'After examination, you should receive a clear explanation in plain language, a written or digital summary, and a follow-up window. '
            .$line
            .' Satatva Health encourages patients and families to repeat back the plan in their own words—research shows this reduces misunderstandings dramatically.';
    }

    private static function p9(string $title): string
    {
        return "Safety does not end when the doctor leaves. Topics such as {$title} often require monitoring charts, warning symptoms, and a defined escalation route. "
            .'Satatva Health supports families by documenting vitals targets where relevant, wound-care intervals when applicable, and criteria for calling back versus going to the emergency department. '
            .'If you are unsure whether a symptom is “urgent enough,” err on the side of calling—clinicians prefer early questions to late collapses.';
    }

    private static function p10(): string
    {
        return 'Documentation also protects patients legally and clinically: dates, doses, allergies, and prior adverse reactions should live in one place. '
            .'If you switch pharmacies, hospitals, or specialists, carry an updated copy. '
            .'For Mumbai households with domestic travel or seasonal relocation, keep a digital backup on a phone you can access quickly during a crisis.';
    }

    private static function p11(string $category): string
    {
        return "Elderly patients and those with chronic diseases often need slower pacing, more repetition, and explicit fall-prevention advice—especially in {$category} scenarios. "
            .'Home visits can identify hazards like loose rugs, poor night lighting, and bathroom obstacles that contribute to injuries. '
            .'They can also uncover caregiver fatigue, which is a risk factor for medication errors. Satatva Health clinicians routinely ask who bears the overnight burden and whether respite support exists.';
    }

    private static function p12(string $title): string
    {
        return "Recovery after surgery or prolonged hospitalisation is another common reason families search for guidance related to {$title}. "
            .'Nutrition, deep breathing exercises when prescribed, early mobilisation, and wound surveillance all interact. '
            .'If pain is poorly controlled, patients sometimes under-walk and over-sedate, increasing clot risk; if pain is too aggressively controlled without monitoring, other risks appear. A balanced plan matters.';
    }

    private static function p13(): string
    {
        return 'Laboratory tests and imaging are not “extras”—they are tools that must be chosen for a reason. '
            .'When a home clinician orders tests, ask what decision will change based on the result and how quickly results arrive. '
            .'For many Mumbai patients, home phlebotomy reduces missed appointments; for others, near-hospital testing remains safer if instability is possible. '
            .'Satatva Health can help map the least burdensome pathway without compromising diagnostic quality.';
    }

    private static function p14(string $title, int $seed): string
    {
        $note = ($seed % 2) === 0
            ? 'Specialist referral letters are most useful when they include the specific question being asked and the urgency level.'
            : 'If you already have a trusted specialist, bring their latest note—even a photo—so the home team does not duplicate work.';

        return "Coordination is the hidden workload of modern medicine. For content centred on {$title}, remember that the best referrals are precise: what changed, what was tried, and what outcome you need next. "
            .$note;
    }

    private static function p15(string $excerpt): string
    {
        return "Cost conversations deserve calm timing—not at 2 a.m. during a panic spike. {$excerpt} "
            .'Ask for an estimate of visit fees, what is included, and whether add-ons like procedures, consumables, or night surcharges apply. '
            .'If you need documentation for reimbursement, request it early so billing codes and itemised receipts are correct the first time.';
    }

    private static function p16(): string
    {
        return 'Time windows matter in a dense city: traffic, festivals, and monsoon flooding can shift realistic arrival times. '
            .'Satatva Health sets expectations honestly because over-promising arrival minutes erodes trust. '
            .'If you are booking for an elderly relative, confirm that someone who knows the patient’s baseline will be present—not only a domestic helper who cannot authorise decisions.';
    }

    private static function p17(string $title): string
    {
        return "Myth: “If I can Google {$title}, I do not need a doctor.” Facts: search engines cannot examine you, cannot auscultate your chest, and cannot interpret subtle patterns across time. "
            .'Myth: “Home care is only for rich people.” Facts: total cost includes travel, lost wages, and repeated trips; for some families, home visits reduce expensive complications. '
            .'Myth: “A home visit replaces the hospital.” Facts: home care complements hospitals and depends on stability and consent.';
    }

    private static function p18(string $category): string
    {
        return "Another myth is that {$category} topics are purely “soft” advice. In reality, many decisions hinge on measurable trends—blood pressure averages, glucose patterns, weight, wound size, and functional scores. "
            .'When families track these consistently, clinicians can adjust therapy earlier. When tracking is absent, care becomes reactive rather than preventive.';
    }

    private static function p19(): string
    {
        return 'Go to the emergency department immediately for crushing chest pain, sudden weakness on one side, slurred speech, severe shortness of breath at rest, uncontrolled bleeding, altered consciousness, or major trauma. '
            .'If you are unsure but the symptom feels “thunderclap” new and severe, choose the emergency department. '
            .'Satatva Health will support you after stabilisation, but no blog post replaces emergency services for those patterns.';
    }

    private static function p20(string $title): string
    {
        return "As you reflect on {$title}, treat this article as a structured conversation starter rather than a personal prescription. "
            .'Use it to prepare questions, organise records, and understand trade-offs. '
            .'If anything here conflicts with your treating clinician’s direct instructions, follow your clinician—individual context always wins over general education.';
    }

    /**
     * @return list<string>
     */
    private static function extraParagraphPool(string $title, string $category): array
    {
        return [
            '<p>Satatva Health serves Mumbai households with a focus on respectful communication, punctuality where traffic allows, and clear escalation when home management is insufficient.</p>',
            '<p>Privacy matters: discuss sensitive topics only with people the patient wants in the room, and ask clinicians how visit notes are stored and shared.</p>',
            '<p>Infection control at home includes hand hygiene, clean surfaces for procedures, and safe disposal of sharps when injections are part of care.</p>',
            '<p>If the patient has multiple languages in the household, confirm that key instructions are understood—miscommunication is a preventable source of harm.</p>',
            '<p>Nutrition supports healing: adequate protein, consistent meal timing, and avoiding harmful food–drug interactions are practical levers families can pull.</p>',
            '<p>Sleep fragmentation worsens pain perception and blood pressure; small environmental changes can sometimes help as much as new medicines.</p>',
            '<p>Mental health symptoms deserve the same structured approach as physical symptoms—screening, safety planning, and referral pathways when needed.</p>',
            '<p>Physiotherapy goals should be specific: distance walked, stairs climbed, or pain score targets make progress measurable week to week.</p>',
            '<p>For diabetes care, pattern matters more than a single random reading; bring your glucometer or logs if you have them.</p>',
            '<p>Post-operative patients should understand which pain is “expected” versus which pain suggests complications—ask explicitly.</p>',
            '<p>Patients on blood thinners need extra caution with falls and procedures; always disclose anticoagulants before any invasive step.</p>',
            '<p>Children’s care at home requires weight-based dosing and guardian consent—keep growth charts and vaccine cards accessible.</p>',
            '<p>Patients with heart failure may need daily weight checks; ask your clinician what change should trigger a call the same day.</p>',
            '<p>Patients with COPD should know their baseline oxygen needs and when breathlessness exceeds their usual “bad day” pattern.</p>',
            '<p>Patients with kidney disease need careful fluid and electrolyte planning—do not change diets drastically without medical guidance.</p>',
            '<p>Patients with liver disease may metabolise medicines differently; bring a complete list including supplements and herbal products.</p>',
            '<p>Patients with pregnancy-related questions should seek obstetric-led pathways; not all home services are appropriate in pregnancy.</p>',
            '<p>Patients with cancer need oncology-directed plans; home support should align with tumour boards and treatment cycles.</p>',
            '<p>Patients with infections may need cultures before antibiotics; “stronger antibiotic” is not always the right answer.</p>',
            '<p>Patients with neurological conditions benefit from clear medication timing and fall precautions, especially at night.</p>',
            '<p>Tele-consults can bridge gaps but cannot replace examination when red flags exist—choose the modality that matches risk.</p>',
            '<p>Finally, remember that your specific situation intersects with the broader theme of home healthcare: bring your lived experience into the conversation so the plan fits your home, not a textbook ideal.</p>',
        ];
    }

    private static function closingBlock(string $title): string
    {
        return '<h2>Final note</h2>'
            .self::para('If you want personalised guidance related to '.$title.', call Satatva Health on +91 8286214707. '
            .'This article is educational and not a substitute for an in-person clinical assessment tailored to your history, examination, and investigations.')
            .'<div class="cta-section"><p>Book a <strong>consultation at Satatv Clinic, Kandivali West</strong>: call <strong>+91 8286214707</strong> or <a href="/contact">request an appointment</a> with <strong>Satatva Health</strong> today.</p></div>';
    }
}
