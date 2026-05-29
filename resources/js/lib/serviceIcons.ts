import {
  Activity,
  Circle,
  CircleDot,
  Droplets,
  Flame,
  Gem,
  GitBranch,
  Heart,
  HeartPulse,
  Layers,
  Scissors,
  Shield,
  Stethoscope,
  Triangle,
  Waves,
  Zap,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';

export const SERVICE_ICONS: Record<string, LucideIcon> = {
  'piles-treatment': CircleDot,
  'fissure-treatment': Zap,
  'fistula-treatment': GitBranch,
  'pilonidal-sinus-treatment': Triangle,
  'gallbladder-stone-treatment': Gem,
  'hernia-treatment': Shield,
  'hydrocele-treatment': Droplets,
  'phimosis-circumcision': Scissors,
  'appendix-surgery': Activity,
  'lipoma-removal': Circle,
  'sebaceous-cyst-removal': Layers,
  'abscess-treatment': Zap,
  'diabetic-foot-care': HeartPulse,
  'varicose-vein-treatment': Waves,
  'gerd-acidity-treatment': Flame,
  'constipation-treatment': Activity,
  'varicocelectomy': Heart,
  'fibroadenoma-removal': Circle,
};

export function serviceIcon(slug: string): LucideIcon {
  return SERVICE_ICONS[slug] ?? Stethoscope;
}
