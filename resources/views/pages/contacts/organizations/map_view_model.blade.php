<style>
    .mapouter{
        position:relative;text-align:right;height:620px;width:100%;;
    }
    .gmap_canvas {
        overflow:hidden;background:none!important;height:620px;width:100%;;
    }
</style>
<div class="modal fade" id="map_view_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mapouter">
                    <div class="gmap_canvas" id="frame_container">
                        {{-- <iframe width="1000" height="620" id="gmap_canvas" src="https://maps.google.com/maps?q=enrich%20arcane&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                        </iframe>
                        <a href="https://123movies-to.org"></a>
                        <br>
                        <a href="https://www.embedgooglemap.net"></a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
