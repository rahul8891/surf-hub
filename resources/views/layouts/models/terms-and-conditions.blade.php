<div class="modal fade uploadModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><img src="img/logo_small.png">{{ __($terms->title)}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img alt="close button" src="img/close.png">
                </button>
            </div>
            <div class="modal-body">
                {!! __($terms->body) !!}
            </div>
        </div>
    </div>
</div>