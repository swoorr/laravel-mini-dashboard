<?php

use App\Models\Income;
use function Livewire\Volt\{state,computed};

if (request()->get('search')) {
    $incomes = Income::where('title', 'like', '%' . request()->get('search') . '%')->get();
} else {
    $incomes = Income::all();
}


$addIncome = function () {
    Income::create(['title' => $this->title, 'amount' => $this->amount, 'date' => $this->date, 'type' => $this->type]);

    $this->title = '';
    $this->incomes = Income::all();
};

$remove = function ($id) {
    Income::find($id)->delete();
    $this->incomes = Income::all();
};

state(title: null, amount: null, date: now()->format('d.m.Y'), type: 'income', incomes: $incomes);
?>

    @volt
    <div class="mt-5">
        <script src="https://unpkg.com/imask"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

        <h3>Add Income </h3>
        <div class="card card-body mb-5">
            <form wire:submit="addIncome">
                <div class="form-label">
                    <label for="">Title</label>
                    <input class="form-control" type="text" wire:model="title">
                </div>
                <div class="form-label">
                    <label for="">Amount</label>
                    <input class="form-control" type="text" wire:model="amount">
                </div>
                <div class="form-label">
                    <label for="">Date</label>
                    <input type="text" id="date" class="form-control"
                           onChange="
                          @this.set('date', moment(this.value).format('YYYY-MM-DD'))
                           "
                    />
                    <script>
                        $(function () {
                            $('input#date').daterangepicker({
                                singleDatePicker: true,
                                showDropdowns: true,
                                minYear: 2023,
                            });
                        });
                    </script>
                </div>
                <div class="form-label">
                    <label for="">Type</label>
                    <select wire:model="type" class="form-control" value="income">
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>
                <button class="mt-2 btn btn-dark px-5" type="submit">Save</button>
            </form>
        </div>

        <h3>Incomes</h3>
        @if($this->incomes->count() === 0)
            <p>No incomes yet.</p>
        @else
            <table class="table table-bordered">
                <tr>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>

                @foreach ($incomes as $income)
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span class="badge text-bg-light">
                                {{ $income->title }}
                            </span>
                                <span class="badge text-bg-light">
                                {{ $income->date }}
                            </span>
                            </div>
                        </td>
                        <td class="{{$income->type=='income'?'+':'text-danger'}}">
                            {{$income->type=='income'?'+':'-'}}
                            {{--                            format price with carbon--}}
                            {{ number_format($income->amount,2) }}
                        </td>
                        <td>
                            <button class="mt-2 btn btn-sm btn-primary" wire:confirm="Are you sure"
                                    wire:click="remove({{ $income->id }})">
                                <span>Remove</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
    @endvolt
