<x-layout>
    @volt('dashboard')
    <div>
        <div class="row">
            <div class="col-md-6">
                <x-todo></x-todo>
            </div>
            <div class="col-md-6">
                <x-reports.income></x-reports.income>
            </div>
        </div>
    </div>
    @endvolt
</x-layout>
