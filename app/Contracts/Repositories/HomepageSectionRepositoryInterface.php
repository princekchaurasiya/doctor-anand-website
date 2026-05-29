<?php

namespace App\Contracts\Repositories;

use App\Models\HomepageSection;
use Illuminate\Database\Eloquent\Collection;

interface HomepageSectionRepositoryInterface
{
    /**
     * @return Collection<int, HomepageSection>
     */
    public function allPublishedOrdered(): Collection;
}
