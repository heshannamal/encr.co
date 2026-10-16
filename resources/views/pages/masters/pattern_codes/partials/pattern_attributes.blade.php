<label class="form-label">Attrbutes</label>
<div class="row">
    @forelse ($attributes as $attribute)
        <div class="col-md-4 mb-2" style="padding: 0px;">
            <div class="custom-control custom-checkbox toggle-checkbox">
                <input id="pattern_attribute_{{$attribute->id}}" name="pattern_attribute[]" type="checkbox" value="{{$attribute->id}}" class="custom-control-input pattern_attribute_class">
                <label class="custom-control-label" for="pattern_attribute_{{$attribute->id}}">&nbsp;{{$attribute->attribute_name}}&nbsp;</label>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <h5><i> No Attributes to Select </i></h5>
        </div>
    @endforelse
</div>
