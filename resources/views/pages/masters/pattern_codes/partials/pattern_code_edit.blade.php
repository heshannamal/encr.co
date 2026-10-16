<form action="{{ route('pattern_codes.update', $patternCode->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row ml-3 mr-3">
        <div class="col-md-6 mt-3">
            <label class="form-label">Product name <span class="text-danger">*</span></label><br>
            <select class="form-control form-input" id="edit_sub_product_id" name="edit_sub_product_id" required>
                @foreach ($subProducts as $subProduct)
                    <option value="{{$subProduct->id}}" @if ($subProduct->id == $patternCode->sub_product_id) selected @endif>
                        {{$subProduct->product_name ?? ''}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mt-3">
            <div class="row flex_set">
                <div class="col-md-12 max_width01">
                    <div class="">
                        <label class="form-label">Patter Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input" id="edit_pattern_code" name="edit_pattern_code" value="{{ $patternCode->pattern_code }}" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4" id="edit_attributes">
            <label class="form-label">Attrbutes</label>
            <div class="row">
                @forelse ($attributes as $attribute)
                    <div class="col-md-4 mb-2" style="padding: 0px;">
                        <div class="custom-control custom-checkbox toggle-checkbox">
                            <input id="pattern_attribute_{{$attribute->id}}" name="pattern_attribute[]" type="checkbox" value="{{$attribute->id}}" class="custom-control-input pattern_attribute_class"
                            @if (in_array($attribute->id, json_decode($patternCode->pattern_attribute))) checked @endif>
                            <label class="custom-control-label" for="pattern_attribute_{{$attribute->id}}">&nbsp;{{$attribute->attribute_name}}&nbsp;</label>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <h5><i> No Attributes to Select </i></h5>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 control-btns">
            <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
            @if (Gate::check('delete pattern code'))
                <button type="button" class="btn btn-danger btn-custom" onclick="deletePatternCode({{$patternCode->id}})">Delete</button>
            @endif
            @if (Gate::check('edit pattern code'))
                <button type="submit" class="btn btn-success btn-custom">Update</button>
            @endif
        </div>
    </div>
</form>
