<div class="modal fade" id="OfferModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      @livewire('admin.offer.page')
  </div>
</div>
@section('script')
@parent
<script type="text/javascript">
  window.addEventListener('CloseOfferModal', event => {
    $("#OfferModal").modal("hide");
  });
  window.addEventListener('OpenOfferModal', event => {
    $("#OfferModal").modal("show");
  });
</script>
@stop