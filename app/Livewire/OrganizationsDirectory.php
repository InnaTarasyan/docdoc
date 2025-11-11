<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\Organization;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class OrganizationsDirectory extends Component
{
	use WithPagination;

	#[Url(as: 'q')]
	public string $query = '';

	#[Url]
	public string $state = '';

	#[Url]
	public string $city = '';

	#[Url]
	public string $specialty = '';

	public function updating($name, $value): void
	{
		$this->resetPage();
	}

	#[Layout('layouts.app')]
	public function render(): View
	{
		$organizations = Organization::query()
			->when($this->query !== '', fn ($q) => $q->where('name', 'like', '%' . $this->query . '%'))
			->when($this->state !== '', fn ($q) => $q->where('state', $this->state))
			->when($this->city !== '', fn ($q) => $q->where('city', $this->city))
			->when($this->specialty !== '', function ($q) {
				$q->whereIn('name', function ($sub) {
					$sub->select('organization_name')
						->from((new Doctor())->getTable())
						->where('taxonomy', 'like', '%' . $this->specialty . '%')
						->whereNotNull('organization_name');
				});
			})
			->orderBy('name')
			->paginate(20);

		$states = Organization::query()->select('state')->whereNotNull('state')->distinct()->orderBy('state')->pluck('state');
		$cities = Organization::query()
			->when($this->state !== '', fn ($q) => $q->where('state', $this->state))
			->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

		$specialties = Doctor::query()
			->select('taxonomy')->whereNotNull('taxonomy')->distinct()->orderBy('taxonomy')->pluck('taxonomy');

		return view('livewire.organizations-directory', [
			'organizations' => $organizations,
			'states' => $states,
			'cities' => $cities,
			'specialties' => $specialties,
		])->title('Organizations');
	}
}





