<template>
  <!-- Confirm modal -->
  <div>
    <div class="btn btn-default hidden" style="display:none;" ref="confirm_modal" data-toggle="modal" data-target=".confirm-modal-sm"></div>
    <div class="modal fade confirm-modal-sm" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Confirm the deletion</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
              Close
            </button>
            <a type="button" class="btn btn-primary" :href="route">Confirm</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'confirm-booking-deletion',
  props: ['route', 'active'],
  data: () => ({}),
  watch: {
    active(val) {
      if(val) {
        this.$refs.confirm_modal.click();
        this.$emit('close-modal')
      }
    },
  },
};
</script>
