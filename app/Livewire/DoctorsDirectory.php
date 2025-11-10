<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DoctorsDirectory extends Component
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

	#[Url]
	public string $gender = '';

	public function updating($name, $value): void
	{
		$this->resetPage();
	}

	#[Layout('layouts.app')]
	public function render(): View
	{
		$doctors = Doctor::query()
			->when($this->query !== '', function ($q) {
				$q->where(function ($sub) {
					$term = '%' . $this->query . '%';
					$prefix = $this->query . '%';
					$sub->where('name', 'like', $term)
						->orWhere('taxonomy', 'like', $term)
						->orWhere('organization_name', 'like', $term)
						->orWhere('city', 'like', $prefix)
						->orWhere('state', 'like', $prefix);
				});
			})
			->when($this->state !== '', fn ($q) => $q->where('state', $this->state))
			->when($this->city !== '', fn ($q) => $q->where('city', $this->city))
			->when($this->specialty !== '', fn ($q) => $q->where('taxonomy', 'like', '%' . $this->specialty . '%'))
			->when($this->gender !== '', fn ($q) => $q->where('gender', $this->gender))
			->orderByRaw("
				CASE
					WHEN name LIKE ? THEN 1
					WHEN taxonomy LIKE ? THEN 2
					WHEN name LIKE ? THEN 3
					WHEN taxonomy LIKE ? THEN 4
					WHEN organization_name LIKE ? THEN 5
					WHEN city LIKE ? THEN 6
					WHEN state LIKE ? THEN 7
					ELSE 8
				END, name
			", [
				$this->query . '%',
				$this->query . '%',
				'%' . $this->query . '%',
				'%' . $this->query . '%',
				'%' . $this->query . '%',
				$this->query . '%',
				$this->query . '%',
			])
			->paginate(20);

		$states = Doctor::query()->select('state')->whereNotNull('state')->distinct()->orderBy('state')->pluck('state');
		$cities = Doctor::query()
			->when($this->state !== '', fn ($q) => $q->where('state', $this->state))
			->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
		$specialties = Specialty::query()->orderBy('description')->pluck('description');

		return view('livewire.doctors-directory', [
			'doctors' => $doctors,
			'states' => $states,
			'cities' => $cities,
			'specialties' => $specialties,
		])->title('Doctors');
	}
}




