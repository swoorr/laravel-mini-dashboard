<?php

use function Livewire\Volt\{state};

state(['report' => false]);

$showReport = fn() => $this->report = !$this->report;

?>
<x-layout>
    <div>
        <x-income.expense-report></x-income.expense-report>
    </div>
</x-layout>
