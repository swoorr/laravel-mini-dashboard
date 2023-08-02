<?php

use App\Models\Income;
use function Livewire\Volt\{computed, state};


$addIncome = function () {
    Income::create(['title' => $this->title, 'amount' => $this->amount, 'date' => $this->date, 'type' => $this->type]);

    $this->title = '';
    $this->incomes = Income::where('type', 'expense');
};

$remove = function ($id) {
    Income::find($id)->delete();
    $this->incomes = Income::where('type', 'expense');
};



$totalSum = computed(function () {
    $incomeTypeIncome = Income::where('type', 'income')->sum('amount');
    $incomeTypeExpense = Income::where('type', 'expense')->sum('amount');

    return (object)[
        'income' => $incomeTypeIncome,
        'expense' => $incomeTypeExpense,
        'total' => $incomeTypeIncome - $incomeTypeExpense
    ];
});

state(title: null, amount: null, date: now()->format('d.m.Y'), type: 'income', incomes: Income::where('type','expense')->get());

?>

@volt('reports-expense')
<div class="mt-5">

    <h3>Expense Reports</h3>
    <div class="card card-body mb-4">
        Total: {{ $this->totalSum->total }} - {{ $this->totalSum->total > 0 ? 'Profit' : 'Loss' }} <br>
        <span>Expense : <b class="text-danger">{{ $this->totalSum->total < 0 ? $this->totalSum->total : 0 }}</b> </span>
        <span>Income : <b
                class="text-success">{{ $this->totalSum->total > 0 ? $this->totalSum->total : 0 }}</b> <br></span>

    </div>


    @if($this->incomes->count() === 0)
        <p>No incomes yet.</p>
    @else
        <table class="table table-bordered">
            <tr>
                <th>Title</th>
                <th>Amount</th>
            </tr>

            @foreach ($incomes as $income)
                <tr>
                    <td>
                            <span class="badge text-bg-light">
                                {{ $income->title }}
                            </span>
                        <span class="badge text-bg-light">
                                {{ $income->date }}
                            </span>
                    </td>
                    <td class="{{$income->type=='income'?'+':'text-danger'}}">
                        {{$income->type=='income'?'+':'-'}}
                        {{--                            format price with carbon--}}
                        {{ number_format($income->amount,2) }}
                    </td>

                </tr>
            @endforeach
        </table>
    @endif
</div>
@endvolt
