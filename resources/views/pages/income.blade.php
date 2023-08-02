<?php

use function Livewire\Volt\{state};

state(['report' => false]);

$showReport = fn() => $this->report = !$this->report;

?>

<x-layout>
    @volt('page-income')
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
            <x-income.income-report></x-income.income-report>
        @endif
    </div>
    @endvolt
</x-layout>
