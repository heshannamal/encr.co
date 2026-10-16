<style>

</style>


<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="remake_item_modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" style="height: 95vh;overflow-x: scroll;">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remake/Back-ord</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-custom" onclick="remake_items()">RE-MAKE</button>
            <button type="button" class="btn btn-info btn-custom"data-container="body" data-toggle="popover" data-placement="top" data-content="This item under development">BACK-ORDER</button>
            <button type="button" class="btn btn-danger btn-custom" data-dismiss="modal">CLOSE</button>

        </div>
      </div>
    </div>
  </div>

<script>
    // Initialize Select2
    $(document).ready(function () {
        $(".select2_remake").select2({
            tags: true,
            dropdownParent: $('#remake_item_modal'),
        });

        // Example array of options to add
        var optionsArray = [
            { id: 'Item damaged', text: 'Item damaged' },
            { id: 'item not sent', text: 'item not sent' },
            { id: 'Color change required', text: 'Color change required' },
            { id: 'Size need to be change', text: 'Size need to be change' },
            { id: 'Incorrect fabric', text: 'Incorrect fabric' },
        ];

        // Function to add options to Select2
        function addOptionsToSelect2(optionsArray) {
            // Loop through the array and add each option
            for (var i = 0; i < optionsArray.length; i++) {
                var option = optionsArray[i];
                var newOption = new Option(option.text, option.id, false, false);
                $('.select2_remake').append(newOption).trigger('change');
            }
        }

        // Add options to Select2
        addOptionsToSelect2(optionsArray);
    });
</script>
