<?php

use function Livewire\Volt\{state};

state(['report' => false]);

$showReport = fn() => $this->report = !$this->report;

?>

<x-layout>
    @volt('buttons')
    <div>

        <button wire:click="showReport" class="btn btn-primary mt-5 mb-n5">
            @if($this->report)
                Show Reports
            @else
                Add New
            @endif
        </button>

        @if($this->report)
            <x-income></x-income>
        @else
            <x-reports.income></x-reports.income>
        @endif
    </div>
    @endvolt
</x-layout>
