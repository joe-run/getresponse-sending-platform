jQuery(document).ready(function(e) {
	jQuery('.grsp-test-button').click(function(e) {
      jQuery('.grsp-test').val('yes');
      jQuery('.grsp-main-submit-button').trigger('click');
      return false;
   })
});
