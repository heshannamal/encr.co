<div class="modal fade" id="sort-category-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="min-height: 80vh;">
        <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem;;background-color: #f1f1f1;">
          <h5 class="modal-title" style="font-size: 1.3rem;color: grey;">Sort Categories</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                <table class="draggable-row-category" id="sort-category-table">

                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" style="background-color: #8cd4ef;color:white" class="btn btn-secondary" data-dismiss="modal">Done</button>
        </div>
      </div>
    </div>
</div>
<script>
$(document).ready(function() {

    UpdateCommonCategoryArray();

    $(document).on('click', '.sort_category', function() {
        $(".se-pre-con").fadeIn('slow');
        $('#sort-category-modal').modal('show');

        $('#sort-category-table').empty();

        product_category_common.forEach(function(category) {
            $('#sort-category-table').append(
                `<tr data-id="${category.id}">
                    <td><i class="fa fa-bars drag-handle" aria-hidden="true"></i></td>
                    <td>${category.category_name}</td>
                </tr>`
            );
        });

        $('#sort-category-table').sortable({
            items: 'tr',
            handle: '.drag-handle',
            cursor: 'move',
            containment: 'parent',
            update: function(event, ui) {
                $(".se-pre-con").fadeIn('slow');
                var orderedIds = [];
                $('#sort-category-table tr').each(function() {
                    orderedIds.push($(this).data('id'));
                });

                var reorderedCategories = [];
                orderedIds.forEach(function(id) {
                    var category = product_category_common.find(function(cat) {
                        return cat.id === id;
                    });
                    if (category) {
                        reorderedCategories.push(category);
                    }
                });

                product_category_common = reorderedCategories;

                var categoryIds = product_category_common.map(function(cat) {
                    return cat.id;
                });

                $.ajax({
                    url: '{{ route("store.update_store_category_order") }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        store_id: $('#store_id').val(),
                        order_text: JSON.stringify(categoryIds),
                    },
                    success: function(response) {
                        console.log('Categories reordered successfully:', response);
                    },
                    error: function(xhr) {
                        console.error('Failed to update category order:', xhr.responseText);
                    }
                });
                loadProducts();
            }
        });

        $(".se-pre-con").fadeOut('slow');
    });

});
</script>
