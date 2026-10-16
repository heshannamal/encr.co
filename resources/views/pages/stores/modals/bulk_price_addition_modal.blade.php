
<!--Price Addition Modal -->
<div class="modal fade" id="bulk_price_addition"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBulkPriceAdditionLabel">Bulk Price Addition</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bulk_price_addition_form">
                    @csrf
                    <div class="col-md-12 mb-3">
                        <label for="price_bulk_addition_name" class="form-label">Price addition name</label>
                        <input type="text" class="form-control" id="price_bulk_addition_name" placeholder="Price Addition Name">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="is_bulk_addition_value" class="form-label">Price addition type</label>
                        <table style="width: 60%;">
                            <tr style="border: none; font-size: .8rem;color:black">
                                <td>
                                    <input type="radio" value="1" name="is_bulk_addition_value" id="is_bulk_addition_value"> Value ($)
                                </td>
                                <td>
                                    <input type="radio" value="0" name="is_bulk_addition_value" id="is_bulk_addition_value"> Percentage (%)
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="bulk_addition_value" class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0.00" class="form-control" name="bulk_addition_value" id="bulk_addition_value" placeholder="Amount">
                    </div>
                    <div class="col-md-12 mt-3 d-flex align-items-center">
                        <input type="checkbox" name="hide_from_customer" id="bulk_mandotary" class="mr-1">
                        <label for="bulk_mandotary" class="form-label-info mt-1 mb-0">Hide from customers</label>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="bulk_addition_description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" name="bulk_addition_description" id="bulk_addition_description" cols="30" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save_bulk_price_addition">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#bulk_price_addition').on('hidden.bs.modal', function () {
            $('#bulk_price_addition_form')[0].reset();

            $('input[name="is_bulk_addition_value"]').prop('checked', false);

            $('#bulk_mandotary').prop('checked', false);

            $('#addBulkPriceAdditionLabel').text('Add Price Addition');
        });
    });
</script>
