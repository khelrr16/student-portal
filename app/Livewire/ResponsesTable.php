<?php

namespace App\Livewire;

use App\Services\GoogleSheetResponseService;
use Illuminate\Support\Str;
use Livewire\Component;

class ResponsesTable extends Component
{
    public array $responses = [];

    public array $selectedResponse = [];

    public array $columns = [
        ['key' => 'dateEntered', 'label' => 'Date Entered'],
        ['key' => 'fullName', 'label' => 'Full Name'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'shsStrand', 'label' => 'SHS Strand'],
        ['key' => 'birthdate', 'label' => 'Birthdate'],
        ['key' => 'address', 'label' => 'Complete Address'],
        ['key' => 'lrn', 'label' => 'LRN'],
        ['key' => 'sex', 'label' => 'Sex'],
        ['key' => 'civilStatus', 'label' => 'Civil Status'],
    ];

    public array $visibleColumns = ['dateEntered', 'fullName', 'email', 'shsStrand'];

    public bool $showColumnsModal = false;

    public bool $showDetailsModal = false;

    public bool $isLoading = true;

    public string $search = '';

    public string $sortBy = 'dateEntered';

    public string $sortDirection = 'asc';

    public string $errorMessage = '';

    public function mount(): void
    {
        $this->visibleColumns = session('responses.visible_columns', $this->visibleColumns);
    }

    public function loadResponses(GoogleSheetResponseService $service): void
    {
        $payload = $service->fetch();

        $this->responses = $payload['data'];
        $this->errorMessage = $payload['error'] ?? '';
        $this->isLoading = false;
    }

    public function sort(string $columnKey): void
    {
        if ($this->sortBy === $columnKey) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            return;
        }

        $this->sortBy = $columnKey;
        $this->sortDirection = 'asc';
    }

    public function openDetails(int $index): void
    {
        $this->selectedResponse = $this->filteredResponses[$index] ?? [];
        $this->showDetailsModal = true;
    }

    public function closeDetails(): void
    {
        $this->showDetailsModal = false;
    }

    public function saveColumns(): void
    {
        session(['responses.visible_columns' => $this->visibleColumns]);
        $this->showColumnsModal = false;
    }

    public function showColumn(string $columnKey): bool
    {
        return in_array($columnKey, $this->visibleColumns, true);
    }

    public function getFilteredResponsesProperty(): array
    {
        $search = Str::lower(trim($this->search));

        return collect($this->responses)
            ->filter(function (array $row) use ($search) {
                if ($search === '') {
                    return true;
                }

                foreach ($row as $value) {
                    if (Str::contains(Str::lower((string) $value), $search)) {
                        return true;
                    }
                }

                return false;
            })
            ->sort(function (array $first, array $second) {
                $firstValue = $this->sortValue($first, $this->sortBy);
                $secondValue = $this->sortValue($second, $this->sortBy);

                if ($firstValue === $secondValue) {
                    return 0;
                }

                $comparison = $firstValue <=> $secondValue;

                return $this->sortDirection === 'asc' ? $comparison : -$comparison;
            })
            ->values()
            ->all();
    }

    public function sortValue(array $row, string $columnKey): int|string
    {
        return match ($columnKey) {
            'fullName' => Str::lower($this->fullName($row)),
            'dateEntered' => strtotime((string) ($row['Timestamp'] ?? '')) ?: 0,
            'email' => Str::lower((string) ($row['Email Address'] ?? '')),
            'shsStrand' => Str::lower((string) ($row['SHS Strand'] ?? '')),
            'birthdate' => Str::lower((string) ($row['Birthdate'] ?? '')),
            'address' => Str::lower((string) ($row['Complete Address'] ?? '')),
            'lrn' => Str::lower((string) ($row['LRN'] ?? '')),
            'sex' => Str::lower((string) ($row['Sex'] ?? '')),
            'civilStatus' => Str::lower((string) ($row['Civil Status'] ?? '')),
            default => '',
        };
    }

    public function formatDate(?string $value): string
    {
        if (! $value) {
            return 'N/A';
        }

        $date = date_create($value);

        if (! $date) {
            return $value;
        }

        return $date->format('Y-m-d');
    }

    public function fullName(array $row): string
    {
        return collect([
            $row['First Name'] ?? null,
            $row['Middle Name'] ?? null,
            $row['Last Name'] ?? null,
            $row['Extension Name'] ?? null,
        ])
            ->filter(function ($value) {
                return filled($value) && Str::lower(trim((string) $value)) !== 'none';
            })
            ->implode(' ');
    }

    public function detailValue(array $row, string $key): string
    {
        $value = match ($key) {
            'First Name' => $row['First Name'] ?? null,
            'Middle Name' => $row['Middle Name'] ?? null,
            'Last Name' => $row['Last Name'] ?? null,
            'Extension Name' => $row['Extension Name'] ?? null,
            'Email' => $row['Email Address'] ?? null,
            'SHS Strand' => $row['SHS Strand'] ?? null,
            'Birthdate' => $row['Birthdate'] ?? null,
            'Complete Address' => $row['Complete Address'] ?? null,
            'LRN' => $row['LRN'] ?? null,
            'Place of Birth' => $row['Place of Birth'] ?? null,
            'Nationality' => $row['Nationality'] ?? null,
            'Sex' => $row['Sex'] ?? null,
            'Civil Status' => $row['Civil Status'] ?? null,
            'Religion' => $row['Religion'] ?? null,
            'Highest Educational Attainment' => $row['Highest Educational Attained'] ?? null,
            'Last School Attended' => $row['Last School Attended'] ?? null,
            'Last School Year Attended' => $row['Last School Year Attended'] ?? null,
            'SHS Grade Level' => $row['SHS Grade Level'] ?? null,
            default => null,
        };

        if (! filled($value) || Str::lower(trim((string) $value)) === 'none') {
            return 'N/A';
        }

        return (string) $value;
    }

    public function render()
    {
        return view('livewire.responses-table');
    }
}