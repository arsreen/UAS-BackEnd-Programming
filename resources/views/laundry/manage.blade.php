@extends('layouts.app')

@section('content')
<style>
    .container-fluid {
        padding: 0 15px;
        margin-top: 50px;
    }
</style>

<div class="container-fluid">
    <form action="/laundry" id="manage-laundry" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $laundry->id ?? '' }}">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_name" class="control-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" value="{{ $laundry->customer_name ?? '' }}">
                    </div>
                </div>
                @if(isset($laundry))
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="custom-select browser-default">
                            <option value="0" {{ $laundry->status == 0 ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $laundry->status == 1 ? 'selected' : '' }}>Processing</option>
                            <option value="2" {{ $laundry->status == 2 ? 'selected' : '' }}>Ready to be Claimed</option>
                            <option value="3" {{ $laundry->status == 3 ? 'selected' : '' }}>Claimed</option>
                        </select>
                    </div>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="remarks" class="control-label">Remarks</label>
                    <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control">{{ $laundry->remarks ?? '' }}</textarea>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="laundry_category_id" class="control-label">Laundry Category</label>
                        <select class="custom-select browser-default" id="laundry_category_id">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-price="{{ $category->price }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="weight" class="control-label">Weight</label>
                        <input type="number" step="any" min="1" value="1" class="form-control text-right" id="weight">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="add_to_list" class="control-label">&nbsp;</label>
                        <button class="btn btn-info btn-sm btn-block" type="button" id="add_to_list"><i class="fa fa-plus"></i> Add to List</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered" id="list">
                    <colgroup>
                        <col width="30%">
                        <col width="15%">
                        <col width="25%">
                        <col width="25%">
                        <col width="5%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-center">Category</th>
                            <th class="text-center">Weight(kg)</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($laundry) && $laundry->items)
                        @foreach($laundry->items as $item)
                        <tr data-id="{{ $item->id }}">
                            <td>
                                <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                <input type="hidden" name="laundry_category_id[]" value="{{ $item->laundry_category_id }}">
                                {{ optional($item->category)->name ?? 'N/A' }}
                            </td>
                            <td><input type="number" class="text-center" name="weight[]" value="{{ $item->weight }}"></td>
                            <td class="text-right"><input type="hidden" name="unit_price[]" value="{{ $item->unit_price }}">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right"><input type="hidden" name="amount[]" value="{{ $item->amount }}"><p>{{ number_format($item->amount, 2) }}</p></td>
                            <td><button class="btn btn-sm btn-danger" type="button" onclick="rem_list($(this))"><i class="fa fa-times"></i></button></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="3"></th>
                            <th class="text-right" id="tamount"></th>
                            <th class="text-right"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="form-group">
                    <div class="custom-control custom-switch" id="pay-switch">
                        <input type="checkbox" class="custom-control-input" value="1" name="pay" id="paid" {{ isset($laundry->pay_status) && $laundry->pay_status == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="paid">Pay</label>
                    </div>
                </div>
            </div>
            <div class="row" id="payment" style="display: {{ isset($laundry) && $laundry->pay_status == 1 ? 'block' : 'none' }};">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tendered" class="control-label">Amount Tendered</label>
                        <input type="number" step="any" min="0" value="{{ $laundry->amount_tendered ?? 0 }}" class="form-control text-right" name="tendered">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tamount" class="control-label">Total Amount</label>
                        <input type="number" step="any" min="1" value="{{ $laundry->total_amount ?? 0 }}" class="form-control text-right" name="tamount" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="change" class="control-label">Change</label>
                        <input type="number" step="any" min="1" value="{{ $laundry->amount_change ?? 0 }}" class="form-control text-right" name="change" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Function to calculate total amount
        function calc() {
            var total = 0;
            $('#list tbody tr').each(function() {
                var _this = $(this);
                var weight = _this.find('[name="weight[]"]').val();
                var unit_price = _this.find('[name="unit_price[]"]').val();
                var amount = parseFloat(weight) * parseFloat(unit_price);
                _this.find('[name="amount[]"]').val(amount);
                _this.find('[name="amount[]"]').siblings('p').html(parseFloat(amount).toLocaleString('en-US', {
                    style: 'decimal',
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                total += amount;
            });
            $('[name="tamount"]').val(total);
            $('#tamount').html(parseFloat(total).toLocaleString('en-US', {
                style: 'decimal',
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
        }

        // Trigger calculation if laundry data exists
        if ('{{ isset($laundry) }}' == 1) {
            calc();
        }

        // Payment toggle functionality
        if ($('[name="pay"]').prop('checked') == true) {
            $('[name="tendered"]').attr('required', true);
            $('#payment').show();
        } else {
            $('#payment').hide();
            $('[name="tendered"]').attr('required', false);
        }

        $('#pay-switch').click(function() {
            if ($('[name="pay"]').prop('checked') == true) {
                $('[name="tendered"]').attr('required', true);
                $('#payment').show('slideDown');
            } else {
                $('#payment').hide('SlideUp');
                $('[name="tendered"]').attr('required', false);
            }
        });

        // Calculate change on input change
        $('[name="tendered"],[name="tamount"]').on('keyup keydown keypress change input', function() {
            var tend = $('[name="tendered"]').val();
            var amount = $('[name="tamount"]').val();
            var change = parseFloat(tend) - parseFloat(amount);
            change = parseFloat(change).toLocaleString('en-US', {
                style: 'decimal',
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
            $('[name="change"]').val(change);
        });

        // Add item to list
        $('#add_to_list').click(function() {
            var cat = $('#laundry_category_id').val(),
                _weight = $('#weight').val();
            if (cat == '' || _weight == '') {
                alert('Fill the category and weight fields first.');
                return false;
            }
            if ($('#list tr[data-id="' + cat + '"]').length > 0) {
                alert('Category already exists.');
                return false;
            }
            var price = $('#laundry_category_id option[value="' + cat + '"]').attr('data-price');
            var cname = $('#laundry_category_id option[value="' + cat + '"]').html();
            var amount = parseFloat(price) * parseFloat(_weight);
            var tr = $('<tr></tr>');
            tr.attr('data-id', cat);
            tr.append('<input type="hidden" name="item_id[]" value=""><td><input type="hidden" name="laundry_category_id[]" value="' + cat + '">' + cname + '</td>');
            tr.append('<td><input type="number" class="text-center" name="weight[]" value="' + _weight + '"></td>');
            tr.append('<td class="text-right"><input type="hidden" name="unit_price[]" value="' + price + '">' + (parseFloat(price).toLocaleString('en-US', {
                style: 'decimal',
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            })) + '</td>');
            tr.append('<td class="text-right"><input type="hidden" name="amount[]" value="' + amount + '"><p>' + (parseFloat(amount).toLocaleString('en-US', {
                style: 'decimal',
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            })) + '</p></td>');
            tr.append('<td><button class="btn btn-sm btn-danger" type="button" onclick="rem_list($(this))"><i class="fa fa-times"></i></button></td>');
            $('#list tbody').append(tr);
            calc();
            $('[name="weight[]"]').on('keyup keydown keypress change', function() {
                calc();
            });
            $('[name="tendered"]').trigger('keypress');

            $('#laundry_category_id').val('');
            $('#weight').val('');
        });

        // Remove item from list
        window.rem_list = function(_this) {
            _this.closest('tr').remove();
            calc();
            $('[name="tendered"]').trigger('keypress');
        }

        // Form submission with AJAX
       // Form submission with AJAX
$('#manage-laundry').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            console.log(resp);
            if (resp.status == 1) {
                alert('Data successfully added');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else if (resp.status == 2) {
                alert('Data successfully updated');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            var err = JSON.parse(xhr.responseText);
            alert('Error: ' + err.message); // Menampilkan pesan error dari respons JSON
        }
    });
});

    });
</script>
@endsection
